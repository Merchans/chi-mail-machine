(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	var statisticBtn = $('.statistic-btn');
	statisticBtn.click(function (e) {
		e.preventDefault();
		var clickedBtn = $(this);
		var statisticsFild = $(this).next().next();

		statisticsFild.remove('span.statistic-info');
		clickedBtn.prop('disabled', true);
		var inputVal = clickedBtn.prev().val();
		console.log(inputVal);
		clickedBtn.next().addClass('is-active');
		console.log();
		var postID = clickedBtn.data('postid');

		$.ajax({
			url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
			data: {
				'action': 'save_statistic_url', // This is our PHP function below
				'post_id': postID,
				'input_val': inputVal,
			},
			success: function (data) {
				console.log(data);
				clickedBtn.prop("disabled", false);
				statisticsFild.text(data);
			},
			error: function (errorThrown) {
				window.alert(errorThrown);
			},
			complete: function () {
				clickedBtn.next().removeClass('is-active');
			},

		});
	});

	function isValidURL(string) {
		var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
		return (res !== null)
	};
})(jQuery);
