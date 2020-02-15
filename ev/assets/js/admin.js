(function($) {
	'use strict';

	$(document).ready(function() {
		$('.btn-delete-admin').on('click', function(e) {
			alert("This admin user can't be deleted !");
			e.preventDefault();
		});

		$('.btn-delete').on('click', function(e) {
			var question = 'Are you sure you want to delete this ?';
			if (!confirm(question)) {
				e.preventDefault();
			}
		});
	});
})(jQuery);
