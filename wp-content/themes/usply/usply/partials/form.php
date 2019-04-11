<form action="<?php echo get_current_url(); ?>" method="POST" id="form_<?php echo $form_name; ?>" class=" form_<?php echo $form_name; ?> <? if($form_name == 'step'): ?>contact-form-scroll<? endif ?>" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
	<input type="hidden" name="__f" value="<?php echo $form_hash; ?>">
	<? if(in_array($form_name, ['career','team', 'location'])): ?><input type="hidden" name="eid" value="" /><? endif ?>
	
	<?php foreach($hidden as $name => $value): ?>
	<input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo isset($_POST[$name]) ? $_POST[$name] : $value; ?>">
	<?php endforeach; ?>
	
	<?php if(count($api_errors) || count($form_errors)): ?>
	<div class="form-errors pull orange">
		<p>Our apologies, it appears that something did not go as planned. Please check the information below and re-submit the form.</p>
		<?php if(count(array_filter($api_errors))): ?>
		<ul><li><?php echo implode('</li><li>', $api_errors); ?></li></ul>
		<?php endif; ?>
		<?php if(count(array_filter($form_errors))): ?>
		<ul><li><?php echo implode('</li><li>', $form_errors); ?></li></ul>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php foreach($rows as $row): 
	// Allow row classes to be passed in the first row item with : delimeter like so: resume:hidden
	$row_classes = '';
	if(strstr($row[0], ':')) {
		$classes = explode(':', $row[0]);
		$row = [$classes[0]];
		$row_classes = $classes[1];
	}

    if($row[0] == 'html1' || $row[0] == 'html2' || $row[0] == 'html3'):
    $field = $instance->getField($row[0]);
        echo $field->content;
    else: 
    ?>
    <div class="row<?php if(!empty($row_classes)) echo ' '.$row_classes; ?>">
		<?php foreach($row as $name):
			$field = $instance->getField($name);
			$active = false;
            $classes = '';
			?>
            <?php if($name == 'cta'): ?>
                <button type="submit" class="submit cta primary large inline arrow"><?php echo $cta; ?></button>
            <?php continue; endif; ?>
			<div class="row-item <?= property_exists($field, 'class') && $field->class ?>">
                
                <?php if($field->type != 'select' && $field->type != 'radio' && $field->type != 'msg'  && $field->type != 'checkbox' && $field->type != 'captcha' && !empty($field->label)): ?>
					<label for="<?php echo $name ?><? if($field->type == 'file') echo '_'.$form_name; ?>" class="<?php if($active) echo 'active'; ?>"><?php echo $field->label; if(in_array($name, $required)) echo ' *'; ?> </label>
				<?php endif; ?>
				
				<?php if($field->type == 'textarea'): ?>
					<textarea maxlength="7500" class="auto-expand" data-min-height="40px" name="<?php echo $name; ?>" id="<?php echo $name; ?>"><?php if(isset($_POST[$name])) { echo $_POST[$name]; $active = true; }?></textarea>
				<?php elseif($field->type == 'select'): ?>
					<?php
					$found = false;
					foreach($field->options as $k => $v) {
						if(isset($_POST[$name]) && $k == $_POST[$name]) {
							$found = true;
							$active = true;
							break;
						}
					}
					?>
					<div class="select-wrapper">
						<select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
                            <option value="" disabled="disabled" <?php if(!$found) echo 'selected="selected"'; ?>><?php echo isset($field->default) ? $field->default : '&nbsp;'; ?></option>
							<?php foreach($field->options as $k => $v): ?>
							        <option value="<?php echo esc_attr($v); ?>"<?php if(isset($_POST[$name]) && $v == $_POST[$name]) echo 'selected="selected"';?>><?php echo $v ?></option>
							<?php endforeach ?>
						</select>
					</div>
                <?php elseif($field->type == 'select-optgroup'): ?>
					<?php
					$found = false;
					foreach($field->options as $k => $v) {
						if(isset($_POST[$name]) && $k == $_POST[$name]) {
							$found = true;
							$active = true;
							break;
						}
					}
					?>
					<div class="select-wrapper">
						<select name="<?php echo $name; ?>">
                            <option value="" disabled="disabled" <?php if(!$found) echo 'selected="selected"'; ?>><?php echo isset($field->default) ? $field->default : '&nbsp;'; ?></option>
							<?php foreach($field->options as $label => $day): ?>
                                <optgroup label="<?php echo $label; ?>">
                                <?php foreach($day as $i => $j): ?>
							        <option value="<?php echo $j; ?>"<?php if(isset($_POST[$name]) && $i == $_POST[$name]) echo 'selected="selected"';?>><?php echo $j ?></option>
							    <?php endforeach ?>
                                </optgroup>
							<?php endforeach ?>
						</select>
					</div>
                <?php elseif($field->type == 'radio'): ?>
                    <div class="radio-title title-<?php echo $name; ?> h2"><?=$field->label; ?></div>
                    <div class="<?php echo $name; ?>">
                        <?php foreach($field->options as $value => $label): ?>
                            <span class="radio">
                                <input type="radio" tabindex="2" name="<?php echo $name ?>" id="<?php echo esc_attr($value); ?>" value="<?php echo $label; ?>" <?php if((isset($_POST[$name]) && $label == $_POST[$name]) || (!isset($_POST[$name]) && $value == $field->default)) { echo 'checked'; $active = true; } ?>>
                                <i></i>
                                <label for="<?php echo $value; ?>"><q><?php echo $label ?></q></label>
                            </span>
                            <? if($value == 'other'){ ?> <input type="<?php echo $field->type ?>" name="<?php echo $name ?>" id="<?php echo $name ?>" value="<?php if(isset($_POST[$name])) {echo $_POST[$name]; $active = true; } ?>"> <? } ?>
                        <?php endforeach; ?>
                    </div>
                <?php elseif($field->type == 'checkbox'): ?>
                    <p class="checkbox">
                        <input type="<?php echo $field->type ?>" name="<?php echo $name ?>" id="<?php echo $name ?>"  >
                        <i></i>
                        <label style="display: inline; padding-right: 0;" class="<?php echo $name ?>" for="<?php echo $name ?>"><?php echo $field->label ?></label>
                        <?php echo $field->link; ?> <?php if(in_array($name, $required)) echo ' *'; ?>
                    </p>
                <?php elseif($field->type == 'file'): ?>
                    <span class="upload" for="<?php echo $name ?>_<?php echo $form_name; ?>">Click to Upload<i class="icon-download"></i>
                        <input type="<?php echo $field->type ?>" name="<?php echo $name ?>_<?php echo $form_name; ?>" id="<?php echo $name ?>_<?php echo $form_name; ?>" value="">
                    </span>
                    <div class="file-name"></div>
				<?php elseif($field->type == 'captcha'): ?>
					<? /*<div class="g-recaptcha" data-sitekey="<?php echo $field->key; ?>"></div> */?>
                    <div class="g-recaptcha" data-sitekey="<?php echo $field->key; ?>" data-size="invisible"> </div>
                <?php elseif($field->type == 'msg'): ?>
                    <p><?php echo $field->label; ?></p>
                <?php elseif($field->type == 'date'): ?>
					<input maxlength="250" type="<?php echo $field->type ?>" name="<?php echo $name ?>" data-value="<?php if(isset($_POST[$name])) {echo $_POST[$name]; $active = true; } ?>">
				<?php else: ?>
					<input maxlength="250" type="<?php echo $field->type ?>" name="<?php echo $name ?>" id="<?php echo $name ?>"  value="<?php if(isset($_POST[$name])) {echo $_POST[$name]; $active = true; } ?>">
				<?php endif; ?>

                <div class="tooltip <?php if(empty($form_errors[$name])) echo 'hidden'; ?>"><?php if(!empty($form_errors[$name])) echo $field->error; ?></div>
        
			</div>
		<?php 
            if($name == 'contact-method') echo '</div>';
            endforeach; ?>
    </div>
	<?php endif; endforeach;  ?>

	<div id="google-recaptcha-container_<?php echo $form_name; ?>"></div>
</form>