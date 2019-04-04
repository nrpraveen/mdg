<?

add_action('wp_default_scripts', function($wp_scripts) { # Moves jQuery to the footer
	if(is_admin()) return;
	$wp_scripts->add_data('jquery', 'group', 1);
	$wp_scripts->add_data('jquery-core', 'group', 1);
	$wp_scripts->add_data('jquery-migrate', 'group', 1);
});

add_action('wp_enqueue_scripts', function() {
	global $website_settings;

	if(is_admin()) return;
	
	wp_enqueue_style('style', get_template_directory_uri().'/css/style.css', [], filemtime(get_template_directory().'/css/style.css'));
	
	
	if(!is_admin()) {
		wp_enqueue_script('lib-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', [], null, true);
		wp_enqueue_script('lib-mask', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js', [], null, true);
		
		wp_enqueue_script('internal-global', get_template_directory_uri().'/js/jquery.global.js', ['lib-jquery'], filemtime(get_template_directory().'/js/jquery.global.js'), true);
		
		wp_register_script('internal-forms', get_template_directory_uri().'/js/jquery.forms.js', ['lib-jquery', 'lib-mask'], filemtime(get_template_directory().'/js/jquery.forms.js'), true);
		wp_localize_script('internal-forms', 'google_recaptcha_configuration', [
			'site_key' => $website_settings->recaptcha->site_key,
			'selector_id' => 'google-recaptcha-container',
			'widget_id' => null,
		]);
		wp_enqueue_script('internal-forms'); 
		
		// Google Recaptcha'
		wp_register_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=explicit&onload=onGoogleReCaptchaLoad', [], null, true);

		// Mobile Menu
		wp_enqueue_script('mobile-menu', get_stylesheet_directory_uri().'/js/jquery.mobile-menu.js', ['lib-jquery'],  filemtime(get_template_directory().'/js/jquery.mobile-menu.js'), true);
		
		// Validation
		wp_enqueue_script('jquery-validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js', ['lib-jquery'], null, true);
		wp_enqueue_script('jquery-form-validator', get_template_directory_uri().'/js/jquery.form-validator.js', ['lib-jquery','jquery-validate'],  filemtime(get_template_directory().'/js/jquery.form-validator.js'), true);
		
		wp_register_script('masked-input', get_stylesheet_directory_uri().'/js/jquery.maskedinput.min.js', ['lib-jquery'],  filemtime(get_template_directory().'/js/jquery.maskedinput.min.js'), true);
	}
});