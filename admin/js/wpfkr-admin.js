(function( $ ) {
	'use strict';

	$(function() {

		// manage data from adminbar links
		$(document).on('click','.wpfkrDataCleaner',function(event){
			event.preventDefault();
			var wpfkrEventID = $(this).attr('id');
			console.log(wpfkrEventID);
			var wpfkrAction = '';
			switch(wpfkrEventID) {
			    case 'wp-admin-bar-wpfkrDeleteUsers':
			        wpfkrAction = 'wpfkrDeleteUsers';
			        break;
			    case 'wp-admin-bar-wpfkrDeletePosts':
			        wpfkrAction = 'wpfkrDeletePosts';
			        break;
			    case 'wp-admin-bar-wpfkrDeleteProducts':
			        wpfkrAction = 'wpfkrDeleteProducts';
			        break;
			    case 'wp-admin-bar-wpfkrDeleteThumbnails':
			        wpfkrAction = 'wpfkrDeleteThumbnails';
			        break;			    
			    default:

			}
			wpfkrAjaxManageData(wpfkrAction);
			console.log(wpfkrAction);
		});

		function wpfkrAjaxManageData(wpfkrAction){
			var url = wpfkr_backend_ajax_object.wpfkr_ajax_url;
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'JSON', // Set this so we don't need to decode the response...
				data:  ({ action: wpfkrAction}), // One-liner form data prep...
				beforeSend: function () {
					$('#wpfooter').append('<div class="wpfkrLoading">Loading&#8230;</div>');
					$('#wpfooter').show();
					// You could do an animation here...
				},
				error: handleFormError,
				success: function (data) {
					$('.wpfkrLoading').remove();
					if (data.status === 'success') {
						console.log('success');
					}else {
						handleFormError(); // If we don't get the expected response, it's an error...
						//is_sending = false;
					}
				}
			});
		}
		// manage data from adminbar links


		//var data_val = $('#wpfkrGenPostForm').serialize();
		$('#wpfkrListPostsTbl').DataTable();
		$('#wpfkrListProductsTbl').DataTable();
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
			$('.dcsLoader').show();
			//$('.remaining_notification').html('').html('<p>Post generator initialized. Waiting for the first response...</p>');
			wpfkr_generatePostsLoop($this);
		});

		$('#wpfkrGenProductForm').submit(function (e) {
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			$('.remaining_products').val($('.wpfkr-product_count').val());
			var $this = $(this); // Cache this
			// call ajax here
			//$('.remaining_notification').html('').html('<p>Products generator initialized. Waiting for the first response...</p>');
			$('.dcsLoader').show();
			wpfkr_generateProductsLoop($this);
		});

		$('#wpfkrGenUserForm').submit(function (e) {
			var url = wpfkr_backend_ajax_object.wpfkr_ajax_url;
			if (is_sending) {
				return false; // Don't let someone submit the form while it is in-progress...
			}
			e.preventDefault(); // Prevent the default form submit
			$('.remaining_users').val($('.wpfkr-user_count').val());
			$('.dcsLoader').show();
			//$('.remaining_notification').html('').html('<p>User generator initialized. Waiting for the first response...</p>');
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
			var url = wpfkr_backend_ajax_object.wpfkr_ajax_url;
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
						
						// loader
						var WPFKRcompletedPer = Math.round(( (totalOfPosts - data.remaining_posts ) * 100 ) /totalOfPosts);
						$('.wpfkrLoaderPer').text(WPFKRcompletedPer+'%');
						var addedClass = 'p'+WPFKRcompletedPer;
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass(addedClass);
						// loader

						//$('.remaining_notification').html('').html('<p>'+data.remaining_posts+' posts are remaining out of '+totalOfPosts+'</p>');
						wpfkr_generatePostsLoop($this);
					}else if (data.status === 'success' && data.remaining_posts==0){
						$('.wpfkr-success-msg').html('Posts generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
						// loader
						$('.wpfkrLoaderPer').text('100%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p100');
						$('.dcsLoader').hide();
						$('.wpfkrLoaderPer').text('0%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p0');
						// loader
						//$('.remaining_notification').html('');
						is_sending = false;
					}else {
						handleFormError(); // If we don't get the expected response, it's an error...
						is_sending = false;
					}
				}
			});
		}


		function wpfkr_generateProductsLoop($that){
			var $this = $that;
			var url = wpfkr_backend_ajax_object.wpfkr_ajax_url;
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'JSON', // Set this so we don't need to decode the response...
				data: $this.serialize(), // One-liner form data prep...
				beforeSend: function () {
					is_sending = true;
					$('.wpfkrGenerateProducts').val('Generating products.');
					// You could do an animation here...
				},
				error: handleFormError,
				success: function (data) {
					$('.wpfkrGenerateProducts').val('Generate products.');
					if (data.status === 'success' && data.remaining_products>0) {
						$('.remaining_products').val(data.remaining_products);
						var totalOfProducts = $('.wpfkr-product_count').val();
						
						// loader
						var WPFKRcompletedPer = Math.round(( (totalOfProducts - data.remaining_products ) * 100 ) /totalOfProducts);
						$('.wpfkrLoaderPer').text(WPFKRcompletedPer+'%');
						var addedClass = 'p'+WPFKRcompletedPer;
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass(addedClass);
						// loader

						//$('.remaining_notification').html('').html('<p>'+data.remaining_products+' products are remaining out of '+totalOfProducts+'</p>');
						wpfkr_generateProductsLoop($this);
					}else if (data.status === 'success' && data.remaining_products==0){
						
						// loader
						$('.wpfkrLoaderPer').text('100%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p100');
						$('.dcsLoader').hide();
						$('.wpfkrLoaderPer').text('0%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p0');
						// loader

						$('.wpfkr-success-msg').html('Products generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
						//$('.remaining_notification').html('');
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
			var url = wpfkr_backend_ajax_object.wpfkr_ajax_url;
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

						// loader
						var WPFKRcompletedPer = Math.round(( (totalOfUsers - data.remaining_users ) * 100 ) /totalOfUsers);
						$('.wpfkrLoaderPer').text(WPFKRcompletedPer+'%');
						var addedClass = 'p'+WPFKRcompletedPer;
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass(addedClass);
						// loader

						//$('.remaining_notification').html('').html('<p>'+data.remaining_users+' users are remaining out of '+totalOfUsers+'</p>');
						wpfkr_generateUsersLoop($this);
					}else if (data.status === 'success' && data.remaining_users==0){
						$('.wpfkr-success-msg').html('Users generated successfully.').fadeIn('fast').delay(1000).fadeOut('slow');
						//$('.remaining_notification').html('');
						// loader
						$('.wpfkrLoaderPer').text('100%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p100');
						$('.dcsLoader').hide();
						$('.wpfkrLoaderPer').text('0%');
						$('.wpfkrLoaderWrpper').attr('class','wpfkrLoaderWrpper c100 blue');
						$('.wpfkrLoaderWrpper').addClass('p0');
						//loader
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
