(function ($) {
	let emailFor = $('#chi_emailfor');
	var availableTags = [
		"ActionScript",
		"AppleScript",
		"Asp",
		"BASIC",
		"C",
		"C++",
		"Clojure",
		"COBOL",
		"ColdFusion",
		"Erlang",
		"Fortran",
		"Groovy",
		"Haskell",
		"Java",
		"JavaScript",
		"Lisp",
		"Perl",
		"PHP",
		"Python",
		"Ruby",
		"Scala",
		"Scheme"
	];

	function split(val) {
		return val.split(/,\s*/);
	}

	function extractLast(term) {
		return split(term).pop();
	}

	// emailAutoComplete(emailFor, availableTags);
	function log( message ) {
		$( "<div>" ).text( message ).prependTo( "#log" );
		$( "#log" ).scrollTop( 0 );
	}
	function emailAutoComplete(emailFor, availableTags) {

		emailFor.on("keydown", function (event) {
			if (event.keyCode === $.ui.keyCode.TAB &&
				$(this).autocomplete("instance").menu.active) {
				event.preventDefault();
			}

		}).autocomplete({
			minLength: 0,
			source: function (request, response) {
				// delegate back to autocomplete, but extract the last term
				response($.ui.autocomplete.filter(
					availableTags, extractLast(request.term)));

			},
			focus: function () {
				// prevent value inserted on focus
				return false;
			},
			select: function (event, ui) {
				var terms = split(this.value);
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push(ui.item.value);
				// add placeholder to get the comma-and-space at the end
				terms.push("");
				this.value = terms.join(", ");
				return false;
			}
		});
	}

	emailFor.autocomplete({
		source: function (request, response) {
			$.ajax({
				url: ajaxurl,
				data: {
					'action': 'chi_ajax_all_useres',
					'email': request,
				},
				success: function (data) {
					var type = jQuery.type(data);

					data = data.replace('[', '');
					data = data.replace(']', '');
					data = data.replaceAll('"', '');
					var data = data.split(",");


					response(data);
				}
			});
		},
		minLength: 2,
		select: function (event, ui) {
			log("Selected: " + ui.item.value + " aka " + ui.item.id);
		}
	});
	// emailFor.on("focus", function () {
	//
	// 	$.ajax({
	// 		url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
	// 		data: {
	// 			'action': 'chi_ajax_all_useres'
	// 		},
	// 		success: function (data) {
	//
	// 			var type = jQuery.type(data);
	// 			console.log(type);
	// 			data = data.replace('[','');
	// 			data = data.replace(']','');
	// 			data = data.replaceAll('"','');
	//
	// 			var data = data.split(",");
	// 			console.log(data);
	// 			emailFor.on("keydown", function (event) {
	// 				if (event.keyCode === $.ui.keyCode.TAB &&
	// 					$(this).autocomplete("instance").menu.active) {
	// 					event.preventDefault();
	// 				}
	// 				console.log(data);
	// 				console.log('1.');
	// 			}).autocomplete({
	// 				minLength: 0,
	// 				source: function (request, response) {
	// 					// delegate back to autocomplete, but extract the last term
	// 					response($.ui.autocomplete.filter(
	// 						data, extractLast(request.term)));
	// 					console.log('2.');
	// 				},
	// 				focus: function () {
	// 					// prevent value inserted on focus
	// 					return false;
	// 				},
	// 				select: function (event, ui) {
	// 					var terms = split(this.value);
	// 					// remove the current input
	// 					terms.pop();
	// 					// add the selected item
	// 					terms.push(ui.item.value);
	// 					// add placeholder to get the comma-and-space at the end
	// 					terms.push("");
	// 					this.value = terms.join(", ");
	// 					return false;
	// 				}
	// 			});
	//
	// 		},
	// 		error: function (errorThrown) {
	// 			console.log(errorThrown);
	// 		},
	// 		complete: function () {
	//
	// 		},
	//
	// 	});
	// });

})(jQuery);
