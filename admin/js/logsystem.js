(function ($) {

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

		function isEmpty(el) {
			return !jQuery.trim(el.html())
		}

		nodeChangeLog();
		$('#chi_emailchoose-option').on('change', function () {
			nodeChangeLog();
		});
		var btn = $('#publishComment');

		btn.on('click', function (e) {
			var thisID = $(this).data('id');
			var option = $('#chi_emailchoose-option').val();
			var noteText = $('#chi_emailnotes-on-the-text');
			var noteDate = $('#chi_emaildate-the-email-was-sent');
			var noteTime = $('#chi_emailtime-the-email-was-sent');
			var specialNumber = $('#chi_email_special_number');
			var taxonomuSelect = $('#chi_email_taxonomy_select');
			var postTitle = $('#post-title-0');


			$('.spinner').addClass('is-active');
			e.preventDefault();

			console.log(noteText.val());
			console.log(option);

			var data = [];
			data["option"] = option;

			switch (option) {
				case '1':
					// code block
					if (noteText.val() == "" || noteText.val() == " ") {
						console.log('empty')
						$('.spinner').removeClass('is-active');
						return;
					}
					data["noteText"] = noteText.val();
					break;
				case '2':
					if (
						noteDate.val() == "" ||
						noteTime.val() == "" ||
						postTitle.val() == "" ||
						specialNumber.val() == "" ||
						taxonomuSelect.val() == ""
					) {
						$('.spinner').removeClass('is-active');
						break;
					}

					data["noteText"] = noteText.val();
					data["noteDate"] = noteDate.val();
					data["noteTime"] = noteTime.val();
					data["postTitle"] = postTitle.val();
					data["specialNumber"] = specialNumber.val();
					data["taxonomuSelect"] = taxonomuSelect.val();
					break;
				case '3':
					// code block
					$('.spinner').removeClass('is-active');
					break;
				default:
				// code block
			}

			console.log(data)

			// This does the ajax request (The Call).
			$.ajax({
				url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
				data: {
					'action': 'example_ajax_request', // This is our PHP function below
					'data': {
						option: data["option"],
						noteText: data["noteText"],
						noteDate: data["noteDate"],
						noteTime: data["noteTime"],
						specialNumber: data["specialNumber"],
						taxonomuSelect: data["taxonomuSelect"],
						postTitle: data["postTitle"],
					}, // This is the variable we are sending via AJAX
					'post_id': thisID,
				},
				success: function (data) {
					// $('#chi_emailnotes-on-the-text').val()
					var commentData = $.parseJSON(data);
					console.log(commentData);

					switch (option) {
						case "1":
							$('ul.order_notes').prepend('<li rel="" class="note">\n' +
								'\t\t\t\t\t\t<div class="note_content ">\n' +
								'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p>' + $('#chi_emailnotes-on-the-text').val() + '</p>\n' +
								'\t\t\t\t\t\t</div>\n' +
								'\t\t\t\t\t\t<p class="meta">\n' +
								'\t\t\t\t\t\t\t<abbr class="exact-date" title="' + commentData.comment_date + '">\n' +
								'\t\t\t\t\t\t\t\t' + commentData.comment_date + '</abbr>\n' +
								'\t\t\t\t\t\t\t' + commentData.comment_author + '\t\t\t\t\t\t\t<a href="comment.php?action=editcomment&c=' + commentData.comment_id + '" class="vim-q comment-inline button-link" role="button">Edit note</a> |\n' +
								'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<a href="comment.php?action=trashcomment&p=' + commentData.comment_post_ID + '&c=' + commentData.comment_id + '&reason=1" class="delete_note" role="button">Delete\n' +
								'\t\t\t\t\t\t\t\tnote</a>\n' +
								'\t\t\t\t\t\t</p>\n' +
								'\t\t\t\t\t</li>').show('slow');
							$('#chi_emailnotes-on-the-text').val("");
							break;
						case "2":
							$('ul.order_notes').prepend('<li rel="" class="note">\n' +
								'\t\t\t\t\t\t<div class="note_content note_content--info">\n' +
								'\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p>Predmet emailu:\n' +
								'\t\t\t\t\t\t\t\t\t<strong>' + commentData.subject_data + '</strong>\n' +
								'\t\t\t\t\t\t\t\t</p>\n' +
								'\t\t\t\t\t\t\t\t\t\t\t\t\t\t' + commentData.comment_content + '\n' +
								'\t\t\t\t\t\t</div>\n' +
								'\t\t\t\t\t\t<p class="meta">\n' +
								'\t\t\t\t\t\t\t<abbr class="exact-date" title="' + commentData.comment_date + '">\n' +
								'\t\t\t\t\t\t\t\t' + commentData.comment_date + '</abbr>\n' +
								'\t\t\t\t\t\t\t' + commentData.comment_author + '\t\t\t\t\t\t\t<a href="comment.php?action=editcomment&c=' + commentData.comment_id + '" class="vim-q comment-inline button-link" role="button">Edit note</a> |\n' +
								'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<a href="comment.php?action=trashcomment&p=' + commentData.comment_post_ID + '&c=' + commentData.comment_id + '&reason=1" class="delete_note" role="button">Delete\n' +
								'\t\t\t\t\t\t\t\tnote</a>\n' +
								'\t\t\t\t\t\t</p>\n' +
								'\t\t\t\t\t</li>');
							break;
					}
				},
				error: function (errorThrown) {
					window.alert(errorThrown);
				},
				complete: function () {
					$('.spinner').removeClass('is-active');
				},

			});

			function GetNow() {
				var currentdate = new Date();
				var datetime =
					+currentdate.getFullYear() + "-"
					+ (currentdate.getMonth() + 1) + "-"
					+ currentdate.getDate() + " "
					+ currentdate.getHours() + ":"
					+ currentdate.getMinutes() + ":"
					+ currentdate.getSeconds();
				return datetime;
			}

		});

		var note_area = $('ul.order_notes ');

		note_area.on('click', 'a.delete_note', function (e) {
			var element = $(this).parent().parent();
			var thisCommentID = $(this).attr("href");
			e.preventDefault();
			var isGood = confirm('Are you sure you wish to delete this note?');
			if (isGood) {
				$.ajax({
					url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
					data: {
						'action': 'delete_comment_ajax_request', // This is our PHP function below
						'comment_id': thisCommentID,
					},
					success: function (data) {
						console.log(data);
						element.fadeOut('slow');
					},
					error: function (errorThrown) {
						window.alert(errorThrown);
					},
					complete: function () {
						$('.spinner').removeClass('is-active');
					},

				});
			}
		});


	});

})(jQuery);

