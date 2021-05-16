(function ($) {

	function deleteNote() {
		return confirm('Do you really want to submit the form?');
	}

	$(function () {
		// Code goes here
		function nodeChangeLog() {
			if ($('#chi_emailchoose-option').val() == "1") {
				$('tr.tr-chi_emaildate-the-email-was-sent').fadeOut();
				$('tr.tr-chi_emailtime-the-email-was-sent').fadeOut();
				$('tr.tr-chi_emailfor').fadeOut();
				$('tr.tr-chi_emailemail-subject').fadeOut();
				$('tr.tr-chi_emailnotes-on-the-text').fadeIn();
			}
			if ($('#chi_emailchoose-option').val() == "2") {
				$('tr.tr-chi_emaildate-the-email-was-sent').fadeIn();
				$('tr.tr-chi_emailtime-the-email-was-sent').fadeIn();
				$('tr.tr-chi_emailnotes-on-the-text').fadeOut(600);
				$('tr.tr-chi_emailfor').fadeOut();
				$('tr.tr-chi_emailemail-subject').fadeOut();
			}
			if ($('#chi_emailchoose-option').val() == "3") {
				$('tr.tr-chi_emaildate-the-email-was-sent').fadeIn();
				$('tr.tr-chi_emailtime-the-email-was-sent').fadeIn();
				$('tr.tr-chi_emailfor').fadeIn();
				$('tr.tr-chi_emailnotes-on-the-text').fadeIn();
				$('tr.tr-chi_emailemail-subject').fadeIn();
			}
		}

		nodeChangeLog();
		$('#chi_emailchoose-option').on('change', function () {
			nodeChangeLog();
		});

		// This is the variable we are passing via AJAX
		var fruit = 'Banana';

		// This does the ajax request (The Call).
		$.ajax({
			url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
			data: {
				'action':'example_ajax_request', // This is our PHP function below
				'fruit' : fruit // This is the variable we are sending via AJAX
			},
			success:function(data) {
				// This outputs the result of the ajax request (The Callback)
				window.alert(data);
			},
			error: function(errorThrown){
				window.alert(errorThrown);
			}
		});

	});
})(jQuery);
