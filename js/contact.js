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
					$form.before($('<div class="row" id="success-alert"><div class="large-12 columns"><div data-alert class="alert-box round"><span class="message">Thank you for getting in contact with us. We should respond within the next few business days.</span></div></div></div>').hide().fadeIn()).fadeOut(function() {
						$(this).remove();
					});
				});
			
				// Callback handler that will be called on failure.
				request.fail(function(jqXHR, textStatus, errorThrown){
					// log the error to the console
					var error = 'Error: '+errorThrown,
						$message = $("#error-alert .message");
					if ($message.length) {
						$message.fadeOut('fast', function() {
							$(this).text(error).fadeIn('fast');
						});
					} else {
						$form.before($('<div class="row" id="error-alert"><div class="large-12 columns"><div data-alert class="alert-box alert round"><span class="message">'+error+'</span></div></div></div>').hide().fadeIn());
					}
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