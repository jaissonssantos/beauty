/**
  * removePreloader
  * init_header
  * ResponsiveMenu
  * ajaxContactForm
  * gmap3
  * evtCarousel
  * CountTo
  * CountDown
  * Parallax
  * closeAlert
*/

;(function($) {

	'use strict'

	var removePreloader = function() {
		setTimeout(function() {
			$('.preloader').css({ 'opacity': 0, 'visibility':'hidden' });
		}, 1000);
	};

	var init_header = function() {
		var largeScreen = matchMedia('only screen and (min-width: 768px)').matches;
		if( largeScreen ) {
			if( $().sticky ) {
				$('header.header-sticky').sticky();
			}
		}
		$('a.scroll-link').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			$(this).parent().addClass('active').siblings().removeClass('active');
			event.preventDefault();
		});
	};

	var ResponsiveMenu =  {
		menuType: 'desktop',
		initial: function(winWidth) {
			ResponsiveMenu.menuWidthDetect(winWidth);
			ResponsiveMenu.menuBtnClick();
			ResponsiveMenu.parentMenuClick();
		},
		menuWidthDetect: function(winWidth) {
			var currMenuType = 'desktop';
			if (matchMedia('only screen and (max-width: 767px)').matches) {
				currMenuType = 'mobile';
			}
			if ( currMenuType !== ResponsiveMenu.menuType ) {
				ResponsiveMenu.menuType = currMenuType;
				if ( currMenuType === 'mobile' ) {
					$('.mainnav li.mega a').after($('.mega-wrap ul.sub-menu'));
					var $mobileMenu = $('#mainnav').attr('id', 'mainnav-mobi').hide();
					$('#header').find('.header-nav').after($mobileMenu);
					var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');
					hasChildMenu.children('ul').hide();
					hasChildMenu.children('a').after('<span class="btn-submenu"></span>');
					$('.btn-menu').removeClass('active');
				} else {
					var $desktopMenu = $('#mainnav-mobi').attr('id', 'mainnav').removeAttr('style');
					$desktopMenu.find('.sub-menu').removeAttr('style');
					$('#header').find('.btn-menu').after($desktopMenu);
					$('.btn-submenu').remove();
				}
			} // clone and insert menu
		},
		menuBtnClick: function() {
			$('.btn-menu').on('click', function() {
				$('#mainnav-mobi').slideToggle(300);
				$(this).toggleClass('active');
			});
		}, // click on moblie button
		parentMenuClick: function() {
			$(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {
				if ( $(this).has('ul') ) {
					e.stopImmediatePropagation()
					$(this).next('ul').slideToggle(300);
					$(this).toggleClass('active');
				}
			});
		} // click on sub-menu button
	};

	var ajaxContactForm = function(formId) {
		$(formId).each(function() {
			$(this).validate({
				submitHandler: function( form ) {
					var $form = $(form),
						str = $form.serialize(),
						loading = $('<div />', { 'class': 'loading' });

					$.ajax({
						type: "POST",
						url:  $form.attr('action'),
						data: str,
						beforeSend: function () {
							$form.find('.send-wrap').append(loading);
						},
						success: function( msg ) {
							var result, alertClass;

							if ( msg == 'Success' ) {
								result = 'Sua Messagem foi enviada, Aguarde nosso contato!';
								alertClass = 'msg-success';
							} else {
								result = 'Erro ao enviar email.';
								alertClass = 'msg-error';
							}

							$form.prepend(
								$('<div />', {
									'class': 'kul-alert col-md-12 ' + alertClass,
									'text' : result
								}).append(
									$('<a class="close" href="#"><i class="fa fa-close"></i></a>')
								)
							);
						},
						complete: function (xhr, status, error_thrown) {
							$form.find('.loading').remove();
						}
					});
				}
			});
		});
	};

	var googleMap = function() {
		if ( $().gmap3 ) {
			var _draggable = true;
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				_draggable = false;
			}
			$("#gmap").gmap3({
				map:{
					options:{
						zoom: 14,
						mapTypeId: 'kul_style',
						mapTypeControlOptions: {
							mapTypeIds: ['kul_style', google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
						},
						scrollwheel: false,
						draggable: _draggable
					}
				},
				getlatlng:{
					address:  "65A-B - Bach Dang - Tan Binh - TP HCM",
					callback: function(results) {
						if ( !results ) return;
						$(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
						$(this).gmap3({
							marker:{
								latLng:results[0].geometry.location,
								options:{
									icon: 'images/common/marker.png'
								}
							}
						});
					}
				},
				styledmaptype:{
					id: "kul_style",
					options:{
						name: "Kul Map"
					},
				},
			});
		}
	};

	var evtCarousel = function(elm) {
		$(elm).each(function() {
			if ( $().owlCarousel ) {
				$(this).owlCarousel({
					items: $(this).data('items'),
					itemsDesktop: [1199,$(this).data('itemsdesktop')],
					itemsDesktopSmall:[979,$(this).data('itemsdesktopsmall')],
					itemsTablet: [768,$(this).data('itemstablet')],
					itemsMobile: [479,$(this).data('itemsmobile')],
					slideSpeed: $(this).data('slidespeed'),
					autoPlay: $(this).data('autoplay'),
					pagination: $(this).data('pagination'),
					responsive: $(this).data('responsive')
				});
			}
		});
	};

	var countTo = function(elmDetect){
		if ( $().waypoint && $(elmDetect).length ) {
			$(elmDetect).waypoint(function() {
				if ( $().countTo ) {
					$('.timer').countTo();
				}
			});
		}
	};

	// CountDown
	var countDown = function() {
		var austDay = new Date();
		austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
		$('#defaultCountdown').countdown({until: austDay});
		$('#year').text(austDay.getFullYear());
	}

	var parallax = function() {
		if($().parallax){
			$('.bg-parallax').parallax("50%", 0.5);
		}
	};

	var closeAlert = function() {
		$(document).on('click', '.close', function(e) {
			$(this).closest('.kul-alert').remove();
			e.preventDefault();
		})
	}

	// Dom Ready
	$(function() {
		removePreloader();
		init_header();
		ResponsiveMenu.initial($(window).width());
		$(window).resize(function() {
			ResponsiveMenu.menuWidthDetect($(this).width());
		});
		evtCarousel('.mainslider ul');
		evtCarousel('.carousel-event');
		evtCarousel('.sponsors');
		evtCarousel('.testimonial');
		evtCarousel('.blog-slider');
		ajaxContactForm('#contact-form');
		googleMap();
		countTo('#about');
		countTo('.services-box02');
		countDown();
		parallax();
		closeAlert();
	});

})(jQuery);