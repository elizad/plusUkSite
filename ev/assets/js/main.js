(function($) {
	'use strict';

	$(document).ready(function($) {
		// Tab
		$('.tiva-facebook-tab .tiva-facebook-tab-bar .btn').on('click', function(e) {
			e.preventDefault();

			// Tab button
			$(this).closest('.tiva-facebook-tab-bar').find('.btn').removeClass('active');
			$(this).addClass('active');

			// Tab content
			$(this).closest('.tiva-facebook-tab').find('.content-tab').removeClass('active');
			$(this).closest('.tiva-facebook-tab').find('.content-tab' + $(this).attr('href')).addClass('active');

			// Album
			if ($(this).attr('href') == '#tab-album') {
				$(this).closest('.tiva-facebook-tab').find('.facebook-albums').show();
				$(this).closest('.tiva-facebook-tab').find('.album-photos').hide();
			}

			// Active masonry
			if ($(this).closest('.tiva-facebook-tab').find('.content-tab' + $(this).attr('href')).hasClass('masonry')) {
				var masonry = $(this).closest('.tiva-facebook-tab').find('.content-tab' + $(this).attr('href'));
				var $grid = masonry.find('.grid').masonry({
					itemSelector: '.grid-item',
					gutter: '.gutter-sizer',
				});
			}
		});

	    // Masonry
	    $('.tiva-facebook-all-in-one .masonry').each(function () {
			var masonry = $(this);

			var active_items = 0;
			masonry.find('.grid-item').each(function () {
				if ($(this).hasClass('active')) {
					active_items++;
				}
			});
			if (masonry.find('.grid-item').length == active_items) {
				masonry.find('.read-more').hide();
			}

			var $grid = masonry.find('.grid').masonry({
				itemSelector: '.grid-item',
				gutter: '.gutter-sizer',
			});

			// Layout Masonry after each image loads
			$grid.imagesLoaded().progress(function() {
				$grid.masonry('layout');
				masonry.find('.grid').show();
				masonry.find('.loading').hide();
			});
	    });

		// Load More
	    $('.tiva-facebook-all-in-one .masonry .read-more .btn').on('click', function (e) {
	        e.preventDefault();

			var masonry = $(this).closest('.masonry');

			var active_items = 0;
			masonry.find('.grid-item').each(function () {
				if ($(this).hasClass('active')) {
					active_items++;
				}
			});

			var show_items = active_items + 3;
			if (screen.width <= 425) {
				show_items = active_items + 1;
			} else if (screen.width <= 991) {
				show_items = active_items + 2;
			}

			masonry.find('.grid-item').slice(active_items, show_items).addClass('active').css({'opacity': '0', 'visibility': 'hidden'});;

	        var $grid = masonry.find('.grid').masonry({
	            itemSelector: '.grid-item',
	            gutter: '.gutter-sizer',
	        });

			// layout Masonry after each image loads
			$grid.imagesLoaded().progress( function() {
				$grid.masonry('layout');
				masonry.find('.grid-item').slice(active_items, show_items).css({'opacity': '1', 'visibility': 'visible'});
			});

	        // Hide show all button
			if (show_items >= masonry.find('.grid-item').length) {
	        	$(this).fadeOut('slow');
			}

	        // Scroll to last item
	        $('html,body').animate({
	            scrollTop: $(this).offset().top
	        }, 1500);

	        return false;
	    });

		// Album Photos
	    $('.tiva-facebook-album .open-album').on('click', function (e) {
	        e.preventDefault();

			$(this).closest('.facebook-albums').hide();
			$(this).closest('.tiva-facebook-album').find('.album-photos' + $(this).attr('href')).show();

			var masonry = $(this).closest('.tiva-facebook-album').find('.masonry');

			var active_items = 0;
			masonry.find('.grid-item').each(function () {
				if ($(this).hasClass('active')) {
					active_items++;
				}
			});
			if (masonry.find('.grid-item').length == active_items) {
				masonry.find('.read-more').hide();
			}

			var $grid = masonry.find('.grid').masonry({
				itemSelector: '.grid-item',
				gutter: '.gutter-sizer',
			});

			// Layout Masonry after each image loads
			$grid.imagesLoaded().progress(function() {
				$grid.masonry('layout');
				masonry.find('.grid').show();
				masonry.find('.loading').hide();
			});

	        return false;
	    });

		// Feed Popup
		$('.open-popup').magnificPopup({
			type: 'inline',
			mainClass: 'my-mfp-zoom-in',
			gallery: {
	            enabled: true,
	            navigateByImgClick: true
	        },
		});

		// Likebox loading
		setTimeout(function () {
			$('.likebox-content .loading').remove();
			$('.likebox-content .fb-page').show();
		}, 5 * 1000);

		// Likebox hover
		var placement = {};
		var position = $('.tiva-facebook-likebox .likebox-button').hasClass('left') ? 'left' : 'right';
		$('.tiva-facebook-likebox .likebox-button, .tiva-facebook-likebox .likebox-content').hover(function() {
			placement[position] = 0;
			$('.tiva-facebook-likebox').stop().animate(placement, 400);
		}, function() {
			placement[position] = -(parseInt($('.tiva-facebook-param-likebox-width').val()));
			$('.tiva-facebook-likebox').stop().animate(placement, 400);
		});

		// Likebox Popup
		if ($('.tiva-facebook-popup').length) {
			// Click to close popup
			$('html').on('click', function (e) {
				if (e.target.id == 'tiva-facebook-popup') {
					$('.tiva-facebook-popup').remove();
				}
			});

			$('.tiva-facebook-popup .close').on('click', function (e) {
				e.preventDefault();
				$('.tiva-facebook-popup').remove();
			});

			// Screen duration
			setTimeout(function () {
				$('.tiva-facebook-popup').remove();
			}, 20 * 1000);
		}
	});
})(jQuery);
