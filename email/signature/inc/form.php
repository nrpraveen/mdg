<form action="<?php echo 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" method="GET" class="signature">
    <div class="input-wrapper">   
        <div class="input-section">
            <h1>Employee Email Signature Generator</h1>
            <p>Please enter your details below to generate your email signature:</p>
			<div class="row">
				<div>
					<input type="text" name="name" placeholder="Name" value="<?php echo isset($_REQUEST['name'])?$_REQUEST['name']:''; ?>" required >
				</div>
				<div>
					<input type="text" name="title" placeholder="Job Title" value="<?php echo isset($_REQUEST['title'])?$_REQUEST['title']:''; ?>" required >
				</div>
            </div>
            <div class="row">
				<div>
					<input mask="phone" type="text" name="phone" placeholder="Phone Number" value="<?php echo isset($_REQUEST['phone'])?$_REQUEST['phone']:''; ?>">
					<input mask="number" type="text" name="extension" placeholder="Ext" value="<?php echo isset($_REQUEST['extension'])?$_REQUEST['extension']:''; ?>" maxlength="10">
				</div>
            </div>
            <div class="row">
				<div>
					<input mask="fax" type="text" name="fax" placeholder="Fax Number" value="<?php echo isset($_REQUEST['fax'])?$_REQUEST['fax']:''; ?>">
				</div>
                <div>
					<input mask="mobile" type="text" name="mobile" placeholder="Mobile Number" value="<?php echo isset($_REQUEST['mobile'])?$_REQUEST['mobile']:''; ?>">
				</div>
            </div>
            <div class="row">
                <div>
					<input class="button" type="submit" value="Preview signature">
                </div>
            </div>
            <div class="row <? if(empty($_GET)) echo 'hidden'; ?>">
                <div>
					<button class="clipboard-outlook button" onclick="javascript:return false;">Export to Gmail or Mac Mail</button>
                </div>
                <div>
					<a class="export-ios button" href="<?php echo 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'inc/signature.php?ios=1&'.trim(http_build_query($_GET), '?&'); ?>" target="_blank">Export to iOS Mail</a>
                </div>
			</div>
            <div class="row <? if(empty($_GET)) echo 'hidden'; ?>">
                <div>
					<a class="export-outlook button" href="<?php echo 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'?zip=1&'.trim(http_build_query($_GET), '?&'); ?>">Export to Outlook (Desktop)</a>
                </div> 
                <div>
					<button class="clipboard-outlook-365 button" onclick="javascript:return false;">Export to Office 365</button>
                </div> 
            </div>
        </div>
    </div>
</form>