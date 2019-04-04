<?php

function filter_template($text) {
	global $name, $title, $email, $phone, $mobile, $fax, $extension;
	$phone_ext = $phone; if(!empty($extension)) $phone_ext .= ' x'.$extension;
	$text = str_replace('[%name%]', $name, $text);
	$text = str_replace('[%title%]', $title, $text);
	$text = str_replace('[%email%]', $email, $text);
	$text = str_replace('[%phone%]', $phone, $text);
	$text = str_replace('[%mobile%]', $mobile, $text);
	$text = str_replace('[%fax%]', $fax, $text);
	$text = str_replace('[%phone_ext%]', $phone_ext, $text);
	
    if(empty($email)) {
		$start = strpos($text, '[%has_email%]');
		$end = strpos($text, '[%/has_email%]') + strlen('[%/has_email%]');
		if($start !== false && $end !== false) $text = substr_replace($text, '', $start, ($end - $start));
	}
    
	if(empty($phone)) {
		$start = strpos($text, '[%has_phone%]');
		$end = strpos($text, '[%/has_phone%]') + strlen('[%/has_phone%]');
		if($start !== false && $end !== false) $text = substr_replace($text, '', $start, ($end - $start));
	}
	
	if(empty($mobile)) {
		$start = strpos($text, '[%has_mobile%]');
		$end = strpos($text, '[%/has_mobile%]') + strlen('[%/has_mobile%]');
		if($start !== false && $end !== false) $text = substr_replace($text, '', $start, ($end - $start));
	}
	
	if(empty($fax)) {
		$start = strpos($text, '[%has_fax%]');
		$end = strpos($text, '[%/has_fax%]') + strlen('[%/has_fax%]');
		if($start !== false && $end !== false) $text = substr_replace($text, '', $start, ($end - $start));
	}
	
    $text = str_replace('[%has_email%]' ,'', $text);
	$text = str_replace('[%has_phone%]' ,'', $text);
	$text = str_replace('[%has_mobile%]' ,'', $text);
	$text = str_replace('[%has_fax%]' ,'', $text);
	$text = str_replace('[%/has_email%]' ,'', $text);
    $text = str_replace('[%/has_phone%]' ,'', $text);
	$text = str_replace('[%/has_mobile%]' ,'', $text);
	$text = str_replace('[%/has_fax%]' ,'', $text);
	
	return $text;
}