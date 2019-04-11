<?
global $services;

if(function_exists('acf_add_local_field_group')) {
	$menu_order = 1;

	acf_add_local_field_group([
		'key' => 'side_page_settings',
		'title' => 'Page Settings',
		'fields' => [
			[
				'key' => 'page_trademark_footer',
				'name' => 'page_trademark_footer',
				'label' => 'Show ™ Disclaimer in Footer',
				'type'  => 'true_false',
				'ui'	=> true,
			],
		],
		'position' => 'side',
		'style' => 'normal',
		'location' => [
			[[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			]],
		],
		'menu_order' => $menu_order++,
	]);
 
    acf_add_local_field_group([
		'key' => 'homepage_settings',
		'title' => 'Homepage Settings',
		'fields' => [
            [
				'key' => 'tab_homepage_slide_settings',
                'name' => 'tab_homepage_slide_settings',
                'label' => 'Slider Settings',
                'type' => 'tab',
            ],
			[
				'required' => true,
				'key'   => 'homepage_slide_heading',
				'label' => 'Heading',
				'name'  => 'homepage_slide_heading',
				'type'  => 'text',
			],
			[
				'key'   => 'homepage_slide_expertise_image',
				'label' => 'Expertise Image',
				'name'  => 'homepage_slide_expertise_image',
				'type'  => 'image',
				'wrapper' => [
					'width' => 50,
				],
			],
			[
				'key'   => 'homepage_slide_functional_roles_image',
				'label' => 'Functional Roles Image',
				'name'  => 'homepage_slide_functional_roles_image',
				'type'  => 'image',
				'wrapper' => [
					'width' => 50,
				],
			],
			[
                'key'   => 'homepage_slide_copy',
                'label' => 'Slide Copy',
                'name'  => 'homepage_slide_copy',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Slide',
				'min' => 4,
				'max' => 4,
                'sub_fields' => [
                    [
						'required' => true,
                        'key'   => 'slide_heading',
                        'label' => 'Heading',
                        'name'  => 'slide_heading',
                        'type'  => 'text',
                    ],[
						'required' => true,
                        'key'   => 'slide_content',
                        'label' => 'Content',
                        'name'  => 'slide_content',
                        'type'  => 'wysiwyg',
                    ],
                    [
						'required' => true,
						'key' => 'slide_cta_page',
						'name' => 'slide_cta_page',
						'label' => 'CTA Page',
						'type' => 'post_object',
						'allow_null' => false,
						'multiple' => false,
						'return_format' => 'id',
						'wrapper' => [
							'width' => 50,
						],
                    ],
                    [
						'required' => true,
                        'key'   => 'slide_cta_text',
                        'label' => 'CTA Text',
                        'name'  => 'slide_cta_text',
                        'type'  => 'text',
						'wrapper' => [
							'width' => 50,
						],
                    ],
                ],
            ],
			[
				'key' => 'tab_homepage_candidate_settings',
                'name' => 'tab_homepage_candidate_settings',
                'label' => 'Candidate Settings',
                'type' => 'tab',
            ],
			[
				'required' => true,
				'key'   => 'homepage_candidate_background_image',
				'label' => 'Background Image',
				'name'  => 'homepage_candidate_background_image',
				'type'  => 'image',
			],
			[
				'required' => true,
				'key'   => 'homepage_candidate_heading',
				'label' => 'Heading',
				'name'  => 'homepage_candidate_heading',
				'type'  => 'text',
			],
			[
				'required' => true,
				'key'   => 'homepage_candidate_content',
				'label' => 'Content',
				'name'  => 'homepage_candidate_content',
				'type'  => 'wysiwyg',
			],
			[
				'required' => true,
				'key' => 'homepage_candidate_cta_page',
				'name' => 'homepage_candidate_cta_page',
				'label' => 'CTA Page',
				'type' => 'post_object',
				'allow_null' => false,
				'multiple' => false,
				'return_format' => 'id',
				'wrapper' => [
					'width' => 50,
				],
			],
			[
				'required' => true,
				'key'   => 'homepage_candidate_cta_text',
				'label' => 'CTA Text',
				'name'  => 'homepage_candidate_cta_text',
				'type'  => 'text',
				'wrapper' => [
					'width' => 50,
				],
			],
            [
				'key' => 'tab_homepage_insights_settings',
                'name' => 'tab_homepage_insights_settings',
                'label' => 'Insights Settings',
                'type' => 'tab',
            ],
			[
				'required' => true,
				'key'   => 'homepage_insights_heading',
				'label' => 'Insights Heading',
				'name'  => 'homepage_insights_heading',
				'type'  => 'text',
			],
		],
		'position' => 'normal',
		'location' => [[[
			'param' => 'page',
			'operator' => '==',
			'value' => get_option('page_on_front'),
		]]],
		'menu_order' => 0,
	]);
 
}