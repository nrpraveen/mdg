<?php
	
//=====================================[SHARED]=====================================//
	$key_label_mapping = array(
		'id' => 'Submission ID',
		'form_id' => 'Form Name',
		'first_name' => 'First Name',
		'last_name' => 'Last Name',
		'name' => 'Name',
		'fields_name' => 'Name',
		'email' => 'Email',
		'email_address' => 'Email',
		'email_address_confirm' => 'Email Address (Confirm)',
		'recipients' => 'Notification Email Recipients',
		'subject' => 'Notification Email Subject',
		'eid' => 'Entity ID',
		'location' => 'Location Name',
		'location_url' => 'Location URL',
		'team_member' => 'Team Member Name',
		'team_member_url' => 'Team Member URL',
		'timestamp_formatted' => 'Timestamp (Formatted)',
		'timestamp_sql' => 'Timestamp (ISO 8601)',
		
		'company' => 'Company',
		'country' => 'Country',
		'address_1' => 'Address 1',
		'address_2' => 'Address 2',
		'city' => 'City',
		'state' => 'State',
		'zip_code' => 'ZIP Code',
		'zip' => 'ZIP Code',
		'phone' => 'Phone Number',
		'phone_number' => 'Phone Number',
        
		'position' => 'Position',
	
		'g-recaptcha-response' => '',
		'timestamp' => 'Timestamp',
		'ip' => 'IP Address',
		'ip_address' => 'IP Address',
		'notes' => 'Notes',
		
		'type_of_inquiry' => 'Type of Inquiry',
		'questions_comments' => 'Questions/comments',
		'fields_comments' => 'Questions/comments',
		'message' => 'Questions/comments',
		'fields_message' => 'Questions/comments',
		'comment' => 'Questions/comments',
		
		'utm_source' => 'Campaign Source (utm_source)',
		'utm_medium' => 'Campaign Medium (utm_medium)',
		'utm_term' => 'Campaign Term (utm_term)',
		'utm_content' => 'Campaign Content (utm_content)',
		'utm_campaign' => 'Campaign Name (utm_campaign)',
	);
	
	function get_initial_form() {
		return get_all_views()[0];
	}
	
	function get_all_views() {
		return ['general', 'team', 'location', 'career'];
	}
	
	function is_valid_form_name($form_id) {
		return in_array($form_id, get_all_views());
	}
	
	function get_form_name($form_id) {
		if(!is_valid_form_name($form_id)) return 'Other';

		switch($form_id) {
			case 'general':
				return 'General'; 
				break;
			case 'team':
				return 'Team';
				break;
			case 'location':
				return 'Location';
				break;
			case 'career':
				return 'Career'; 
				break;
			default:
				return 'Unknown';
				break;
		}
	}

	//=====================================[SUBMISSION DETAILS]=====================================//

	if(!empty($_GET['page']) && $_GET['page'] == 'form-submissions' && !empty($_GET['submission']) && is_numeric($_GET['submission'])) {
		if(!empty($_POST)) {
			global $wpdb;
			$form = $_POST['form_name'];
			$id = $_POST['form_id'];
			$note = $_POST['note'];
			$user_id = get_current_user_id();
			
			if(strlen($form) && strlen($id) && strlen($note) && !empty($user_id)) {
				$wpdb->query($wpdb->prepare('insert into form_submission_notes (userID, formName, formID, note) values(%d,%s,%d,%s)', $user_id, $form, $id, $note));
			}
		}
		include 'single-form-submission.php';
	}
	
	//=====================================[SUBMISSION LISTING]=====================================//
	else {
		if(!class_exists('WP_List_Table')) require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
        
		class Form_Submissions_Table extends WP_List_Table {
			private $_items_per_page = 0;
			private $_item_total_count = 0;
            
            public $mapping = array(
                    'team' => 'team',
                    'location' => 'location',
                    'general' => 'general',
                    'career' => 'career',
                );
			
			function get_columns() {
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				$columns = [
					'name' => 'Name',
					'submission-date' => 'Date',
					'email' => 'Email',
					'phone' => 'Phone',
				];
				$columns['notes'] = '# Notes';
				return $columns;
			}
			function get_sortable_columns() {
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				return array(
					'submission-date'  => array('submission-date', false),
					//'name' 	=> array('name', false),
					//'email' => array('email', false),
				);
			}
			function no_items() {
				echo 'There are currently no form submissions.';
			}
			function get_views(){
				global $wpdb;
				$ret = array();
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				foreach(get_all_views() as $form_id) $ret[$form_id] = '<a href="admin.php?page=form-submissions&form-name='.$form_id.'" '.($form_id == $current ? 'class="current"' : '').'>'.get_form_name($form_id).' <span class="count">('.$this->get_total_for_form($form_id, true).')</span></a>';
				return $ret;
			}
			function column_name($item) {
				$url = 'admin.php?page=form-submissions&submission='.$item['id'].'&form='.$item['current']; 
				$value = '<strong><a class="row-title" href="'.$url.'">'.$item['name'].'</a></strong> ('.$item['ip_address'].')';
				$actions = array(
					'view-details' => '<a href="'.$url.'">View Details</a>',
					'print-submission' => '<a target="_blank" href="'.$url.'&print">Print Submission</a>',
				);
				return sprintf('%1$s %2$s', $value, $this->row_actions($actions));
			}
			function column_default($item, $column) {
				return $item[$column];
			}
			function is_viewing_all_forms() {
				return empty($_REQUEST['form-name']) || $_REQUEST['form-name'] == get_initial_form();
			}
			function get_current_form_name() {
				return get_form_name(isset($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
			}
			function get_limit_query() {
				$current_page =  $this->get_pagenum(); if(empty($current_page)) $current_page = 1;
				$items_per_page = $this->_items_per_page;
				$limit = ' LIMIT '.(($current_page - 1)*$items_per_page).','.$items_per_page;
				return $limit;
			}
			function get_where_query() {
				$str = '';

				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());

				if(!empty($_REQUEST['s'])) {
					$search = array_filter(explode(' ', $_REQUEST['s']));
					foreach($search as $k => $v) $search[$k] = ' metadata LIKE "'.esc_sql('%'.strtolower(trim($v)).'%').'" ';
					$query = implode(' OR ', $search);
					if(!empty($str)) $str = $str.' AND '.$query;
					else $str = $query;
				}
				
				if(empty($str)) $str = ' 1 ';
				return $str;
			}
			function get_orderby_query() {
				$orderby = empty($_REQUEST['orderby']) ? '' : $_REQUEST['orderby'];
				$order = empty($_REQUEST['order']) ? '' : $_REQUEST['order'];
				$default = ' ORDER BY timestamp desc ';
				
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				
				if(empty($orderby) || (strcasecmp($order, 'asc') && strcasecmp($order, 'desc'))) return $default;
				elseif($orderby == 'submission-date') return ' ORDER BY timestamp '.$order.' ';
				elseif($orderby == 'name') {
					return ' ORDER BY concat(first_name," ", last_name) '.$order.' ';
				}
				elseif($orderby == 'email') {
					return ' ORDER BY email_address '.$order.' ';
				}
				elseif($orderby == 'order') {
					return ' ORDER BY order '.$order.' ';
				}
				else return $default;
			}
			function extra_tablenav($a) {
				if(!count($this->items)) return;
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				$url = admin_url('admin.php?page=form-submissions&form-name='.$current.'&export');
				echo '<style>.alignleft.actions.bulkactions{display:none;}</style><div class="alignleft actions"><a class="button button-primary" style="margin-bottom:1em;" href="'.$url.'">Export '.$this->get_current_form_name().' Submissions</a></div>';
			}
			function get_total_for_form($form = null, $formatted = true, $today = false) {
                global $wpdb;
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
				if(empty($form)) {
					$form = $current;
					$where = $this->get_where_query();
				}
				else $where = '1';
				
				$where_date = '1';
				if($today === true) {
					$date = new DateTime(current_time('Y-m-d H:i:s'), new DateTimeZone('America/Chicago'));
					$date->setTimezone(new DateTimeZone('America/Toronto'));
					$where_date = ' timestamp >= "'.$date->format('Y-m-d 00:00:00').'" ';
				}

                $form = $this->mapping[$form];
                $submissions = $wpdb->get_results("select count(*) as `count` from form_submissions where form='$form' AND ($where_date) AND ($where)");
				return $formatted ? number_format($submissions[0]->count) : $submissions[0]->count;
			}
			function get_items() {
				global $wpdb;
				$items = array();
				$limit = $this->get_limit_query();
				$where = $this->get_where_query();
				$orderby = $this->get_orderby_query();
				$current = (!empty($_REQUEST['form-name']) ? $_REQUEST['form-name'] : get_initial_form());
                
				if(!in_array($current, get_all_views())) return array();
				
                $form = $this->mapping[$current];

                $submissions = $wpdb->get_results("select * from form_submissions where form='$form' and ($where) $orderby $limit;");
				// Format data
                foreach($submissions as $data) {
                    $metadata = json_decode($data->metadata);
                    $phone = 'No Phone #'; if(!empty($metadata->phone_number)) $phone = $metadata->phone_number;
                    $date = date("F j, Y, g:i a", strtotime($data->timestamp));
                    $notes = $wpdb->get_results($wpdb->prepare('select count(*) as "c" from form_submission_notes where formName=%s and formID=%d', $this->mapping[$current], $data->ID));
                    $items[] = array(
                        'submission-date' => $date,
                        'name' => implode(' ', array_filter(array($metadata->first_name, $metadata->last_name))),
                        'email' => $metadata->email_address,
                        'phone' => $phone,
                        'ip_address' => $data->ip_address,
                        'id' => $data->ID, 
                        'current' => $current,
                        'notes' => $notes[0]->c,
                    );
                }
                
				return $items;
			}
			function prepare_items() {
				$this->_items_per_page = $this->get_items_per_page('submissions_per_page', 15);
				$this->items = $this->get_items();
				$columns = $this->get_columns();
				$hidden = array();
				$sortable = $this->get_sortable_columns();
				$this->_column_headers = array($columns, $hidden, $sortable);
				
				$this->_item_total_count = $this->get_total_for_form(null, false);
				
				$this->set_pagination_args(array(
					'total_items' => $this->_item_total_count,
					'per_page'    => $this->_items_per_page
				));
			}
		}

		// This will be called from FormsClass.class.php so we can include this file from the admin_init hook (so exports will be able to be called before headers are sent)
		function displaySubmissions() {
			$table = new Form_Submissions_Table(); ?>
		<div class="wrap">
			<h2>Website Form Submissions</h2>
			<?php $table->prepare_items(); ?>
			<?php $table->views(); ?>
			<form method="get">
				<input type="hidden" name="page" value="form-submissions" />
				<?php if(!empty($_REQUEST['form-name'])): ?><input type="hidden" name="form-name" value="<?= empty($_REQUEST['form-name']) ? '' : $_REQUEST['form-name'] ?>" /><?php endif ?>
				<?php if(!empty($_REQUEST['orderby'])): ?><input type="hidden" name="orderby" value="<?= empty($_REQUEST['orderby']) ? '' : $_REQUEST['orderby'] ?>" /><?php endif ?>
				<?php if(!empty($_REQUEST['order'])): ?><input type="hidden" name="order" value="<?= empty($_REQUEST['order']) ? '' : $_REQUEST['order'] ?>" /><?php endif ?>
				<?php $table->search_box('Search', 'search-args'); ?>
			</form>
			<?php $table->display(); ?>
		</div><?php
		}
	}