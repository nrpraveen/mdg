(function($) {
	if(window.objectFitImages) objectFitImages($('img.bg-img'));
	
	var 
		mobile_width = 768,
		desktop_header = $('section.header > .content')
	;
	
	$.extend($.easing,{
		easeOutCubic: function (x, t, b, c, d) {
			return c*((t=t/d-1)*t*t + 1) + b;
		},
	});
	
	$('.hero-scroll').on('click', function(e) {
		e.preventDefault();
		scrollToPosition($('.hero').innerHeight());
	});
	
	$('a.candidate-iframe-src').on('click', function(e) {
		e.preventDefault();
		$('.iframe.candidate-iframe iframe').attr('src', $(this).attr('href'));
		scrollToTarget($('#all'));
	});
	
	///////////// SMOOTH SCROLL FOR ANCHORS /////////////
	$('a[href*="#"]:not([href="#"])').on('click', function() {
		if(window.location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && window.location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if(target.length) {
				scrollToTarget(target);
				return false;
			}
		}
	});

	$(window).on('load', function() {
		if(location.href.split("#")[1]) {
			var anchor = location.href.split("#")[1];
			var target = $('#'+anchor+', a[name="'+anchor+'"]');
			if (target.length) $(window).scrollTop(
				target.offset().top 
				- ($(window).width() < 782 ? $('#mobileHeader').outerHeight() : $('section.header').outerHeight())
			);
		}
	});
	
	function scrollToPosition(position) {
		$('html, body').animate({
			scrollTop: (position + ($('#wpadminbar').outerHeight()||0))
		}, {
			easing: 'easeOutCubic',
			duration: 1000
		});
	}
	
	window.scrollToTarget = function(target) {
		var header = $(window).width() < 782 ? $('#mobileHeader') : $('section.header');
		
		$('html, body').animate({
			scrollTop: 
			target.offset().top 
			- parseInt((target.css('margin-top')).replace('px', ''))
			- header.outerHeight() 
			- ($('#wpadminbar').outerHeight()||0)
			+ ($('.hero .conversation').length ? ((1 - window.hero_scroll_progress)||0) * (window.hero_scroll_delta||0) : 0)
		}, 250);
	}
	
	// NAVIGATION //
	$('.super-nav > ul > li.menu-item-has-children > a').on('click', function(e) {
		e.preventDefault();
		$('.super-nav > ul > li.menu-item-has-children.active').not($(this).parent()).removeClass('active');
		$(this).parent().toggleClass('active');
		$('li.expand-active').toggleClass('supernav-inactive', $('.super-nav li.active').length > 0);
	});
	
	// SERVICE TILES //
	$('ul.service-tiles > li').hover(function() {
		$(this).parent().addClass('hover');
	}, function() {
		$(this).parent().removeClass('hover');
	});
	
	$('.primary-nav > ul > li').hover(function() {
		$(this).parent().children('li').not($(this)).addClass('inactive');
	}, function() {
		$(this).parent().children('li').not($(this)).removeClass('inactive');
	});
	
	$.extend($.expr[':'], {
		inview:function(el) {
			let wintop = $(window).scrollTop(),
				winbtm = $(window).scrollTop() + $(window).height(),
				eltop = $(el).offset().top,
				elbtm = $(el).offset().top + $(el).height();

			return elbtm >= wintop && eltop <= winbtm;
		}
	});
	
	// STICKY //
	function onPageChanged() {
		if(typeof($('section.header').data('padding')) === 'undefined') {
			$('section.header').data('padding', parseInt($('section.header').css('padding-top').replace('px', '')));
		}
        //$('section.header').data('padding')
		$('html').toggleClass('sticky-header', $(window).scrollTop() > $('section.header').data('padding-top'));
		var header_height = ((desktop_header.outerHeight()||0) + ($('#wpadminbar').outerHeight()||0));
		
		// CTA - header-based
		$('.cta.stick-header').each(function() {
			$(this).toggleClass('stuck', $(this).parent().get(0).getBoundingClientRect().top <= header_height);
			
			if($(this).hasClass('stuck') && !$(this).hasClass('insights-cta')) {
				$(this).attr('style', 'top:'+header_height+'px!important');
			}
			else {
				$(this).removeAttr('style');
			}
		});
		
		var header_copy_selector = $('section.hero > .content');
		if(header_copy_selector.length) {
			$('html').toggleClass('solid-header', header_copy_selector.get(0).getBoundingClientRect().top <= header_height);
		}
		
		// Widgets
		$('aside > .widgets').css('top', ((4*12) + 2*(desktop_header.outerHeight()||0) + ($('#wpadminbar').outerHeight()||0)));
	}

	$('section.header').data('padding-top', parseInt($('section.header').css('padding-top').replace('px', '')||0));
	$(document).on('ready', function() { onPageChanged(); });
	$(window).on('scroll load resize', function() { onPageChanged();  });
	
    $('.filter-toggle').on('click', function() {
        $(this).closest('.filter').toggleClass('active').parent().toggleClass('active');
	});
})(jQuery); 