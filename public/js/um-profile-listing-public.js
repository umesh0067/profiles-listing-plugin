(function( $ ) {
	//'use strict';
	jQuery(document).ready(function($) {
		$('.selectskills').select2();
		$('.selecteduction').select2();

		// for range slider
		var rangeSlider = document.getElementById("inputage");
		var rangeValue = document.getElementById("agevalue");
		// Update the value display when the slider is moved
		rangeSlider.addEventListener("input", function() {
			rangeValue.textContent = this.value;
		});

		// for profile listing datatable
		jQuery('.profile_lists').DataTable({
			info: false,
			ordering: true,
			paging: true,
			searching: false,
			columnDefs: [{
                targets: 0,
                data: null,
                defaultContent: '',
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            }]
		});


		// for profile search ajax
		jQuery(document).on('submit', '#um_profile_li_form', function(e) {
			e.preventDefault();
			var wp_nonce = um_Ajax.ajax_nonce;
			$('.ajax-loader').show(); //loader show
			$('.um_filter_btn').hide(); //search button hide
        	
			var keyword = jQuery('#keywordinput').val();
			var skills = JSON.stringify($('.selectskills').val());
			var education = JSON.stringify($('.selecteduction').val());
			var age = jQuery('#inputage').val();
			var ratings = jQuery('.star-rating input:checked').val();
			var no_of_jobs_completed = jQuery('#inputnojobs').val();
			var yearofexperience = jQuery('#inputexperience').val();
			

			$.ajax({
				url: um_Ajax.ajaxurl,
				cache: false,
				type: 'POST',
				// contentType: false,
				// processData: false,
				data: { 
					"action": "profile_search", 
					"keyword": keyword, 
					"skills": skills, 
					"education": education,
					"age": age, 
					"ratings": ratings,
					"no_of_jobs_completed": no_of_jobs_completed, 
					"yearofexperience": yearofexperience,
					"wp_nonce": wp_nonce

				},
				success: function (response) {
					$('.um_datatable_wrapper').html(response.data.html);
					$('#profile_lists').DataTable({
						info: false,
						destroy: true,
						ordering: true,
						paging: true,
						searching: false,
						columnDefs: [{
							targets: 0,
							data: null,
							defaultContent: '',
							orderable: false,
							render: function (data, type, row, meta) {
								return meta.row + 1;
							}
						}]
					});

					$('.ajax-loader').hide(); //loader hide
					$('.um_filter_btn').show(); //search button show
				}
			});

		});
		


		// $('.star-rating input').on('click', function() {
		// 	var rating = $(this).val();
			
		// 	// Save the rating value (you can use Ajax to save it to the server)
		// 	$('.star-rating').data('rating', rating);
			
		// 	// Blink effect
		// 	var star = $(this).next('label');
		// 	star.fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
			
		// 	// You can also add additional logic here to handle the saved rating
		// 	console.log('Selected Rating:', rating);
		// });




		$('.star-rating input').on('click', function() {
			var clickedValue = $(this).val();
			var currentRating = $('.star-rating').data('rating');
	
			// Clear all stars
			$('.star-rating label').removeClass('filled');
	
			// Fill the stars up to the clicked one with a specific color
			$('.star-rating label').each(function(index) {
				if (index < clickedValue) {
					$(this).addClass('filled'); // Change the color as needed
				}
			});
	
			// Update the data-rating attribute
			$('.star-rating').data('rating', clickedValue);
	
			// You can also add additional logic here to handle the saved rating
			console.log('Selected Rating:', clickedValue);
		});
		

	});  

})( jQuery );
