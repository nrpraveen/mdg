		<div class="footer-section">    
			   &copy; <?php echo date('Y'); ?> USply.net 
		</div>
		
		
		<script>
		var clipboard = new Clipboard('.clipboard-outlook', {
			target: function(trigger) {
				$('#signature-outlook')[0].contentDocument.designMode = "on"; 
				$('#signature-outlook')[0].contentDocument.execCommand("selectAll", false, null); 
				$('#signature-outlook')[0].contentDocument.execCommand("copy", false, null); 
				$('#signature-outlook')[0].contentDocument.designMode = "off";
				return $('#signature-outlook')[0].contentWindow.document.getElementById('signature_root');
			}
		});
		
		clipboard.on('error', function(e) {
			alert('We were unable to copy your signature to the clipboard.');
		}); 
		
		clipboard.on('success', function(e) {
			console.log(e);
			alert('Your signature was copied to the clipboard. Please refer to the instructions for more details.');
		});
		
		
		var clipboard365 = new Clipboard('.clipboard-outlook-365', {
			target: function(trigger) {
				$('#signature-outlook-365')[0].contentDocument.designMode = "on"; 
				$('#signature-outlook-365')[0].contentDocument.execCommand("selectAll", false, null); 
				$('#signature-outlook-365')[0].contentDocument.execCommand("copy", false, null); 
				$('#signature-outlook-365')[0].contentDocument.designMode = "off";
				return $('#signature-outlook-365')[0].contentWindow.document.getElementById('signature_root_365');
			}
		});
		
		clipboard365.on('error', function(e) {
			alert('We were unable to copy your signature to the clipboard.');
		}); 
		
		clipboard365.on('success', function(e) {
			console.log(e);
			alert('Your signature was copied to the clipboard. Please refer to the instructions for more details.');
		});

		//$('[mask=phone]').mask("000 000 0000", {placeholder:"Phone Number"});
		//$('[mask=mobile]').mask("000 000 0000", {placeholder:"Mobile Number"});
		//$('[mask=fax]').mask("000 000 0000", {placeholder:"Fax Number"});
		$("[mask=number]").on('keypress', function(event) {
		var controlKeys = [8, 9, 13, 35, 36, 37, 39];
		var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
			if (!event.which || (47 <= event.which && event.which <= 57) || (48 == event.which && $(this).attr("value")) || isControlKey) {
				return;
			} 
			else {
				event.preventDefault();
			}
		});
            
		</script> 
	</body>
</html>