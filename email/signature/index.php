<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Cache-Control: no-cache, must-revalidate, max-age=0');

$name = null;
$title = null;
$email = null;
$phone = null;
$extension = null;
$mobile = null;
$fax = null;

if(isset($_GET['compile'])) {
	$files = array('style.less' => 'style.css');
	$less_directory = __DIR__.'/less/';
	$css_directory = __DIR__.'/css/';
	
	require_once __DIR__.'/lib/less/Less.php';
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
}

if(!empty($_REQUEST)) {
	$_REQUEST = array_map('trim', $_REQUEST);

	$name = isset($_REQUEST['name'])?$_REQUEST['name']:'';
	$title = isset($_REQUEST['title'])?$_REQUEST['title']:'';
	$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
	$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:'';
	$extension = isset($_REQUEST['extension'])?$_REQUEST['extension']:'';
	$mobile = isset($_REQUEST['mobile'])?$_REQUEST['mobile']:'';
	$fax = isset($_REQUEST['fax'])?$_REQUEST['fax']:'';
}

if(empty($name)) $name = "Your Name";
if(empty($title)) $title = "Job Title";
if(empty($email)) $email = "";
if(empty($phone)) $phone = "555 555 5555";
if(empty($extension)) $extension = "";
if(empty($mobile)) $mobile = "";
if(empty($fax)) $fax = "";

$contents = '';

include_once __DIR__.'/inc/functions.php';


if(isset($_GET['zip'])) {
	$htm = str_replace('1.4em;', '1.2em;', filter_template(file_get_contents(__DIR__.'/outlook-assets/usply.htm')));
	$txt = filter_template(file_get_contents(__DIR__.'/outlook-assets/usply.txt'));
	$rtf = filter_template(file_get_contents(__DIR__.'/outlook-assets/usply.rtf'));
	
	$file = tempnam(sys_get_temp_dir(), 'esignature'.microtime(true));
	$z = new ZipArchive();
	$z->open($file, ZIPARCHIVE::CREATE); 
	$z->addFromString('USply eSignature.htm', $htm);
	$z->addFromString('USply eSignature.rtf', $rtf);
	$z->addFromString('USply eSignature.txt', $txt);
	$z->addEmptyDir('USply eSignature_files');
	$z->close();
	
	$contents = file_get_contents($file);
	
	header('Content-Disposition: attachment; filename="USply-eSignature.zip"');    
	header("Content-Type: application/octet-stream");
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	echo $contents;
	exit;
}


include 'inc/header.php';
include 'inc/form.php';
?>
<div class="signature-section">
	<div class="signature">
		<h2>This is what your e-signature will look like to recipients:</h2>
		<section><iframe id="signature-outlook" frameborder="0" style="width:100%;min-height:500px;" src="./inc/signature.php?<?php echo http_build_query([
			'name' => $name,
			'title' => $title,
			'email' => $email,
			'phone' => $phone,
			'extension' => $extension,
			'mobile' => $mobile,
			'fax' => $fax,
			'o365' => 0,
		]); ?>"></iframe></section>
		<section style="position:absolute;top:-99999px;left:-99999px;"><iframe id="signature-outlook-365" frameborder="0" style="width:100%;min-height:500px;" src="./inc/signature.php?<?php echo http_build_query([
			'name' => $name,
			'title' => $title,
			'email' => $email,
			'phone' => $phone,
			'extension' => $extension,
			'mobile' => $mobile,
			'fax' => $fax,
			'o365' => 1,
		]); ?>"></iframe></section>
	</div>
</div>
<?php
include 'inc/footer.php';
