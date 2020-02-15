(function($) {
	'use strict';

	$(document).ready(function($) { 
		$('.back-to-top').on('click', function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, 700);
		});
		$('.menu-item a').on('click', function(e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: $($(this).attr('href')).offset().top - 15 + "px"
			}, 700);
		});
	});
})(jQuery);
