<?php
class FormsClass
{
	protected $form_fields, $form_configurations, $current_form, $current_form_name, $current_object, $current_object_type;
	protected $form_errors, $api_errors;
    
	function __construct() {
		$this->form_errors = [];
		$this->api_errors = [];
		$this->generateFormFields();
		$this->generateFormConfigurations();
		$this->registerHooks(); 
        $this->registerFormSubmissionManager();
	}
	
	private function registerHooks() {
		add_action('phpmailer_init', function($phpmailer) {
			$phpmailer->isSMTP();
			$phpmailer->Host = 'smtp.office365.com';
			$phpmailer->SMTPAuth = true;
			$phpmailer->Port = 587;
			$phpmailer->SMTPSecure = 'tls';
			$phpmailer->SMTPAutoTLS = false;
			$phpmailer->Username = 'mailer@caldwellpartners.com';
			$phpmailer->Password = '3Ase$Ufr';
			$phpmailer->SetFrom('mailer@caldwellpartners.com', 'Caldwell Partners');
			$phpmailer->addReplyTo('mailer@caldwellpartners.com', 'Caldwell Partners');
		});

		if(!is_live()) {
			add_action('wp_mail_failed', function($wp_error) {
				echo "<pre>";
				print_r($wp_error);
				echo "</pre>";
			}, 10, 1);
		}
		
		$this->verifyFormSubmission();

		add_filter('validation_method_name', function($method) {
			if($method == 'captcha') $method = 'required';
			return $method;
		}, 10, 1);
		
		add_action('wp_enqueue_scripts', function() {
			$this->enqueueScripts();
		}, 1e3, 0);
	}
	
	protected function enqueueScripts() {
		wp_enqueue_script('forms');
        wp_enqueue_script('google-recaptcha');
	}
	
	protected function generateFormFields() {
		global $website_settings;
        
		$this->form_fields = [
			'first_name' => [
				'type' => 'text',
				'label' => 'First Name:',
				'errors' => [
					'required' => 'Please enter your first name.',
				],
				'include_in_email_template' => true,
			],
			'last_name' => [
				'type' => 'text',
				'label' => 'Last Name:',
				'errors' => [
					'required' => 'Please enter your last name.',
				],
				'include_in_email_template' => true,
			],
			'country' => [
				'type' => 'text',
				'label' => 'Country:',
				'errors' => [
					'required' => 'Please select a country.',
				],
				'include_in_email_template' => true,
			],
			'postal_code' => [
				'type' => 'text',
				'label' => 'Postal/ZIP Code:',
				'errors' => [
					'required' => 'Please enter your postal/ZIP code.',
				],
				'include_in_email_template' => true,
			],
			'last_name' => [
				'type' => 'text',
				'label' => 'Last Name:',
				'errors' => [
					'required' => 'Please enter your last name.',
				],
				'include_in_email_template' => true,
			],
            'company' => [
				'type' => 'text',
				'label' => 'Company:',
				'errors' => [
					'required' => 'Please enter your company.',
				],
				'include_in_email_template' => true,
			],
            'title' => [
				'type' => 'text',
				'label' => 'Title:',
				'errors' => [
					'required' => 'Please enter your title.',
				],
				'include_in_email_template' => true,
			],
			'looking_for' => [
				'type' => 'select',
				'label' => 'What are you looking for?',
				'errors' => [
					'required' => 'Tell us what you\'re looking for.',
				],
				'default' => 'What are you looking for?',
				'options' => [
					'I am looking for an executive for my team' => 'I am looking for an executive for my team',
					'I am looking for my next role' => 'I am looking for my next role',
					'Other' => 'Other',
				],
				'include_in_email_template' => true,
			],
			'email_address' => [
				'type' => 'email',
				'label' => 'Email:',
				'errors' => [
					'required' => 'Please enter your email address.',
					'emailTLD' => 'Please enter a valid email address.',
				],
				'include_in_email_template' => true,
			],
			'phone_number' => [
				'type' => 'tel',
				'label' => 'Phone:',
				'errors' => [
					'required' => 'Please enter your phone number.',
					// 'phoneUS' => 'Please enter a valid phone number.',
				],
				'include_in_email_template' => true,
			],
			'comment' => [
				'type' => 'textarea',
				'label' => 'Comment:',
				'errors' => [
					'required' => 'Please enter a comment.',
				],
				'include_in_email_template' => true,
			],
            'resume' => [
				'type' => 'file',
				'label' => 'CV/Resume:',
				'errors' => [
					'requiredFile' => 'Please upload your CV/resume',
				],
				'include_in_email_template' => true,
			],
            'resume:hidden' => [
				'type' => 'file',
				'label' => 'CV/Resume:',
				'errors' => [
					'requiredFile' => 'Please upload your CV/resume',
				],
				'include_in_email_template' => true,
			],
			'g-recaptcha-response' => [
				'type' => 'captcha',
				'label' => '',
				'errors' => [
					'captcha' => 'Please verify that you are not a robot.',
				],
				'key' => $website_settings->recaptcha->site_key,
				'include_in_email_template' => false,
			],
		];
	}
	
	public function generateForm($form_name) {
		$config = json_decode(json_encode(isset($this->form_configurations[$form_name]) ? $this->form_configurations[$form_name] : null)); # array to object
		if(empty($config)) return;
        
		partial('form', [
			'instance' => $this,
			'form_name' => $form_name,
			'form_class' => isset($config->form_class)?$config->form_class:null, 
			'cta_class' => isset($config->cta_class)?$config->cta_class:null, 
			'rows' => $config->rows, 
			'tabs' => isset($config->tabs)?$config->tabs:null, 
			'cta' => $config->cta,
			'required' => !empty($config->required) ? $config->required : [],
			'form_hash' => $this->getHashFromFormName($form_name),
			'form_errors' => $this->form_errors,
			'api_errors' => $this->api_errors,
			'hidden' => !empty($config->hidden) ? $config->hidden : [],
		]);
		
		$rules = [];
		$messages = [];
		
		foreach($config->rows as $row) {
			foreach($row as $ff) {
				$field = $this->getField($ff);
                if(isset($field)) {
                    if($field->type == 'date') {
                        wp_enqueue_style('pickadate-css');
                        wp_enqueue_script('pickadate-js');
                    }
                    elseif($field->type == 'tel') {
                        wp_enqueue_script('masked-input');
                    }
                    if(!in_array($ff, $config->required)) continue;
                    foreach($field->errors as $method => $message) {
                        $method = apply_filters('validation_method_name', $method);
                        $rules[$ff][$method] = true;
                        $messages[$ff][$method] = $message;
                    }
                }
			}
		}
	}
	
	final public function getField($field_name) {
		return isset($this->form_fields[$field_name]) ? (object)$this->form_fields[$field_name] : null;
	}
	
	protected function generateFormConfigurations() {
        $this->form_configurations['team'] = [
			'cta' => 'Submit my inquiry',
			'rows' => [
				['first_name', 'last_name'],
				['phone_number', 'email_address'],
				['company','title'],
				['looking_for'],
				['resume'],
				['comment'],
				['cta'],
			],
			'required' => [
				'first_name', 
				'last_name', 
				'email_address', 
				'phone_number', 
				'g-recaptcha-response',
			],
			'subject' => 'Caldwell Partners - Team Form Submission',
			'recipients' => '',
			'cc' => '',
			'bcc' => '',
			'supports_email_notification' => true,
			'custom_template' => false,
			'thank_you_page' => get_permalink(10299),
		];
		
        $this->form_configurations['location'] = [
			'cta' => 'Submit my inquiry',
			'rows' => [
				['first_name', 'last_name'],
				['phone_number', 'email_address'],
				['company','title'],
				['looking_for'],
				['resume'],
				['comment'],
				['cta'],
			],
			'required' => [
				'first_name', 
				'last_name', 
				'email_address', 
				'phone_number', 
				'g-recaptcha-response',
			],
			'subject' => 'Caldwell Partners - Location Form Submission',
			'recipients' => '',
			'cc' => '',
			'bcc' => '',
			'supports_email_notification' => true,
			'custom_template' => false,
			'thank_you_page' => get_permalink(10305),
		];
		
        $this->form_configurations['career'] = [
			'cta' => 'Submit my inquiry',
			'rows' => [
				['first_name', 'last_name'],
				['email_address', 'resume'], 
                ['comment'],
                ['cta'],
			],
			'required' => [
				'first_name', 
				'last_name', 
				'email_address', 
				'resume', 
				'g-recaptcha-response',
			],
			'subject' => 'Caldwell Partners - Caldwell Careers Application',
			'recipients' => '',
			'cc' => '',
			'bcc' => '',
			'supports_email_notification' => true,
			'custom_template' => false,
			'thank_you_page' => get_permalink(10313),
		];
        
        global $careers;
        
        $this->form_configurations['career']['hidden']['career-location'] = ''; 
        
        $this->form_configurations['general'] = [
			'cta' => 'Submit my inquiry',
			'rows' => [
				['first_name', 'last_name'],
				['phone_number', 'email_address'],
				['company','title'],
				['country', 'postal_code'],
				['looking_for'],
				['resume'],
				['comment'],
				['cta'],
			],
			'required' => [
				'first_name', 
				'last_name', 
				'email_address', 
				'phone_number', 
				'g-recaptcha-response',
			],
			'subject' => 'Caldwell Partners - General Form Submission',
			'recipients' => '',
			'cc' => '',
			'bcc' => '',
			'supports_email_notification' => true,
			'custom_template' => false,
			'thank_you_page' => get_permalink(10304),
		];
	}
	
	protected function validateFormField($field_name, $errors, $value) {
        global $website_settings;
		foreach($errors as $method => $message) {
			$pass = true;
			switch($method) {
				case 'phoneUS':
					if(preg_match('/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/', $value) !== 1) $pass = false;
					break;
				case 'emailTLD':
					if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) $pass = false;
					break;
				case 'captcha':
					if(!strlen($value)) $pass = false;
					else {
						$response = json_decode(wp_remote_retrieve_body(wp_remote_get('https://www.google.com/recaptcha/api/siteverify?'.http_build_query([
							'secret' => $website_settings->recaptcha->secret_key,
							'response' => $value,
							'remoteip' => $_SERVER['REMOTE_ADDR'],
						]))));

						if(empty($response->success)) $pass = false;
					}
					break;
                case 'requiredFile':
					$found_file_key = $this->getResumeFileKey();
                    if(isset($_FILES[$found_file_key]) && !strlen($_FILES[$found_file_key]['name'])) $pass = false;
					break;
				default:
					if(!strlen($value) && (!in_array($field_name, ['resume', 'resume:hidden']))) $pass = false;
					break;
			}
			if(!$pass) {
				return $message;
			}
		}
		
		return null;
	}
	
	private function getHashFromFormName($form_name) {
		return rtrim(base64_encode(substr(hash('ripemd160', $form_name), 1, 11)), '=');
	}
	
	private function getFormFromHash($hash) {
		foreach($this->form_configurations as $name => $_) {
			if($this->getHashFromFormName($name) == $hash) return $name;
		}
		return null; 
	}
    
    protected function getFormErrors() {
		$data = $_POST;
		$errors = [];
		foreach($this->current_form->required as $ff) {
			$field = $this->getField($ff);
			$error = $this->validateFormField($ff, $field->errors, !isset($data[$ff]) ? null : $data[$ff]);
			if(!empty($error)) $errors[$ff] = $error;
		}
        return $errors;
    }
    
	final protected function verifyFormSubmission() {
        if(!empty($_POST) && !empty($_POST['__f'])) {
			# Find form from hash
			$form_name = $this->getFormFromHash($_POST['__f']);
			if(empty($form_name)) return;
			$this->current_form_name = $form_name;
			$this->current_form = (object)$this->form_configurations[$form_name];
			
            $this->form_errors = $this->getFormErrors();
            if(empty($this->form_errors)) {
				$this->processFormSubmission();
            }
        }
    }
	
	private function getTemplateBody() {
		$template_file = empty($this->current_form->custom_template) ? 'default' : $this->current_form_name;
		$email_template = get_template_directory().'/inc/email-templates/'.$template_file.'.tpl';
		if(!file_exists($email_template)) return '';
		
		$data = sanitize_array_for_output($_POST);
		
		$fields = [];
		
		if(in_array($this->current_object_type, ['consultant', 'leader', 'director'])) {
			$fields['Team Member:'] = $data['team_member'];
			$fields['Team Member URL:'] = $data['team_member_url'];
		}
		
		elseif(in_array($this->current_object_type, ['location'])) {
			$fields['Location:'] = $data['location'];
			$fields['Location URL:'] = $data['location_url'];
		}
        
        elseif(in_array($this->current_object_type, ['career'])) {
			$fields['Position:'] = $data['career'];
			$fields['Position URL:'] = $data['career_url'];
			$fields['Position Location:'] = $data['career_location'];
		}
		
		foreach($this->current_form->rows as $row) {
			foreach($row as $ff) {
				$field = $this->getField($ff);
                if(isset($field)) {
				    if($field->include_in_email_template && !empty($field->label)) $fields[$field->label] = !isset($data[$ff]) ? '' : $data[$ff];
                }
			}
		}
		$fields['Timestamp'] = $data['timestamp_formatted'].' (UTC-5)';
		$fields['IP Address'] = $data['ip_address'];
		
		$field_rows = [];
		foreach($fields as $k => $v) {
			if(!strlen($v)) $v = 'N/A';
			$field_rows[] = '<b>'.$k.'</b> '.$v;
		}

		$data['fields'] = implode('<br><br>', $field_rows);
		
		$content = file_get_contents($email_template);
		foreach($data as $k => $v) $content = str_replace('[%'.$k.'%]', $v, $content);
		return $content;
	}
	
	protected function invokeAPI() { 
		$data = sanitize_array_for_output($_POST);
		
		if($this->current_form_name == 'team') {
			global $team;
			$team->loadData();
			
			if(empty($data['eid'])) {
				$this->api_errors[] = 'We were unable to send a message to this team member.';
				return false;
			}
			$object_id = intval($data['eid']);
			
			if(isset($team->team_members[$object_id])) {
				$this->current_object = $team->team_members[$object_id];
				$this->current_object_type = 'consultant';
			}
			elseif(isset($team->leaders[$object_id])) {
				$this->current_object = $team->leaders[$object_id];
				$this->current_object_type = 'leader';
			}
			elseif(isset($team->directors[$object_id])) {
				$this->current_object = $team->directors[$object_id];
				$this->current_object_type = 'director';
			}
			else {
				$this->api_errors[] = 'We were unable to send a message to this team member.';
				return false;
			}
			
			if(empty($this->current_object->email)) {
				$this->api_errors[] = 'We were unable to send a message to this team member.';
				return false;
			}
			
			if(!is_live()) {
				$this->current_form->recipients = 'DevOps <devops@mdgadvertising.com>';
				$this->current_form->cc = '';
				$this->current_form->bcc = '';
			}
			else {
				$this->current_form->recipients = $this->current_object->email;
				$this->current_form->cc = '';
				$this->current_form->bcc = 'Caroline Lomot <clomot@caldwellpartners.com>';
			}
		}
		
		elseif($this->current_form_name == 'location') {
			global $locations;
			$locations->loadData();
			
			if(empty($data['eid'])) {
				$this->api_errors[] = 'We were unable to send a message to this location.';
				return false;
			}
			$object_id = intval($data['eid']);
			
			if(isset($locations->locations[$object_id])) {
				$this->current_object = $locations->locations[$object_id];
				$this->current_object_type = 'location';
			}
			else {
				$this->api_errors[] = 'We were unable to send a message to this location.';
				return false;
			}
			
			if(empty($this->current_object->email)) {
				$this->api_errors[] = 'We were unable to send a message to this location.';
				return false;
			}

			if(!is_live()) {
				$this->current_form->recipients = 'DevOps <devops@mdgadvertising.com>';
				$this->current_form->cc = '';
				$this->current_form->bcc = '';
			}
			else {
				$this->current_form->recipients = $this->current_object->email;
				$this->current_form->cc = '';
				$this->current_form->bcc = 'Caroline Lomot <clomot@caldwellpartners.com>';
			}
		}
		
		elseif($this->current_form_name == 'general') {
			if(!is_live()) {
				$this->current_form->recipients = 'DevOps <devops@mdgadvertising.com>';
				$this->current_form->cc = '';
				$this->current_form->bcc = '';
			}
			else {
				$this->current_form->recipients = 'leaders@caldwellpartners.com';
				$this->current_form->cc = '';
				$this->current_form->bcc = 'Caroline Lomot <clomot@caldwellpartners.com>';
			}
		}
        
        elseif($this->current_form_name == 'career') {
            global $careers;
           // $careers->loadData();
            $careers = get_option('__website_cache_metadata_careers');
            
			$object_id = intval($data['eid']);
           
			if(isset($careers[$object_id])) {
				$this->current_object = $careers[$object_id];
				$this->current_object_type = 'career';
			}
			else {
				$this->api_errors[] = 'We were unable to send a message about this application.';
				return false;
			}
            
			if(!is_live()) {
				$this->current_form->recipients = 'DevOps <devops@mdgadvertising.com>';
				$this->current_form->cc = '';
				$this->current_form->bcc = '';
			}
			else {
				$this->current_form->recipients = 'careers@caldwellpartners.com';
				$this->current_form->cc = '';
				$this->current_form->bcc = 'Caroline Lomot <clomot@caldwellpartners.com>';
			}
		}
	}
	
	private function getResumeFileKey() {
		$ret = '';
		foreach(array_keys($_FILES) as $k) if(starts_with($k, 'resume_')) {
			$ret = $k;
			break;
		}
		return $ret;
	}
	
	protected function processFormSubmission() {
		$this->invokeAPI();
		
		$row_values = []; foreach($this->current_form->rows as $row) $row_values = array_merge($row_values, $row);
	
		if(in_array('resume', $row_values) || in_array('resume:hidden', $row_values)) {
            define('MAX_FILE_COUNT', 5); 
            define('MAX_FILE_SIZE_MB', 5);
            define('MAX_FILE_SIZE', MAX_FILE_SIZE_MB*1024*1024);

            define('RESUME_DIRECTORY', WP_CONTENT_DIR.'/uploads/resumes/');
            define('RESUME_URL', WP_CONTENT_URL.'/uploads/resumes/');

			$found_file_key = $this->getResumeFileKey();

            $file = !empty($_FILES[$found_file_key]) ? $_FILES[$found_file_key] : null;
            $key = in_array('resume', $row_values) ? 'resume' : 'resume:hidden';

			if(!in_array('resume:hidden', $row_values) || $_REQUEST['looking_fornn'] == 'I am looking for my next role') {
				if(!empty($file)) {
					if(!strlen($file['tmp_name'])) {
						if(in_array('resume', $this->current_form->required)) {
							$this->api_errors[] = 'We were unable to process your file. Please try again.';
						}
					}
					else {
						// Check if there was a server-related reason why the file could not be uploaded
						if($file['error'] != UPLOAD_ERR_OK) {
							$this->api_errors[] = 'The server responded with error code ' . $file['error'] . '.';
						}

						// Check the file is empty
						elseif($file['size'] == 0) {
							$this->api_errors[] = 'The file "'.$file['name'].'" is empty.';
						}

						// Check if the file exceeds the maximum size restriction
						elseif($file['size'] > MAX_FILE_SIZE) {
							$this->api_errors[] = 'This file "'.$file['name'].'" is too large (max: '.MAX_FILE_SIZE_MB.' MiB).'; 
						}

						// Check if the file has a valid extension
						elseif(!$this->hasValidExtension($file['name'])) {
							$this->api_errors[] = 'This file "'.$file['name'].'" cannot be uploaded. Only photos, videos and documents are allowed.'; 
						}

						// If server-side validation succeeded, return the path to the file.
						else {
							$parts = pathinfo($file['name']);
							$filename = str_replace(' ', '_', $parts['filename']).'_'.time().'.'.$parts['extension'];
							if(!file_exists(RESUME_DIRECTORY)) mkdir(RESUME_DIRECTORY, 0755);
							move_uploaded_file($file['tmp_name'], RESUME_DIRECTORY.$filename);
							$_POST[$key] = RESUME_URL.$filename;
						}
					}
				}
			}
        }
        
		if(!count($this->api_errors)) {
			$this->appendPostData();
			$this->captureLead();
			if($this->current_form->supports_email_notification) $this->sendEmailNotification();
			$this->processRedirect();
		}
	}
	
	private function appendPostData() {
		if(!isset($_POST['timestamp_formatted'])) {
			$date = new DateTime(current_time('Y-m-d H:i:s'), new DateTimeZone('America/Chicago'));
			$date->setTimezone(new DateTimeZone('America/Toronto'));
			$_POST['timestamp_formatted'] = $date->format('F j, Y, g:i a');
		}
		if(!isset($_POST['timestamp_sql'])) $_POST['timestamp_sql'] = current_time('mysql');
		if(!isset($_POST['ip_address'])) $_POST['ip_address'] = $_SERVER['REMOTE_ADDR'];
		if(!isset($_POST['subject'])) $_POST['subject'] = $this->current_form->subject;
		if(!is_live()) $_POST['subject'] = '(DEV) '.$_POST['subject'];
		
		if(in_array($this->current_object_type, ['consultant', 'leader', 'director'])) {
			$_POST['team_member'] = $this->current_object->name;
			$_POST['team_member_url'] = get_permalink($this->current_object->ID);
			$_POST['subject'] .= ' - '.$_POST['team_member'];
		}
		elseif(in_array($this->current_object_type, ['location'])) {
			$_POST['location'] = $this->current_object->name;
			$_POST['location_url'] = get_permalink($this->current_object->ID);
			$_POST['subject'] .= ' - '.$_POST['location'];
		}
        elseif(in_array($this->current_object_type, ['career'])) {
			$_POST['career'] = $this->current_object->post_title;
			$_POST['career_url'] = get_permalink($this->current_object->ID);
			$_POST['career_location'] = $_POST['career-location'];
			$_POST['subject'] .= ' - '.$_POST['career'];
		}
    }
    
    private function captureLead() {
		global $wpdb;
		$wpdb->query($wpdb->prepare('insert into form_submissions(ID, form, ip_address, timestamp, metadata) values(NULL, %s, %s, %s, %s)',
			$this->current_form_name,
			$_POST['ip_address'],
			$_POST['timestamp_sql'],
			json_encode(sanitize_array_for_output($_POST))
		));
    }
	
    private function sendEmailNotification() {
		# Construct headers
		$headers = [
			'From: Caldwell Partners <mailer@caldwellpartners.com>',
			'Content-Type: text/html; charset=utf-8',
		];
		if(!empty($this->current_form->cc)) $headers[] = 'Cc: '.$this->current_form->cc;
		if(!empty($this->current_form->bcc)) $headers[] = 'Bcc: '.$this->current_form->bcc;
		
		# Deploy email
		if(!is_live()) $this->current_form->subject = '(DEV) '.$this->current_form->subject;
		wp_mail($this->current_form->recipients, $this->current_form->subject, $this->getTemplateBody(), $headers);
    }
    
    protected function processRedirect() {
        wp_redirect($this->current_form->thank_you_page, 302);
        exit;
    }
    
    protected function hasValidExtension($file) {
		$extensions = array('eps','3g2','3gp','3gpp','aif','aiff','asf','au','avi','dat','divx','doc','docx','dv','dwf','dwg','f4v','fdr','flv','gif','giff','htm','html','jfif','jpeg','jpg','m2ts','m4a','m4v','mdb','mid','midi','mkv','mod','mov','mp3','mp4','mpe','mpeg','mpeg4','mpegps','mpg','mts','nsv','odt','ogg','ogm','ogv','pdf','pic','pict','png','pps','ppsx','ppt','pptx','psd','pub','qt','ra','ram','rm','rmi','rtf','rv','swf','tga','tif','tiff','tod','ts','txt','vob','wav','wma','wmf','wmv','wpd','wps','xls','xlsx','zip');
		return in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions);
	}
	
	//=======================================================================
	
	final protected function getStateList() {
		return [
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'District Of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',
		];
	}
    
    public function on_form_submission_manager() {
		include_once get_template_directory().'/inc/form-submissions/form_submission_manager.php';
		if(function_exists('displaySubmissions')) displaySubmissions();
	}

	private function registerFormSubmissionManager() {
		add_action('admin_menu', function() {
			$menu_id = add_menu_page(
				'Website Submissions',
				'Form Submissions',
				'manage_form_submissions',
				'form-submissions',
				[$this, 'on_form_submission_manager'],
				'dashicons-list-view',
				4
			);
			add_action("load-$menu_id", function() {
				$args = array(
					'label' => 'Number of items per page:',
					'default' => 15,
					'option' => 'submissions_per_page'
				);
				add_screen_option('per_page', $args);
			});
		});

		add_filter('set-screen-option', function($status, $option, $value) {
		  return $value;
		}, 10, 3);

		add_action('init', function() {
			add_role('form_manager', 'Form Manager', array());
		});

		add_action('admin_init', function() {
			$role = get_role('administrator');
			$role->add_cap('manage_form_submissions');

			$role = get_role('form_manager');
			$role->add_cap('read');
			$role->add_cap('manage_form_submissions');
			$role->add_cap('unfiltered_html');
		});

		//=====================================[SUBMISSION EXPORT]=====================================//
		add_action('admin_init', function() {
			global $wpdb;
			
			$wpdb->query("
			CREATE TABLE IF NOT EXISTS `form_submission_notes` (
			`ID` int(11) NOT NULL,
			`userID` int(11) NOT NULL,
			`formName` varchar(100) NOT NULL,
			`formID` int(11) NOT NULL,
			`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`note` text NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			");

			$wpdb->query("
			CREATE TABLE IF NOT EXISTS `form_submissions` (
			`ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`form` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
			`ip_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
			`timestamp` timestamp NULL DEFAULT NULL,
			`metadata` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
			PRIMARY KEY (`ID`)
			) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
			");
			
			if(isset($_GET['export'])) {
				include_once get_template_directory().'/inc/form-submissions/form_submission_manager.php';
				global $wpdb;
				$where = '';
				
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				
				if(!in_array($current, get_all_views())) return;
				
				$form = $current;

				$db = null;

		        $mapping = array(
		            'general' => 'general',
		            'team' => 'team',
		            'location' => 'location',
		            'career' => 'career',
		        );
		        $form = $mapping[$current];
		        $results = $wpdb->get_results("select * from form_submissions where form='$form' order by timestamp desc;");

				ob_start();
				$fh = fopen('php://output', 'w');
				
				// Preprocess all results
				foreach($results as $k => $r) {
					$metadata = (array)json_decode($r->metadata);
					$data = (array)$r;
					unset($data['metadata']);
					/*unset($metadata['form_name'], $metadata['email_address'], $metadata['user_port'], $metadata['submit'], $metadata['submit_btn'], $metadata['fields_message'], $metadata['message'], $metadata['fields_comments'], $metadata['email_address_confirm'], $metadata['g-recaptcha-response'], $metadata['timestamp'], $metadata['ip'], $metadata['fields_first_name'], $metadata['first_name'], $metadata['last_name'], $metadata['fields_last_name'], $metadata['name'], $metadata['fields_name'], $metadata['email'], $metadata['submit']);*/

					$data = array_merge($data, $metadata);
		            
					$data['form_id'] = get_form_name($current);
					
					$previous_notes = $wpdb->get_results($wpdb->prepare('select * from form_submission_notes where formName=%s and formID=%d order by timestamp desc', $form, $r->id));
					$notes = [];
					foreach($previous_notes as $note) {
						$user_data = get_userdata($note->userID);
						$username = '';
						if(!empty($user_data->display_name)) $username = $user_data->display_name;
						else $username = $user_data->user_login;
						$attribution = $username.'; '.date('F j, Y, g:i A', strtotime($note->timestamp));
						$notes[] = $note->note.PHP_EOL.'- '.$attribution;
					}
					$data['notes'] = implode(PHP_EOL.'---------------------------------'.PHP_EOL, $notes);
					
					$r->data = $data;
				}
				
				// Fetch a unique array of all keys
				$keys = array();
				$mapped_keys = array();
				foreach($results as $r) foreach($r->data as $k => $v) if(!in_array($k, $keys)) $keys[] = $k;
				foreach($keys as $k => $v) {
					if(empty($key_label_mapping[$v])) {
						unset($keys[$k]);
					}
					else {
						$mapped_keys[$k] = $key_label_mapping[$v];
					}
				}
		 
				// Export the header column
				fputcsv($fh, $mapped_keys);
				
				// Export all data
				foreach($results as $r) {
					$data = array();
					foreach($keys as $key) {
						if(isset($r->data[$key])) $data[] = stripslashes($r->data[$key]);
						else $data[] = 'N/A';
					}
					fputcsv($fh, $data);
				}
				
				fclose($fh);
				
				$contents = ob_get_clean();
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=\"submission-export_".date('m-d-Y_h-i-sa').'.csv\"');
				// header("Content-Type: application/force-download");
				// header("Content-Type: application/octet-stream");
				// header("Content-Type: application/download");
				header("Content-Description: File Transfer");
				header('Connection: Keep-Alive');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Pragma: no-cache");
				// header('Pragma: public');
				header('Content-Length: '.strlen($contents));
				echo $contents;

				exit;
			}
		});
	}
}