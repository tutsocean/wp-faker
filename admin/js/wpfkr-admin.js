(function( $ ) {
	'use strict';

	$(function() {
		//var data_val = $('#wpfkrGenPostForm').serialize();
		
		$('#wpfkrListPostsTbl').DataTable();

		var is_sending = false,
		failure_message = 'Whoops, looks like there was a problem. Please try again later.';
 
		$('#wpfkrGenPostForm').submit(function (e) {
			var url = backend_ajax_object.wpfkr_ajax_url;
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			var $this = $(this); // Cache this
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'JSON', // Set this so we don't need to decode the response...
				data: $this.serialize(), // One-liner form data prep...
				beforeSend: function () {
					is_sending = true;
					$('.wpfkrGeneratePosts').val('Generating posts.');
					// You could do an animation here...
				},
				error: handleFormError,
				success: function (data) {
					$('.wpfkrGeneratePosts').val('Generate posts.');
					if (data.status === 'success') {
						$('.wpfkr-success-msg').html('Posts generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
					} else {
						handleFormError(); // If we don't get the expected response, it's an error...
					}
					is_sending = false;
				}
			});
		});

		$('#wpfkrGenUserForm').submit(function (e) {
			var url = backend_ajax_object.wpfkr_ajax_url;
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			var $this = $(this); // Cache this
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'JSON', // Set this so we don't need to decode the response...
				data: $this.serialize(), // One-liner form data prep...
				beforeSend: function () {
					is_sending = true;
					$('.wpfkrGenerateUsers').val('Generating users.');
					// You could do an animation here...
				},
				error: handleFormError,
				success: function (data) {
					$('.wpfkrGenerateUsers').val('Generate users.');
					if (data.status === 'success') {
						$('.wpfkr-success-msg').html('Users generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
					} else {
						handleFormError(); // If we don't get the expected response, it's an error...
					}
					is_sending = false;
				}
			});
		});

		function handleFormError () {
			is_sending = false; // Reset the is_sending var so they can try again...
			$('.wpfkr-error-msg').html('Something went wrong. Please try again').fadeIn('fast').delay(1000).fadeOut('slow');
			//alert(failure_message);
		}
	});

})( jQuery );
