(function( $ ) {
	'use strict';

	$(function() {
		//var data_val = $('#wpfkrGenPostForm').serialize();
		$('#wpfkrListPostsTbl').DataTable();
		var is_sending = false,
		failure_message = 'Whoops, looks like there was a problem. Please try again later.';
		$('#wpfkrGenPostForm').submit(function (e) {
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			$('.remaining_posts').val($('.wpfkr-post_count').val());
			var $this = $(this); // Cache this
			// call ajax here
			wpfkr_generatePostsLoop($this);
		});

		$('#wpfkrGenUserForm').submit(function (e) {
			var url = backend_ajax_object.wpfkr_ajax_url;
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			$('.remaining_users').val($('.wpfkr-user_count').val());
			var $this = $(this); // Cache this
			wpfkr_generateUsersLoop($this)
		});

		function handleFormError () {
			is_sending = false; // Reset the is_sending var so they can try again...
			$('.wpfkr-error-msg').html('Something went wrong. Please try again').fadeIn('fast').delay(1000).fadeOut('slow');
			//alert(failure_message);
		}

		function wpfkr_generatePostsLoop($that){
			var $this = $that;
			var url = backend_ajax_object.wpfkr_ajax_url;
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
					if (data.status === 'success' && data.remaining_posts>0) {
						$('.remaining_posts').val(data.remaining_posts);
						var totalOfPosts = $('.wpfkr-post_count').val();
						console.log(data.remaining_posts+' posts are remaining out of '+totalOfPosts);
						$('.remaining_notification').html(data.remaining_posts+' posts are remaining out of '+totalOfPosts);
						wpfkr_generatePostsLoop($this);
					}else if (data.status === 'success' && data.remaining_posts==0){
						$('.wpfkr-success-msg').html('Posts generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
						$('.remaining_notification').html('');
						is_sending = false;
					}else {
						handleFormError(); // If we don't get the expected response, it's an error...
						is_sending = false;
					}
					
				}
			});
		}

		function wpfkr_generateUsersLoop($that){
			var $this = $that;
			var url = backend_ajax_object.wpfkr_ajax_url;
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
					if (data.status === 'success' && data.remaining_users>0) {
						$('.remaining_users').val(data.remaining_users);
						var totalOfUsers = $('.wpfkr-user_count').val();
						console.log(data.remaining_users+' users are remaining out of '+totalOfUsers);
						$('.remaining_notification').html(data.remaining_users+' users are remaining out of '+totalOfUsers);
						wpfkr_generateUsersLoop($this);
					}else if (data.status === 'success' && data.remaining_users==0){
						$('.wpfkr-success-msg').html('Users generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
						$('.remaining_notification').html('');
						$('.wpfkrGenerateUsers').val('Generate users.');
						is_sending = false;
					}else {
						handleFormError(); // If we don't get the expected response, it's an error...
						is_sending = false;
					}
					
				}
			});
		}

	});

})( jQuery );
