;(function ($, window, undefined) {
	$(function() {
		$('textarea').autosize();
		
		var request;
		$('#contact').validate({
			errorElement: "small",
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				},
				message: "required"
			},
			messages: {
				name: "Please specify your name.",
				email: {
					required: "We need your email address so we can reply to you.",
					email: "Your email address must be in the form <i>username@domain.tld</i>."
				},
				message: "Please enter a message to send."
			},
			submitHandler: function(form) {
				// Abort any pending request.
				if (request)
					request.abort();
				
				var $form = $(form);
				var $inputs = $form.find("input, select, button, textarea");
				var serializedData = $form.serialize();
				
				$inputs.prop("disabled", true);
				
				var request = $.ajax({
					url: "/form.php",
					type: "post",
					data: serializedData
				});
				
			    // Callback handler that will be called on success.
			    request.done(function(response, textStatus, jqXHR){
			        // log a message to the console
			        console.log("Hooray, it worked!");
			    });
			
			    // Callback handler that will be called on failure.
			    request.fail(function(jqXHR, textStatus, errorThrown){
			        // log the error to the console
			        console.error("The following error occured: " + textStatus, errorThrown);
			    });
			
			    // Callback handler that will be called regardless
			    // if the request failed or succeeded
			    request.always(function () {
			        // Reenable the inputs
			        $inputs.prop("disabled", false);
			    });
			}
		});
	});
})(jQuery, this);