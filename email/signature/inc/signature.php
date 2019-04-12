<?php

header('Cache-Control: no-cache, must-revalidate, max-age=0');

$name = isset($_REQUEST['name'])?$_REQUEST['name']:'';
$title = isset($_REQUEST['title'])?$_REQUEST['title']:'';
$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:'';
$extension = isset($_REQUEST['extension'])?$_REQUEST['extension']:'';
$mobile = isset($_REQUEST['mobile'])?$_REQUEST['mobile']:'';
$fax = isset($_REQUEST['fax'])?$_REQUEST['fax']:'';
$outlook365 = !empty($_REQUEST['o365']);

include_once __DIR__.'/../inc/functions.php';
$template = '';
//&& empty($_REQUEST['ios'])
if(empty($outlook365)) $template = filter_template(file_get_contents(__DIR__.'/../outlook-assets/usply.htm'));
else $template = filter_template(file_get_contents(__DIR__.'/../outlook-assets/usply-365.htm'));

echo $template;