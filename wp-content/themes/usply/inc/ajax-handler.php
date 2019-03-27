<?

$valid_actions = [
	'get_career_information',
	'get_location_information',
	'get_consultant_information',
	'get_general_information',
	'get_search',
	'get_insight_posts',
];

define('DOING_AJAX', true);
define('SHORTINIT', !in_array($_REQUEST['action'], ['get_general_information']));

include '../../../../wp-load.php';

header('Content-Type: text/html');
send_nosniff_header();
header('Cache-Control: no-cache');
header('Pragma: no-cache');

include_once ABSPATH.WPINC.'/meta.php';
include_once ABSPATH.WPINC.'/class-wp-post.php';
include_once ABSPATH.WPINC.'/class-wp-term.php';
include_once ABSPATH.WPINC.'/post.php';
include_once ABSPATH.WPINC.'/formatting.php';
include_once ABSPATH.WPINC.'/kses.php';
include_once ABSPATH.WPINC.'/link-template.php';
include_once ABSPATH.WPINC.'/theme.php';
include_once WP_CONTENT_DIR.'/mu-plugins/utility-functions.php';
include_once ABSPATH.WPINC.'/default-constants.php';
wp_plugin_directory_constants();

$action = sanitize_title($_REQUEST['action']);
if(empty($action) || !in_array($action, $valid_actions)) die('-1');

$candidate_img_id = 9396;

$ret = [];

switch($action) {

	// CAREER APPLICATION FORM POPUP //
	case 'get_career_information':
		include_once ABSPATH.WPINC.'/shortcodes.php';
		include_once ABSPATH.WPINC.'/media.php';
		include_once get_template_directory().'/functions.php';
		include_once get_template_directory().'/inc/utility-functions.php';
		new TeamClass;
        
		$careers = get_option('__website_cache_metadata_careers');

		$career_id = intval($_REQUEST['career']);
		$career = isset($careers[$career_id]) ? $careers[$career_id] : null;
        $position = $career->post_title;
        
		if(empty($career)) die('-1');
        
        $html = 
            '<div>
                <div class="general-image">
                    ';
                    ob_start();
					if(!empty($candidate_img_id)) {
						$imgs = rmb_img_srcset($candidate_img_id, ['photo_hero_1x', 'photo_hero_2x', 'photo_hero_3x']);
						$img = rmb_build_image($imgs, '100vw', ['bg-img'], 'Submit my application');
						echo $img;
					}
                    $html .= ob_get_clean().'
                </div>
            </div>';
		
		$ret = [
			'tile' => $html,
			'cta' => 'Submit my application',
			'heading' => 'I Want to Apply:<br> '.$position,
			'content' => 'We are always looking for new talent to join our team. We encourage you to submit your resume below.',
		];
        
		break; 
        
	// LOCATION FORM POPUP //
	case 'get_location_information':
		include_once ABSPATH.WPINC.'/shortcodes.php';
		include_once ABSPATH.WPINC.'/media.php';
		include_once ABSPATH.WPINC.'/post-template.php';
		include_once get_template_directory().'/functions.php';
		include_once get_template_directory().'/inc/utility-functions.php';
		new LocationsClass;

		$locations = get_option('__website_cache_metadata_locations');

		$location_id = intval($_REQUEST['location']);
		$location = isset($locations[$location_id]) ? $locations[$location_id] : null;

		if(empty($location)) die('-1');

		$ret = [
			'cta' => 'Send <span class="desktop">&nbsp;our '.$location->name.' office&nbsp;</span> your inquiry',
			'tile' => partial('section.location.tile', [
				'location' => $location,
				'show_email' => false,
				'show_location_info' => false,
				'is_ajax' => true,
			], false),
			'heading' => 'How can we help you?',
			'content' => 'Thank you for your interest in Caldwell’s '.$location->name.' office. Contact us today to let us know how we can help.',
		];
		break;

	// CONSULTANT FORM POPUP //
	case 'get_consultant_information':
		include_once ABSPATH.WPINC.'/shortcodes.php';
		include_once ABSPATH.WPINC.'/media.php';
		include_once get_template_directory().'/functions.php';
		include_once get_template_directory().'/inc/utility-functions.php';
		new TeamClass;

		$team_id = intval($_REQUEST['consultant']);
		$post_type = get_post_type($team_id);
        
		
		if(!in_array($post_type, ['leader', 'consultant', 'director'])) die(-1);
		
		$team = get_option($post_type == 'leader' ? '__website_cache_metadata_leaders' : '__website_cache_metadata_team_members');
		$team_member = isset($team[$team_id]) ? $team[$team_id] : null;
		
		if(empty($team_member)) die('-1');
		
        $photo = (!empty($team_member->images->wide))?$team_member->images->wide:$team_member->images->headshot;
        // $class = (!empty($team_member->images->wide))?'':'smaller';
        $class = '';
        $photo_size = (!empty($team_member->images->wide))?'consultant_headshot_wide':'consultant_headshot';
        
        $html = 
        '<div>
            <div class="consultant-headshot '.$class.'">';
			$img = '';
			if (!empty($photo)) {
				$meta_key = 'consultant_photo_headshot';
				if($team_member->post_type == 'leader') $meta_key = 'leader_photo_headshot';
				elseif($team_member->post_type == 'director') $meta_key = 'director_photo_headshot';
				$attachment_id = get_post_meta($team_member->ID, $meta_key, true); // TODOIMAGE: replace with utility function on TeamClass
				$attachment_id = absint($attachment_id);
				$imgs = rmb_img_srcset($attachment_id, [$photo_size.'_1x', $photo_size.'_2x', $photo_size.'_3x']);
				$img = rmb_build_image($imgs, '100vw', ['bg-img', 'bg-img-center-right'], esc_attr($team_member->first_name));
			}
			if (!empty($img)) $html .= $img;
		$html .= '
            </div>
            <div class="consultant-details">'.partial('section.consultant.tile', [
                    'team_member' => $team_member,
                    'show_headshot' => false,
                    'show_practice_leadership' => true,
                    'show_locations' => true,
                    'show_profile_link' => false,
                    'is_leaders' => $post_type == 'leader',
                    'is_directors' => $post_type == 'director',
					'is_ajax' => true,
            ], false).'
            </div>
        </div>'; 
		
		$ret = [
			'tile' => $html,
			'cta' => 'Email '.$team_member->first_name,
			'heading' => 'How can I help you?',
			'content' => 'I am here to help you in any way I can. Please fill out the form below and I will reach out to you shortly.',
		];
		break;

	// SEARCH //
	case 'get_search':
		$ret = [
			'tile' => null,
			'cta' => 'Show matching results',
			'heading' => 'Enter your keywords below to begin your search',
			'content' => null,
		];
		break;
	
	// GENERAL INFO //
	case 'get_general_information':
		include_once ABSPATH.WPINC.'/shortcodes.php';
		include_once ABSPATH.WPINC.'/media.php';
		include_once get_template_directory().'/functions.php';
		include_once get_template_directory().'/inc/utility-functions.php';
		new TeamClass;
		
$html = 
'<div>
	<div class="general-image">
		';
		ob_start();
		if(!empty($candidate_img_id)) {
			$imgs = rmb_img_srcset($candidate_img_id, ['consultant_headshot_large_1x', 'photo_hero_1x', 'photo_hero_2x', 'photo_hero_3x']);
			$img = rmb_build_image($imgs, '100vw', ['bg-img'], 'Are you a candidate?');
			echo $img;
		}
		$html .= ob_get_clean().'
	</div>
</div>';
		
		$ret = [
			'tile' => $html,
			'cta' => 'Submit my inquiry',
			'heading' => 'How can we help you?',
			'content' => 'Thank you for your interest in Caldwell. Contact us today to let us know how we can help.',
		];
		break;

	// INSIGHT TILES //
	case 'get_insight_posts':
		include_once ABSPATH.WPINC.'/pluggable.php';
		include_once ABSPATH.WPINC.'/class-wp-tax-query.php';
		include_once ABSPATH.WPINC.'/taxonomy.php';
		include_once ABSPATH.WPINC.'/class-wp-query.php';
		include_once ABSPATH.WPINC.'/class-wp-meta-query.php';
		include_once ABSPATH.WPINC.'/user.php';
		include_once ABSPATH.WPINC.'/class-wp-user.php';
		include_once ABSPATH.WPINC.'/capabilities.php';
		include_once ABSPATH.WPINC.'/l10n.php';
		include_once ABSPATH.WPINC.'/shortcodes.php';

		partial('section.insight.list', [
			'heading' => null,
			'current_page' => intval($_REQUEST['cp']),
			'posts_per_page' => intval($_REQUEST['pp']),
			'offset_top_tiles' => false,
			'return_tiles' => true,
			'category_id' => intval($_REQUEST['cc']),
			'service_ids' => explode('|', $_REQUEST['sd']),
			'is_ajax' => true,
		], false);
		
		
		$tiles = $_SESSION['last_tiles'];
		unset($_SESSION['last_tiles']);
		
		$ret = [
			'tiles' => $tiles,
		];
		break;
}

die(json_encode($ret));