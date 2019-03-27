<?php 
//=====================================[AUTOLOADER]=====================================//
spl_autoload_register(function($class_name) {
	if (strstr($class_name, '\\')) { // This allows us to use namespaces
		$class_name = explode('\\', $class_name);
		$class_name = end($class_name);
	}
    $file = get_template_directory().'/inc/classes/'.$class_name.'.class.php'; if(file_exists($file)) { include_once $file; return; }
});

//=====================================[GLOBAL CLASS INSTANCES]=====================================//
add_action('login_enqueue_scripts', function() {
	global $website_settings;
	ob_start();
	?>
    <style type="text/css">
        .login {
            background: #2b3d4f;
        }
        .login #backtoblog a, .login #nav a {
            color: #abb2ba !important;
        }
        .login form {
            background: #808c96 !important;
        }
        .login label {
            color: #fff !important;
        }
        #login h1 a, .login h1 a {
            background-image: url("<?= wp_get_attachment_url($website_settings->logos->desktop_reverse) ?>");
			height:111px;
			width:320px;
			background-size: 320px 111px;
			background-repeat: no-repeat;
        }
        .wp-core-ui .button-primary {
            background: #91d62e !important;
            border-color: #91d62e !important;
            box-shadow: none !important;
            color: #ffffff !important;
            text-decoration: none !important;
            text-shadow: none !important;
            font-weight: bold;
            border-radius: 0 !important;
        }
        .login #login_error, .login .message {
            border-left: 4px solid #91d62e !important;
        }
    </style>
	<?
	echo ob_get_clean();
});

add_filter('login_headerurl', function() { return home_url(); });

add_action('init', function() {
	if(isset($_GET['rebuild'])) flush_rewrite_rules(true);
});

add_action('wp_footer', function() {
	echo '<div id="google-recaptcha-container"></div>';
		
	if(stristr($_SERVER['HTTP_USER_AGENT'], 'Screaming Frog SEO Spider') && is_front_page()) {
		$q = new WP_Query([
			'posts_per_page' => -1,
			'post_type' => array_diff(array_values(get_post_types(['public' => true,])), ['attachment']),
		]);
		foreach($q->posts as $p) {
			echo '<a href="'.get_permalink($p->ID).'">'.get_the_title($p->post_title).'</a><br />';
		}
	}
});

$header_classes = [];
$website_settings = null;
$navigation = null;

add_action('wp_head', function() {
	if(!is_live()) return;
	global $website_settings;
?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?= $website_settings->google_tag_manager->container_id ?>');</script>
<?
});

add_action('body', function() {
	if(!is_live()) return;
	global $website_settings;
?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $website_settings->google_tag_manager->container_id ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?
});

add_action('after_setup_theme', function() {
	add_theme_support('post-thumbnails');
	
	# Preserve ordering for the following:
	global $website_settings;	$website_settings = new \SiteSettingsClass();
	global $forms;             	$forms = new \FormsClass();
    //global $structured_data;	$structured_data = new \StructuredDataClass();
    global $optimize;			$optimize = new \MDG\Optimize();
	
	include_once get_template_directory().'/inc/acf.php';
});

add_action('template_redirect', function() {
	global $wp, $website_settings;
	$slug = get_relative_permalink($website_settings->page_insights);

	if(is_404() && stripos($wp->request, $slug.'/') === 0 && strlen($wp->request) > strlen($slug.'/')) {
		wp_redirect(get_permalink($website_settings->page_insights), 302);
		exit;
	}
});

//=====================================[ACTIONS & FILTERS]=====================================//
/*
add_action('admin_init', function() {
	wp_enqueue_script('masked-input');
});
*/

add_action('admin_head', function() {
?>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
	-webkit-appearance: none; 
	margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<?
});

add_filter('pre_option_upload_url_path', function($path) {
	if(is_local()) {
		return 'http://'.HOSTNAME_DEV.'/wp-content/uploads';
	}
	return $path;
});

add_filter('user_has_cap', function($allcaps, $cap, $args) {
	if(is_local()) unset($allcaps['upload_files']);
	return $allcaps;
}, 10, 3);

//=====================================[INCLUDES]=====================================//
include_once get_template_directory().'/lib/MDG/autoload.php';
include_once get_template_directory().'/inc/less-compiler.php';
include_once get_template_directory().'/inc/reset.php';
include_once get_template_directory().'/inc/scripts.php';
include_once get_template_directory().'/inc/shortcodes.php';
include_once get_template_directory().'/inc/utility-functions.php';

# Favicon
add_action('wp_head', function() {
	/*?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/apple-touch-icon.png?v=1">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/favicon-32x32.png?v=1">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/favicon-16x16.png?v=1">
	<link rel="manifest" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/safari-pinned-tab.svg?v=1" color="#2b3d4f">
	<link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() ?>/images/favicon/favicon.ico?v=1">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="<?= get_stylesheet_directory_uri() ?>/images/favicon/browserconfig.xml?v=1">
	<meta name="theme-color" content="#2b3d4f">
	<? */
});

/*
register_image_set('photo_hero', 1440);
register_image_set('photo_sidebar', 2*288);
register_image_set('photo_homepage_slider', 2*288);
*/

add_action('init', function() {
	unregister_taxonomy_for_object_type('post_tag', 'post');
});

add_filter('template_include', function($template) {
	if(is_404()) return get_template_directory().'/templates/404.php';
	return $template;
});

add_filter('robots_txt', function($output) {
	if(!is_live()) {
	ob_start();
?>
User-agent: *
Disallow: /
<?
	return ob_get_clean();
	}
	
	return $output;
});

add_action('wp_dashboard_setup', function() {
	wp_add_dashboard_widget(
		sanitize_title('Form Submissions Summary'), 'Form Submissions Summary', function() {
			include_once get_template_directory().'/inc/form-submissions/form_submission_manager.php';
			$table = new Form_Submissions_Table();
			$forms = $table->mapping;
			?>
			<div id="dashboard_right_now">
				<p><strong>Today&rsquo;s Submissions</strong></p>
				<ul>
					<? 
					foreach($forms as $form): 
					$form_total = $table->get_total_for_form($form, false, true);
					?>
					<li class="page-count">
						<a href="<?= admin_url('admin.php?page=form-submissions&form-name='.$form) ?>"><?= get_form_name($form) ?> Form: <?= number_format($form_total) ?></a>
					</li>	
					<? endforeach ?>
				</ul>
				<hr />
				<p><strong>All-Time Submissions</strong></p>
				<ul>
					<? 
					foreach($forms as $form): 
					$form_total = $table->get_total_for_form($form, false, false);
					?>
					<li class="page-count">
						<a href="<?= admin_url('admin.php?page=form-submissions&form-name='.$form) ?>"><?= get_form_name($form) ?> Form: <?= number_format($form_total) ?></a>
					</li>	
					<? endforeach ?>
				</ul>
			</div>
			<?
		}
	);	
});
