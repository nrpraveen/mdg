(function($) {
	// FORM LABEL ACTIVE STATE
	var fields = $("form .row-item select, form .row-item input, form .row-item textarea");
	
	fields.each(function() {
		if(($(this).val() || '').length > 0) {
			$(this).addClass('fill');
			var th = $(this), el = th.prop('tagName').toLowerCase() == 'select' ? th.parent() : th;
			el.prev('label').addClass('active');
			el.parent().addClass('active');
		}
	});
	
	fields.on('focus', function() {
		$(this).addClass('fill');
		var th = $(this), el = th.prop('tagName').toLowerCase() == 'select' ? th.parent() : th;
		el.prev('label').addClass('active');
		el.parent().addClass('active');
	});
	
	fields.on('change input keydown paste', function() {
		if($(this).is(':focus') && $(this).val() && $(this).val().length > 0) {
			$(this).addClass('fill');
			var th = $(this), el = th.prop('tagName').toLowerCase() == 'select' ? th.parent() : th;
			el.prev('label').addClass('active');
			el.parent().addClass('active');
		}
	});
	
	fields.on('blur', function() {
		if(($(this).val() || '').length == 0) {
			$(this).removeClass('fill');
			var th = $(this), el = th.prop('tagName').toLowerCase() == 'select' ? th.parent() : th;
			el.prev('label').removeClass('active');
			el.parent().removeClass('active');
		}
	});
	
	$('form .tooltip a').on('click', function(e) {
		e.preventDefault();
		$(this).closest('.tooltip').slideUp();
		$(this).closest('.row-item').find('input, textarea, select').first().val($(this).html()).trigger('focus').trigger('blur');
	});
    
    $('input[type=file]').change(function() {
        var file_name = $(this).val().split('\\');
        $('.upload.active').addClass('hidden');
        $('.file-name').html(file_name[file_name.length - 1]);
    });
	
    $('input[type=radio][name=location]').change(function() {
        $('#career-location').val(this.value);
    });

	/*
    $(document).on('change', '#looking_for', function() {
    	$(this).closest('.row').next().toggleClass('hidden', ($(this).val() != 'I am looking for my next role'));
    	$(this).css('opacity', 1);
    });
	*/

	let
		form_team_recaptcha_widget = null,
		form_locations_recaptcha_widget = null,
		form_general_recaptcha_widget = null,
		form_career_recaptcha_widget = null
	;
	
	function onGoogleReCaptchaSubmit(token) {
		$(window.last_form_executed).find('.g-recaptcha-response').val(token);
		$(window.last_form_executed).find('button[type="submit"]').html('Please wait ...').prop('disabled', true);
		window.last_form_executed.submit();
	}

	window.onGoogleReCaptchaLoad = function() {
		if($('form#form_career').length) {
			form_career_recaptcha_widget = grecaptcha.render('google-recaptcha-container_career', {
				sitekey: google_recaptcha_configuration.site_key,
				callback: onGoogleReCaptchaSubmit,
				size: 'invisible',
				badge: 'inline'
			});
		}
		if($('form#form_team').length) {
			form_career_recaptcha_widget = grecaptcha.render('google-recaptcha-container_team', {
				sitekey: google_recaptcha_configuration.site_key,
				callback: onGoogleReCaptchaSubmit,
				size: 'invisible',
				badge: 'inline'
			});
		}
		if($('form#form_location').length) {
			form_career_recaptcha_widget = grecaptcha.render('google-recaptcha-container_location', {
				sitekey: google_recaptcha_configuration.site_key,
				callback: onGoogleReCaptchaSubmit,
				size: 'invisible',
				badge: 'inline'
			});
		}
		if($('form#form_general').length) {
			form_career_recaptcha_widget = grecaptcha.render('google-recaptcha-container_general', {
				sitekey: google_recaptcha_configuration.site_key,
				callback: onGoogleReCaptchaSubmit,
				size: 'invisible',
				badge: 'inline'
			});
		}
	}
})(jQuery);