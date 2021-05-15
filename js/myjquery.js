jQuery(document).ready(function($) {       //wrapper
	$("#chi_emailchoose-option").change(function() {         //event
		var this2 = this;
		console.log(this2); //use in callback
		$.post(my_ajax_obj.ajax_url, {     //POST request
			_ajax_nonce: my_ajax_obj.nonce, //nonce
			action: "my_tag_count",        //action
			title: this.value              //data
		}, function(data) {                //callback
			this2.nextSibling.remove();    //remove the current title
			console.log(data);
			$(this2).after(data);          //insert server response
		});
	});
});
