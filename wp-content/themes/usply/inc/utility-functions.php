<?
function get_current_url() {
	global $wp;
	$prefix = (isset($_SERVER['HTTPS'])  && strtolower( $_SERVER["HTTPS"] ) == "on") ? 'https' : 'http';
	return $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$wp->request.'/';
}

function shuffle_by_value($array) {
	$temp = $array;
	shuffle($temp);
	return $temp;
}

function sanitize_array_for_output($array) {
	return array_map(function($v) { return stripslashes(trim(strip_tags(htmlentities($v)))); }, $array);
}

function compile_less() {
	$files = [
		'style.less' => 'style.css',
	];
	$less_directory = get_template_directory().'/less/';
	$css_directory =  get_template_directory().'/css/';
	
	if(!file_exists($css_directory)) mkdir($css_directory, 0755, true);
	
	foreach([
		'program.less',
		'service.less',
		'team.less',
	] as $basename) {
		if(!file_exists($less_directory.'dynamic/'.$basename)) file_put_contents($less_directory.'dynamic/'.$basename, ''); 
	}
	
	require_once  get_template_directory().'/lib/less/Less.php';
	$parser = new Less_Parser(array(
		'sourceMap'         => true,
		'compress'			=> true,
	));
	$parser->SetImportDirs($less_directory);

	foreach($files as $l => $c) {
		$less = $less_directory.$l;
		$css = $css_directory.$c;
		try {
			$parser->parseFile($less, '');
			$css_content = $parser->getCss();
			file_put_contents($css, $css_content);
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	array_map('unlink', glob($css_directory.'cache.*.min.css'));
}

function starts_with($s, $prefix){
	return strpos($s, $prefix) === 0;
}

function register_image_set($suffix, $baseline) {
	foreach(range(1,3) as $i) add_image_size($suffix.'_'.$i.'x', $baseline*$i);
}

function register_image_set_height($suffix, $baseline) {
	foreach(range(1,3) as $i) add_image_size($suffix.'_'.$i.'x', 0, $baseline*$i);
}

function is_consultants_page() {
	$title = get_the_title();
	return strtolower($title) == 'consultants';
}

function is_top_level_expertise() {
	global $post;
	return is_singular('expertise') && empty($post->post_parent);
}

function get_relative_permalink($id) {
    return get_relative_url(get_permalink($id));
}

function get_relative_url($url) {
    return trim(str_replace(site_url(), '', $url), '/');
}

function serve_404() {
	status_header(404);
	partial('section/main/404.php');
}

function toTouchTone($phone) {
	$phone = str_replace(' ', '', $phone);
    return strtr(preg_replace('/[^a-z0-9 ]/', '', strtolower($phone)), '0123456789abcdefghijklmnopqrstuvwxyz ', '0123456789222333444555666777788899990');
}

function hyphenatePhoneNumber($number) {
	$number = toTouchTone($number);
	$delimiter = '-';
	return "(".substr($number, 0, 3).") ".substr($number, 3, 3).$delimiter.substr($number, 6);
}

function get_countries() {
	return [
		'US' => 'United States',
		'AF' => 'Afghanistan',
		'AX' => 'Åland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua and Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BQ' => 'Bonaire',
		'BA' => 'Bosnia and Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Democratic Republic of Congo',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Côte d\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CW' => 'Curaçao',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island and McDonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KP' => 'Democratic People\'s Republic of Korea',
		'KR' => 'Republic of Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Réunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthélemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts and Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin (French part)',
		'PM' => 'Saint Pierre and Miquelon',
		'VC' => 'Saint Vincent and the Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome and Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SX' => 'Sint Maarten (Dutch part)',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia and the South Sandwich Islands',
		'SS' => 'South Sudan',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard and Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks and Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'UM' => 'United States Minor Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'British Virgin Islands',
		'VI' => 'U.S. Virgin Islands',
		'WF' => 'Wallis and Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	];
}

function get_states() {
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

function get_page_widgets() {
	global $website_settings;
	$widgets = [];
	
	$related_pages_menu_page_ids = [$website_settings->page_about, $website_settings->page_investor_relations];

	if(is_page($website_settings->page_executive_opportunities)) {
		$widgets[] = partial('widget.executive-opportunities', [], false);
	}
	elseif(is_page($website_settings->page_programs) || is_singular(['program', 'leader'])) {
		$widgets[] = partial('widget.section-menu', [
			'parent' => $website_settings->page_about,
		], false); 
	}
	elseif(is_singular(['director', 'quarterly-report'])) {
		$widgets[] = partial('widget.section-menu', [
			'parent' => $website_settings->page_investor_relations,
		], false); 
	}
	elseif(is_singular(['consultant'])) {
		$widgets[] = partial('widget.consultant-details', [], false);
	}
	else {
		foreach($related_pages_menu_page_ids as $page) {
			if(is_page($page) || in_array($page, get_ancestors(get_the_ID(), 'page'))) {
				$widgets[] = partial('widget.section-menu', [
					'parent' => $page,
				], false); 
				break;
			} 
		}
	}
	
	return $widgets;
}

function excerptizeCharacters($copy, $maxCharacters = 120, $retainLastWord = true, $more = '&hellip;') {
    $copy = str_replace([chr(9), chr(10), chr(13)], ' ', $copy);
    do { $copy = str_replace('  ', ' ', $copy, $count); } while($count > 0);
    $copy = strip_tags($copy);
    $copy = trim($copy);
	if(strlen($copy) <= $maxCharacters) return do_shortcode($copy);
	$copy = substr($copy, 0, $maxCharacters);
	if($retainLastWord === true) $copy = substr($copy, 0, strrpos($copy, ' '));
    $copy = rtrim($copy, '.');
	return do_shortcode($copy.$more);
}

function random_int_except($min, $max, $value) { # Ensure random order
	if(($min == $max) || ($min == $value && $max == $value)) return $min;
	$ret = null; while(($ret = random_int($min, $max)) === $value);
	return $ret;
}

function is_service_page() {
	global $services;
	return empty($services->post_types) ? false : is_singular($services->post_types);
}

function partial($path, $vars = [], $echo = true) {
	foreach($vars as $k => $v) $$k = $v;
	$path = trim(str_replace('.php', '', $path));
	$path = str_replace('.', '/', $path);
	if(!$echo) ob_start();
	$template_directory = get_template_directory();
	include $template_directory.'/partials/'.$path.'.php';
	if(!$echo) return ob_get_clean();
}

function prepare_image_attributes($attachment_id, $suffix) {
	if(empty($attachment_id)) return null;
	
	$image = wp_prepare_attachment_for_js($attachment_id);

	$sizes = [];
	foreach(range(1,3) as $size) {
		$image_url = wp_get_attachment_image_src($attachment_id, $suffix.'_'.$size.'x');
		if(!empty($image_url) && !in_array($image_url[0], $sizes)) $sizes[$size.'x'] = $image_url[0];
	}
	
	$sizes['default'] = current(array_splice($sizes, 0, 1));
	
	if(empty($sizes['default'])) $sizes = null;
	
	return $sizes;
}

function get_image_attributes($suffix, $image, array $classes = []) {
	$attributes = [];
	$srcset = [];
	$image = array_merge(['1x' => $image['default']], $image);
	foreach($image as $size => $url) if($size != 'default') $srcset[$size] = $url;
	
	$attributes = [
		'src' => $image['default'],
		'srcset' => $srcset,
	];
	
	$attributes = array_filter($attributes);
	
	$parts = [];
	
	if(isset($attributes['src'])) {
		$parts[] = 'src="'.esc_attr($attributes['src']).'"';
	}
	if(isset($attributes['srcset'])) {
		$temp = [];
		foreach($attributes['srcset'] as $size => $image) $temp[] = esc_attr($image.' '.$size);
		$parts[] = 'srcset="'.implode(', ', $temp).'"';
		if(!empty($classes)) $parts[] = 'class="'.esc_attr(implode(' ', array_unique($classes))).'"';
	}
	
	return implode(' ', $parts);
}

/**
 * Builds image array for creating srcset attribute
 * 
 * @param int|array			$attachment_id
 * @param array 			$sizes
 *
 * @return array
 */
function rmb_img_srcset($attachment_id, $sizes = ['photo_hero_1x', 'photo_hero_2x', 'photo_hero_3x']) {
	global $_wp_additional_image_sizes;
	$images = [];
	$full = wp_get_attachment_image_src($attachment_id, $size)[0];
	$initial_size = $full;
	$newsizes = array_merge([$initial_size], $sizes);
	if (is_array($attachment_id)) {
		foreach ($attachment_id as $id) {
			$image = [];
			foreach ($newsizes as $key => $size) {
				if ($size == 'full') {
					$meta = wp_get_attachment_metadata($attachment_id);
					if (array_key_exists('width', $meta)) $image[$meta['width'].'w'] = wp_get_attachment_image_src($attachment_id, $size)[0];
				} else {
					$img = wp_get_attachment_image_src($attachment_id, $size)[0];
					if (!is_null($img) && $img != $full) {
						$image[$_wp_additional_image_sizes[$size]['width'].'w'] = $img;
					}
				}
				if (!empty($image)) $images[] = $image;
			}
			array_unshift($image, $full);
		}
		return $images;
	} else {
		$image = [];
		foreach ($newsizes as $key => $size) {
			if ($size == 'full') {
				$meta = wp_get_attachment_metadata($attachment_id);
				if (array_key_exists('width', $meta)) $image[$meta['width'].'w'] = wp_get_attachment_image_src($attachment_id, $size)[0];
			} else {
				$img = wp_get_attachment_image_src($attachment_id, $size)[0];
				if (!is_null($img) && $img != $full) {
					$image[$_wp_additional_image_sizes[$size]['width'].'w'] = $img;
				}
			}
		}
		array_unshift($image, $full);
		return $image;
	}
	return false;
}

/**
 * Builds <img> tag from result of mdg_img_srcset() array above
 * 
 * @param array				$image_sizes 		Result array from mdg_img_srcset() function above
 * @param string 			$sizes 				Array of items to be build into the sizes attribute
 * @param array 			$classes 			Classes to add to the <img> tag
 * @param array 			$alt 				alt attribute to add to the <img> tag
 * @param array 			$styles 			Styles to add to the <img> tag
 * @param array 			$data_attributes 	Data attributes to add to the <img> tag
 * @uses function 			mdg_img_srcset()
 *
 * @return HTML
 */
function rmb_build_image($image_sizes, $sizes = '100vw', $classes = [], $alt = '', $styles = [], $data_attributes = []) {
	if (empty($image_sizes)) return false;
	$alt = empty($alt) && function_exists('get_the_title') ? ' alt="'.esc_attr(get_the_title()).'"' : ' alt="'.esc_attr($alt).'"';

	$srcset = '';
	$widest = 0;
	$keys = array_keys($image_sizes);
	$lastkey = end($keys);
	$src = array_shift($image_sizes);
	foreach($image_sizes as $size => $image) {
		$srcset .= "$image $size" . ($size != $lastkey ? ', ' : '');
	}
	$srcset = empty($srcset) ? '' : ' srcset="'.$srcset.'"';
	$classes = empty($classes) ? '' : ' class="'.implode(' ', $classes).'"';
	$styles = empty($styles) ? '' : ' style="'.implode(' ', $styles).'"';
	$sizes = empty($sizes) ? ' sizes="100vw"' : ' sizes="'.esc_attr($sizes).'"';
	$data_attributes = empty($data_attributes) ? '' : ' '.implode(' ', $data_attributes);
	$image = '<img src="'.$src.'"'.$srcset.$classes.$alt.$data_attributes.$styles.$sizes.'>';
	return $image;
}

/**
 * Build data attributes for team member tiles (allowing us to sort and filter)
 * 
 * @param 	Object	$team_member 		Team member object
 * @param 	Integer $index 				Integer value of index to set default sort order
 * @param 	Array 	$alphabet 			Associative array of alphabetically ordered team IDs on team members
 * @return 	String 						A string (with preceding space) of data attributes based on the team member object
 */
function team_member_data_attributes($team_member, $index = false, $alphabet = false) {
	if (!is_object($team_member)) return false;

	// Build member data attributes
	$data_attributes = [];
	if ($index !== false) $data_attributes[] = 'data-original-index="'.absint($index).'"';
	if ($alphabet !== false) $data_attributes[] = 'data-alphabet="'.absint($alphabet).'"';
	$data_attributes[] = 'data-name="'.esc_attr(strtolower($team_member->name)).'"';

	// Build member location term IDs
	$locations = [];
	if (!empty($team_member->locations)) {
		foreach ($team_member->locations as $index => $location) {
			$locations[] = $location->ID;
		}
	}
	if (!empty($locations)) $combined = $locations;
	else $combined = [];

	// Build member expertise IDs
	$expertise = [];
	if (!empty($team_member->services->expertise)) $expertise = wp_list_pluck($team_member->services->expertise, 'ID');
	if (!empty($expertise)) $combined = array_merge($combined, $expertise);

	// Build member industry IDs
	$industries = [];
	if (!empty($team_member->services->industry)) $industries = wp_list_pluck($team_member->services->industry, 'ID');
	if (!empty($industries)) $combined = array_merge($combined, $industries);

	// Build member functional roles IDs
	$functional_roles = [];
	if (!empty($team_member->services->{'functional-role'})) $functional_roles = wp_list_pluck($team_member->services->{'functional-role'}, 'ID');
	if (!empty($functional_roles)) $combined = array_merge($combined, $functional_roles);

	if (!empty($combined)) $data_attributes[] = 'data-filters="'.implode(',', $combined).'"';

	if (!empty($data_attributes)) return ' '.implode(' ', $data_attributes);
}


function class_attr($classes) {
	if(!empty($classes)) echo ' class="'.implode(' ', array_unique(array_filter($classes))).'" ';
}

function str_replace_first($string, $replacement, $subject) {
	if(($position = strpos($subject, $string)) !== false) return substr_replace($subject, $replacement, $position, strlen($string));
	return $subject;
}

function str_replace_last($string, $replacement, $subject) {
	if(($position = strrpos($subject, $string)) !== false) return substr_replace($subject, $replacement, $position, strlen($string));
	return $subject;
}

function susort(array &$array, $value_compare_func) {
	$index = 0;
	foreach ($array as &$item) {
		$item = array($index++, $item);
	}
	$result = usort($array, function($a, $b) use($value_compare_func) {					
		$result = call_user_func($value_compare_func, $a[1], $b[1]);
		return $result == 0 ? $a[0] - $b[0] : $result;
	});
	foreach ($array as &$item) {
		$item = $item[1];
	}
	return $result;
}

function get_parent_service_ids() {
	global $services;
	
	$ids = [get_the_ID()];
	if(is_top_level_expertise()) $ids = array_merge($ids, array_map(function($v) { return $v->ID == get_the_ID() || $v->post_parent == get_the_ID(); }, $services->expertise));
	
	return $ids;
}
