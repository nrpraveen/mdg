<?php
class SiteSettingsClass
{
	public
		$favicon,
		$logos,
		$social_media,
        $recaptcha,
        $google_tag_manager,
		$corporate,
		$_404,
		
		// Pages
		$page_about,
		$page_testimonials,
		
		$___ # placeholder
	;

	public function __construct() {
        if(!session_id()) session_start();
        
		$settings = get_option('__website_cache_website_settings');

		if(empty($settings) || isset($_GET['rebuild'])) {
			$this->rebuild();
		}
		else {
			if(!empty($settings) && is_object($settings)) {
				foreach(array_keys(get_object_vars($this)) as $var) {
					$this->$var = $settings->$var;
				}
			}
		}
		
		$this->registerACF();
		$this->registerHooks();
	}
	
	private function registerACF() {
		
		if(function_exists('acf_add_options_page')) {
			acf_add_options_page([
				'page_title' 	=> 'General Settings',
				'menu_title'	=> 'Website Settings',
				'menu_slug' 	=> 'site-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> false,
				'position'      => 2
			]);
			
			/*
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Widget Settings',
				'menu_title'	=> 'Widget Settings',
				'parent_slug'	=> 'site-general-settings',
			));
			*/
			
			acf_add_options_sub_page(array(
				'page_title' 	=> '404 Page',
				'menu_title'	=> '404 Page',
				'parent_slug'	=> 'site-general-settings',
			));
		}
		if(function_exists('acf_add_local_field_group')) {
			$page_fields = [];
			foreach($this->getPageVars() as $v) {
				$page_fields[] = [
					'required' => true,
					'key' => $v,
					'name' => $v,
					'label' => ucwords(str_replace('_', ' ', str_replace('page_', '', $v))).' Page',
					'type' => 'post_object',
					'allow_null' => false,
					'multiple' => false,
					'return_format' => 'id',
				];
			}
			
			# 404 Page
			$menu_order = 0;
			acf_add_local_field_group([
				'key' => '404_page',
				'title' => '404 Page',
				'fields' => [
					[
						'key' => '404_page_title_line_1',
						'label' => 'Title (Line 1)',
						'name' => '404_page_title_line_1',
						'type' => 'text',
						'wrapper' => [
							'width' => 50,
						],
					],
					[
						'key' => '404_page_title_line_2',
						'label' => 'Title (Line 2)',
						'name' => '404_page_title_line_2',
						'type' => 'text',
						'wrapper' => [
							'width' => 50,
						],
					],
					[
						'key' => '404_page_content',
						'label' => 'Content',
						'name' => '404_page_content',
						'type' => 'textarea',
					],
					[
						'key'   => '404_page_hero_photo',
						'label' => 'Hero Photo',
						'name'  => '404_page_hero_photo',
						'type'  => 'image',
						'instructions' => '',
						'return_format' => 'id',
						'preview_size' => 'full',
					],
				],
				'position' => 'normal',
				'location' => [[[ 
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-404-page',
				]]],
				'menu_order' => $menu_order++,
			]);
			

			$menu_order = 0;

            acf_add_local_field_group([
                'key' => 'page-settings',
                'title' => 'Page Settings',
                'fields' => $page_fields,
				'position' => 'side',
                'location' => [[[
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'site-general-settings',
                ]]],
				'menu_order' => $menu_order++,
            ]);
			
			acf_add_local_field_group([
                'key' => 'general_settings',
                'title' => 'General Settings',
                'fields' => [
                    [
                        'key' => 'corporate_information_tab',
                        'label' => 'Corporate Information',
                        'name' => 'corporate_information_tab',
                        'type' => 'tab',
                    ],
                    [
                        'key' => 'corporate_name',
                        'name' => 'corporate_name',
                        'label' => 'Name',
						'required' => true,
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'corporate_legal_name',
                        'name' => 'corporate_legal_name',
                        'label' => 'Legal Name',
						'required' => true,
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'corporate_address',
                        'name' => 'corporate_address',
                        'label' => 'Address',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'corporate_address_line_2',
                        'name' => 'corporate_address_line_2',
                        'label' => 'Address 2',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'corporate_city',
                        'name' => 'corporate_city',
                        'label' => 'City',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'corporate_state',
                        'name' => 'corporate_state',
                        'label' => 'State',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'corporate_zip',
                        'name' => 'corporate_zip',
                        'label' => 'ZIP',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'corporate_phone',
                        'name' => 'corporate_phone',
                        'label' => 'Phone',
                        'type' => 'text',
					'instructions' => '<strong>IMPORTANT:</strong> Format numbers as +[country code] [local number separated by spaces]. Ex: +1&nbsp;888&nbsp;366&nbsp;3827',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'corporate_fax',
                        'name' => 'corporate_fax',
                        'label' => 'Fax',
                        'type' => 'text',
					'instructions' => '<strong>IMPORTANT:</strong> Format numbers as +[country code] [local number separated by spaces]. Ex: +1&nbsp;888&nbsp;366&nbsp;3827',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'corporate_toll_free_phone',
                        'name' => 'corporate_toll_free_phone',
                        'label' => 'Toll Free Phone',
                        'type' => 'text',
					'instructions' => '<strong>IMPORTANT:</strong> Format numbers as +[country code] [local number separated by spaces]. Ex: +1&nbsp;888&nbsp;366&nbsp;3827',
                        'wrapper' => [
                            'width' => 33,
                        ],
                    ],
                    [
                        'key' => 'header_tab',
                        'label' => 'Header',
                        'name' => 'header_tab',
                        'type' => 'tab',
                    ],
                    [
                        'key' => 'logo_desktop_normal',
                        'name' => 'logo_desktop_normal',
                        'label' => 'Desktop Logo (Normal)',
                        'type' => 'image',
						'mime_types' => 'svg,png',
						'library' => 'all',
						'required' => true,
						'return_format' => 'id',
						'preview_size' => 'full',
						'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'logo_desktop_reverse',
                        'name' => 'logo_desktop_reverse',
                        'label' => 'Desktop Logo (Reverse)',
                        'type' => 'image',
						'mime_types' => 'svg,png',
						'library' => 'all',
						'required' => true,
						'return_format' => 'id',
						'preview_size' => 'full',
						'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'social_media_tab',
                        'label' => 'Social Media',
                        'name' => 'social_media_tab',
                        'type' => 'tab',
                    ],
                    [
                        'key' => 'social_facebook',
                        'name' => 'social_facebook',
                        'label' => 'Facebook',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'social_twitter',
                        'name' => 'social_twitter',
                        'label' => 'Twitter',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'social_linkedin',
                        'name' => 'social_linkedin',
                        'label' => 'LinkedIn',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'social_youtube',
                        'name' => 'social_youtube',
                        'label' => 'YouTube',
                        'type' => 'url',
                    ],
                    [
                        'key' => 'integrations_tab',
                        'label' => 'Integrations',
                        'name' => 'integrations_tab',
                        'type' => 'tab',
                    ],
                    [
                        'key' => 'gtm_container_id',
                        'name' => 'gtm_container_id',
                        'label' => 'Google Tag Manager (GTM) Container ID',
                        'type' => 'text',
						'required' => true,
                        'wrapper' => [
                            'width' => 100,
                        ],
                    ],
                    [
                        'key' => 'recaptcha_site_key',
                        'name' => 'recaptcha_site_key',
                        'label' => 'reCAPTCHA Site Key',
                        'type' => 'text',
						'required' => true,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'key' => 'recaptcha_secret_key',
                        'name' => 'recaptcha_secret_key',
                        'label' => 'reCAPTCHA Secret Key',
                        'type' => 'text',
						'required' => true,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                ],
				'position' => 'normal',
                'location' => [[[
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'site-general-settings',
                ]]],
				'menu_order' => $menu_order++,
            ]);
		}
	}
	
	private function registerHooks() {
		add_action('acf/save_post', function() {
			$screen = get_current_screen();
			if(strpos($screen->id, 'website-settings_page_acf-options-') !== false || $screen->id == 'toplevel_page_site-general-settings') {
				$this->rebuild();
			}
		}, 20, 0);
	}
	
	private function getPageVars() {
		return array_filter(array_keys(get_object_vars($this)), function($v) {
			return stripos($v, 'page_') === 0;
		});
	}

	public function rebuild() {
		## LOGOS ##
		$this->logos = (object)array_filter([
			'desktop_normal' => get_field('logo_desktop_normal', 'option'),
			'desktop_reverse' => get_field('logo_desktop_reverse', 'option'),
		], 'strlen');
		
		## PAGE IDS ##
		foreach($this->getPageVars() as $v) {
			$this->$v = intval(get_field($v, 'option'));
		}

		## SOCIAL MEDIA ##
		$this->social_media = (object)array_filter([
			'facebook' => get_field('social_facebook', 'option'),
			'twitter' => get_field('social_twitter', 'option'),
			'linkedin' => get_field('social_linkedin', 'option'),
			'youtube' => get_field('social_youtube', 'option'),
		], 'strlen');
        
		## RECAPTCHA ##
        $this->recaptcha = (object)[
			'site_key' => get_field('recaptcha_site_key', 'option'),
			'secret_key' => get_field('recaptcha_secret_key', 'option'),
		];
        
		## GOOGLE TAG MANAGER (GTM) ##
        $this->google_tag_manager = (object)[
			'container_id' => get_field('gtm_container_id', 'option'),
		];
        
        ## CORPORATE ##
        $this->corporate = (object)[
			'name' => get_field('corporate_name', 'option'),
			'legal_name' => get_field('corporate_legal_name', 'option'),
			'address' => get_field('corporate_address', 'option'),
			'address2' => get_field('corporate_address_line_2', 'option'),
			'city' => get_field('corporate_city', 'option'),
			'state' => get_field('corporate_state', 'option'),
			'zip' => get_field('corporate_zip', 'option'),
            'phone' => get_field('corporate_phone', 'option'),
			'fax' => get_field('corporate_fax', 'option'),
            'toll_free_phone' => get_field('corporate_toll_free_phone', 'option'),
		];
		
		## 404 ##
		$this->_404 = (object)[
			'line_1' => get_field('404_page_title_line_1', 'option'),
			'line_2' => get_field('404_page_title_line_2', 'option'),
			'content' => get_field('404_page_content', 'option'),
			'image' => prepare_image_attributes(get_field('404_page_hero_photo', 'option'), 'photo_hero'),
		];

		update_option('__website_cache_website_settings', $this);
	}
}