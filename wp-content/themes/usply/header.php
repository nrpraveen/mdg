<?
global $is_IE, $is_edge;
$html_classes = $body_classes = [];
if(is_user_logged_in()) $html_classes[] = 'admin-bar';
if($is_IE || $is_edge) $body_classes[] = 'IE';

$html_classes = array_filter(array_unique($html_classes));
$html_classes = empty($html_classes) ? '' : ' class="'.implode(' ', $html_classes).'" ';
?>
<!DOCTYPE html>
<html <? language_attributes(); echo $html_classes; ?>>
	<head>
		<title><? wp_title(' | ', true, 'right'); ?></title>
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
		<? wp_head(); ?>
	</head>
	<body <? body_class($body_classes) ?>>
		<? do_action('body'); ?>
            <? partial('section.header-mobile'); ?>
			<div id="header-container">
				<div id="header-wrapper">
				<? partial('section.header'); ?>