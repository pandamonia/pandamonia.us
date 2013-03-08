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
				
				function error(string) {
					var error = 'Error: '+string,
						$message = $("#error-alert .message");
					if ($message.length) {
						$message.fadeOut('fast', function() {
							$(this).text(error).fadeIn('fast');
						});
					} else {
						$form.before($('<div class="row" id="error-alert"><div class="large-12 columns"><div data-alert class="alert-box alert round"><span class="message">'+error+'</span></div></div></div>').hide().fadeIn());
					}
					
					$inputs.prop("disabled", false);
				}

				$.ajax({
					url: "/form.php",
					type: "post",
					data: serializedData
				}).done(function(response, textStatus, jqXHR){
					if (response.error)
						return error(response.error);
					
					$form.before($('<div class="row" id="success-alert"><div class="large-12 columns"><div data-alert class="alert-box round"><span class="message">Thank you for getting in contact with us. We should respond within the next few business days.</span></div></div></div>').hide().fadeIn());
				}).fail(function(jqXHR, textStatus, errorThrown){
					error(errorThrown);
				});
			}
		});
	});
})(jQuery, this);