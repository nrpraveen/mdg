<?
add_shortcode('PARTIAL', function($args, $content) {
	$args = wp_parse_args($args, [
		'path' => null,
	]);
	
	return partial($args['path'], [], false);
});

add_shortcode('NAME', function() {
	global $team;
	$current = $team->getActiveTeamMember();
	if(empty($current)) return '';
	return strip_tags($current->name);
});

add_shortcode('POSITION', function() {
	global $team;
	$current = $team->getActiveTeamMember();
	if(empty($current)) return '';
	
	return !empty($current->position->name) ? $current->position->name : $current->position;
});

add_shortcode('LOCATIONS', function() {
	global $team;
	$current = $team->getActiveTeamMember();
	if(empty($current) || empty($current->locations)) return '';
	
	return implode(' | ', array_filter(array_unique(array_map(function($v) { return $v->name; }, $current->locations))));
});

add_shortcode('LOCATION_NAME', function() {
	global $locations;
	$current = $locations->last_location;
	if(empty($current) || empty($current->name)) return '';
	return $current->name;
});

add_shortcode('CANDIDATE_IFRAME', function($atts) {
	$atts = shortcode_atts([
		'src' => null,
		'width' => '100%',
		'height' => 900,
	], $atts, 'CANDIDATE_IFRAME');
	
	if(empty($atts['src'])) return '';
	
	ob_start();
	?>
	<div class="iframe candidate-iframe" data-source="<?= esc_url($atts['src']) ?>">
		<iframe src="<?= esc_url($atts['src']) ?>" width="<?= esc_attr($atts['width']) ?>" height="<?= esc_attr($atts['height']) ?>"></iframe>
	</div>
	<?
	return ob_get_clean();
});

add_shortcode('CTA', function($atts) {
	$atts = shortcode_atts([
		'class' => '',
		'href' => '',
		'target' => '_self',
		'rel' => '',
		'text' => '',
		'navigation' => '0',
	], $atts, 'CTA');
	
	$classes = array_unique(array_filter(array_merge(['cta'], explode(' ', $atts['class']))));
	
	if(empty($atts['href'])) return '';
	
	ob_start();
	?>
	<? if(!empty($atts['navigation'])): ?><div class="navigation"><? endif ?>
	<div class="cta-wrapper"><a <? if(!empty($classes)): ?>class="<?= implode(' ', $classes) ?>"<? endif ?> href="<?= esc_url($atts['href']) ?>" target="<?= esc_attr($atts['target']) ?>" <? if(!empty($atts['rel'])): ?>rel="<?= esc_attr($atts['rel']) ?>"<? endif ?>><?= $atts['text'] ?></a></div>
	<? if(!empty($atts['navigation'])): ?></div><? endif ?>
	<?
	return ob_get_clean();
});