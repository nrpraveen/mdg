(function($) {	
	$.validator.addMethod('emailTLD', function(v, e) {
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return !!filter.test(v);
	}, '*');
	
	$.validator.addMethod('phoneUS', function(v, e) {
		v = v.replace(/\s+/g, ""); 
		return this.optional(e) || v.length > 9 &&
			v.match(/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i);
	}, '*');

	// Setup array of jquery validate objects
	let validation = [];
    validation['team'] = $('form#form_team').validate({
		ignore: ':hidden:not([name="g-recaptcha-response"]):not(input[type="radio"]):not(input[type="checkbox"])',
		errorPlacement: function(error, element) {
			$(element).closest('.row-field').find('.tooltip').html($(error).html());
		},
		submitHandler: function(form) {
			window.last_form_executed = form;
			grecaptcha.execute();
		},
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').removeClass('hidden');
			$(element).closest('.row-field').addClass('error');
			$(element).addClass('error');
			$(element).parent().addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').addClass('hidden');
            $(element).closest('.row-field').removeClass('error');
			$(element).removeClass('error');
			$(element).parent().removeClass('error');
		},
		rules: {"first_name":{"required":true},"last_name":{"required":true},"phone_number":{"required":true},"email_address":{"required":true,"emailTLD":true}},
		messages: {"first_name":{"required":"Please enter your first name."},"last_name":{"required":"Please enter your last name."},"phone_number":{"required":"Please enter your phone number."},"email_address":{"required":"Please enter your email address.","emailTLD":"Please enter a valid email address."}}
	});
    
    validation['location'] = $('form#form_location').validate({
		ignore: ':hidden:not([name="g-recaptcha-response"]):not(input[type="radio"]):not(input[type="checkbox"])',
		errorPlacement: function(error, element) {
			$(element).closest('.row-field').find('.tooltip').html($(error).html());
		},
		submitHandler: function(form) {
			window.last_form_executed = form;
			grecaptcha.execute();
		},
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').removeClass('hidden');
			$(element).closest('.row-field').addClass('error');
			$(element).addClass('error');
			$(element).parent().addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').addClass('hidden');
            $(element).closest('.row-field').removeClass('error');
			$(element).removeClass('error');
			$(element).parent().removeClass('error');
		},
		rules: {"first_name":{"required":true},"last_name":{"required":true},"phone_number":{"required":true},"email_address":{"required":true,"emailTLD":true}},
		messages: {"first_name":{"required":"Please enter your first name."},"last_name":{"required":"Please enter your last name."},"phone_number":{"required":"Please enter your phone number."},"email_address":{"required":"Please enter your email address.","emailTLD":"Please enter a valid email address."}}
	});
    
    validation['general'] = $('form#form_general').validate({
		ignore: ':hidden:not([name="g-recaptcha-response"]):not(input[type="radio"]):not(input[type="checkbox"])',
		errorPlacement: function(error, element) {
			$(element).closest('.row-field').find('.tooltip').html($(error).html());
		},
		submitHandler: function(form) {
			window.last_form_executed = form;
			grecaptcha.execute();
		},
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').removeClass('hidden');
			$(element).closest('.row-field').addClass('error');
			$(element).addClass('error');
			$(element).parent().addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').addClass('hidden');
            $(element).closest('.row-field').removeClass('error');
			$(element).removeClass('error');
			$(element).parent().removeClass('error');
		},
		rules: {"first_name":{"required":true},"last_name":{"required":true},"phone_number":{"required":true},"email_address":{"required":true,"emailTLD":true}},
		messages: {"first_name":{"required":"Please enter your first name."},"last_name":{"required":"Please enter your last name."},"phone_number":{"required":"Please enter your phone number."},"email_address":{"required":"Please enter your email address.","emailTLD":"Please enter a valid email address."}}
	});
    
    validation['career'] = $('form#form_career').validate({
		ignore: ':hidden:not([name="g-recaptcha-response"]):not(input[type="radio"]):not(input[type="checkbox"])',
		errorPlacement: function(error, element) {
			$(element).closest('.row-field').find('.tooltip').html($(error).html());
		},
		submitHandler: function(form) {
			window.last_form_executed = form;
			grecaptcha.execute();
		},
		highlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').removeClass('hidden');
			$(element).closest('.row-field').addClass('error');
			$(element).closest('.row-item').addClass('error');
			$(element).addClass('error');
			$(element).parent().addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.row-field').find('.tooltip').addClass('hidden');
            $(element).closest('.row-field').removeClass('error');
			$(element).closest('.row-item').removeClass('error');
			$(element).removeClass('error');
			$(element).parent().removeClass('error');
		},
		rules: {"first_name":{"required":true},"last_name":{"required":true},"email_address":{"required":true,"emailTLD":true},"resume":{"required":true}},
		messages: {"first_name":{"required":"Please enter your first name."},"last_name":{"required":"Please enter your last name."},"email_address":{"required":"Please enter your email address.","emailTLD":"Please enter a valid email address."},"resume":{"required":"Please upload your CV/Resume"}}
	});

    // Change validate rules to require resume CV when end user is looking for their next role
	$(document).on('change', '#looking_for', function() {
		if($(this).val() == 'I am looking for my next role') {
			for(var v in validation) {
				if(validation.hasOwnProperty(v) && typeof validation[v] != 'undefined') {
					let form = $(validation[v].currentForm);
					let resume_field_name = form.find('span.upload').attr('for');
					let resume = $('#'+resume_field_name);
					if($('label[for="'+resume_field_name+'"]').text().indexOf('*') == -1) $('label[for="'+resume_field_name+'"]').text($('label[for="'+resume_field_name+'"]').text()+' *');
					validation[v].settings.rules[resume_field_name] = {'required':true};
				}
			}
		} else {
			for(var v in validation) {
				if(validation.hasOwnProperty(v) && typeof validation[v] != 'undefined') {
					let form = $(validation[v].currentForm);
					let resume_field_name = form.find('span.upload').attr('for');
					let resume = $('#'+resume_field_name);
					$('label[for="'+resume_field_name+'"]').text($('label[for="'+resume_field_name+'"]').text().replace(' *',''));
					validation[v].settings.rules[resume_field_name] = {'required':false};
				}
			}
		}
	});
	window.validation = validation;
	
	$('span.upload').on('click', function(e) {
		$(this).prev().trigger('click');
	});
	
	function getParameterByName( name ){ 
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
		return "";
	  else
		return decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function getReferralSource() {
		if(getParameterByName('gclid').length > 0 || document.location.hostname.indexOf('fastmed1.com') >= 0 || getParameterByName('scid').length > 0 || getParameterByName('utm_source').toLowerCase() == 'reachlocal' || getParameterByName('utm_medium').toLowerCase() == 'cpc') return 'Google (PPC)';
		else if(document.referrer.toLowerCase().indexOf('linkedin.com') >= 0 || getParameterByName('utm_source').toLowerCase() == 'linkedin') return 'LinkedIn';
		else if(getParameterByName('utm_source').toLowerCase() == 'facebook' || document.referrer.toLowerCase().indexOf('facebook.com') >= 0) return 'Facebook';
		return 'Web';
	}

	if($('#lead_source').length) $('#lead_source').val(getReferralSource());

    if(getParameterByName('utm_source').toLowerCase().length > 0) {                 
        $('input[name="utm_source"]').val(getParameterByName('utm_source').toLowerCase());
        $('input[name="utm_medium"]').val(getParameterByName('utm_medium').toLowerCase());
        $('input[name="utm_campaign"]').val(getParameterByName('utm_campaign').toLowerCase());
        $('input[name="utm_term"]').val(getParameterByName('utm_term').toLowerCase());
        $('input[name="utm_content"]').val(getParameterByName('utm_content').toLowerCase());
    }
})(jQuery);