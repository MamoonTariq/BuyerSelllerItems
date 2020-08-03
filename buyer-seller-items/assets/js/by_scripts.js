// AJAX url

let ajax_url = bs_ajax_object.ajax_url;


jQuery(document).on('click','#bs_registeration',function(){



	jQuery('#bs_error_message').text('');

	let bs_username = document.getElementById('bs_username').value;

	let bs_email = document.getElementById('bs_email').value;

	let bs_password = document.getElementById('bs_password').value;

	let bs_dob = document.getElementById('bs_dob').value;

	let bs_address = document.getElementById('bs_address').value;

	let bs_image = jQuery('#bs_userprofile').prop('files')[0]; 

	//console.log(bs_image);



	if (bs_username =='' || bs_email =='' || bs_password =='' || bs_dob =='' || bs_address == '' ) {

		jQuery('#bs_error_message').text('All above Fields are Required');

	} else {

		if(IsEmail(bs_email)==false){

          jQuery('#bs_error_message').text('email is not valid');

        } else {

        	jQuery('form').append(`<div class="loader"></div>`);

        	jQuery("#bs_registeration").attr("disabled", true);

        	// jQuery('#bs_error_message').text('Processing');

        	var form_data = new FormData(); 

        	form_data.append('action', 'bs_registeration_callback');

        	form_data.append('bs_username', bs_username);

        	form_data.append('bs_email', bs_email);

        	form_data.append('bs_password', bs_password);

        	form_data.append('bs_dob', bs_dob);

        	form_data.append('bs_address', bs_address);

        	form_data.append('bs_image', bs_image);



			jQuery.ajax({

				url: ajax_url,

				type: 'POST',

				contentType: false,

				processData: false,

				data: form_data,

				success: function (response) {

					jQuery('.loader').remove();

					if (response == 'You have registered Successfully') {

						jQuery("form").trigger("reset");

						jQuery('#bs_error_message').text(response);

						setTimeout(function(){ 

							window.location.replace("https://freesale.usmaniqbal.com/login/"); 

						}, 1000);


					} else {

						jQuery("#bs_registeration").removeAttr("disabled");

						jQuery('#bs_error_message').text(response);

					}

				}

			});

		}

	}

});



function IsEmail(email) {

  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if(!regex.test(email)) {

    return false;

  }else{

    return true;

  }

}







// 





// let bs_login = document.getElementById('bs_login');

jQuery(document).on('click','#bs_login',function(){

	jQuery('#bs_error_message').text('');

	// e.preventDefault();

	//alert('successfully run');

	

	let bs_email = document.getElementById('bs_email').value;

	let bs_password = document.getElementById('bs_password').value;

	



	if (bs_email =='' || bs_password =='' ) {

		jQuery('#bs_error_message').text('Both Fields are Required');

	} else {

		// jQuery('form').append(`<div class="loader"></div>`);

        jQuery("#bs_login").attr("disabled", true);

		jQuery('#bs_error_message').text('Processing');

		// if(IsEmail(bs_email)==false){

  //         jQuery('#bs_error_message').text('email is not valid');

  //       } else {

			var data = {

				'action': 'bs_login_callback',

				'bs_email': bs_email,

				'bs_password': bs_password,

			};



			// Send Ajax Request

			jQuery.post(ajax_url, data, function(response) {

				// jQuery('.loader').remove();

				jQuery('#bs_error_message').text(response);

				jQuery("#bs_login").removeAttr("disabled");

				if (response == 'Logged in successfully') {

					setTimeout(function(){ 

					window.location.replace("https://freesale.usmaniqbal.com/my-profile/"); 

					}, 1000);

				}

			});

		//}

	}

});













jQuery(document).on('click','#bs_add_item',function(){

	jQuery('#bs_error_message').text('');

	// let choosen_cat = jQuery('form .chosen-select').val();
	let choosen_cat = jQuery("#category_select").chosen().val();
	console.log(choosen_cat);


	let bs_item_title = document.getElementById('bs_item_title').value;

	// let bs_tags = document.getElementById('bs_tags').value;

	let bs_location = document.getElementById('bs_location').value;

	let current_user = document.getElementById('current_user').value;

	let bs_item_img = jQuery('#bs_item_img').prop('files')[0];

	let product_type = jQuery("input[name='product_type']:checked").val();

	let description = jQuery.trim(jQuery("#desc").val());

	//console.log(bs_item_img);



	if (bs_item_title =='' || choosen_cat =='' || bs_location =='' || typeof product_type == 'undefined' ) {

		jQuery('#bs_error_message').text('Above Fields are Required');

	} else {

		jQuery('form').append(`<div class="loader"></div>`);


		jQuery("#bs_add_item").attr("disabled", true);

		var form_data = new FormData(); 

    	form_data.append('action', 'bs_add_item_callback');

    	form_data.append('bs_item_title', bs_item_title);

    	form_data.append('bs_choosen_cat', choosen_cat);

    	form_data.append('current_user', current_user);

    	form_data.append('bs_location', bs_location);

    	form_data.append('bs_item_img', bs_item_img);

    	form_data.append('product_type', product_type);

    	form_data.append('description', description);

    	jQuery.ajax({

			url: ajax_url,

			type: 'POST',

			contentType: false,

			processData: false,

			data: form_data,

			success: function (response) {

				jQuery('.loader').remove();

				jQuery("#bs_add_item").removeAttr("disabled");

				jQuery('#bs_error_message').text(response);

				if (response == 'Product Created Successfully') {

					jQuery("form").trigger("reset");

				}

			}

		});

	}

});





// Delete Post Thumbnail





jQuery(document).on('click','#img_del',function(){

	jQuery('#bs_error_message').text('');

	let current_post = document.getElementById('current_post').value;

	// jQuery('#bs_error_message').text('Processing');

	var form_data = new FormData(); 

	form_data.append('action', 'bs_delete_thumnail_callback');

	form_data.append('current_post', current_post);

	jQuery.ajax({

		url: ajax_url,

		type: 'POST',

		contentType: false,

		processData: false,

		data: form_data,

		success: function (response) {

			if (response == 'succ') {

				jQuery('.img_del').remove();

			}

		}

	});

});







// Update_Item



jQuery(document).on('click','#bs_update_item',function(){

	jQuery('#bs_error_message').text('');

	// e.preventDefault();

	//alert('successfully run');

	let choosen_cat = jQuery("#category_select").chosen().val();
	console.log(choosen_cat);
	

	let bs_item_title = document.getElementById('bs_item_title').value;

	// let bs_tags = document.getElementById('bs_tags').value;

	let bs_location = document.getElementById('bs_location').value;

	let current_user = document.getElementById('current_user').value;

	let bs_item_img = jQuery('#bs_item_img').prop('files')[0];

	let current_post_id = document.getElementById('current_post').value;

	let product_type = jQuery("input[name='product_type']:checked").val();

	let description = jQuery.trim(jQuery("#desc").val());


	//console.log(bs_item_img);



	if (bs_item_title =='' || choosen_cat =='' || bs_location =='' ) {

		jQuery('#bs_error_message').text('Both Fields are Required');

	} else {

		
		jQuery('form').append(`<div class="loader"></div>`);


		jQuery("#bs_update_item").attr("disabled", true);



		var form_data = new FormData(); 

    	form_data.append('action', 'bs_update_item_callback');

    	form_data.append('bs_item_title', bs_item_title);

    	form_data.append('bs_choosen_cat', choosen_cat);

    	form_data.append('current_user', current_user);

    	form_data.append('bs_location', bs_location);

    	form_data.append('bs_item_img', bs_item_img);

    	form_data.append('current_post_id', current_post_id);

    	form_data.append('product_type', product_type);

    	form_data.append('description', description);

    	jQuery.ajax({

			url: ajax_url,

			type: 'POST',

			contentType: false,

			processData: false,

			data: form_data,

			success: function (response) {

				

				jQuery('.loader').remove();

				jQuery("#bs_update_item").removeAttr("disabled");

				jQuery('#bs_error_message').text(response);

				// if (response == 'Product Created Successfully') {

				// 	jQuery("form").trigger("reset");

				// }

			}

		});

	}

});









// Delete Post 



jQuery(document).on('click','.delted_curent_post',function(){

	

	let current_post = jQuery(this).attr("id");

	// jQuery('#bs_error_message').text('Processing');

	var form_data = new FormData(); 

	form_data.append('action', 'bs_delete_post');

	form_data.append('current_post', current_post);

	jQuery.ajax({

		url: ajax_url,

		type: 'POST',

		contentType: false,

		processData: false,

		data: form_data,

		success: function (response) {

			if (response == 'succ') {

				jQuery(`#sing_${current_post}`).remove();

			}

		}

	});

});







// Upadate Profile





jQuery(document).on('click','#bs_update_profile',function(){



	jQuery('#bs_error_message').text('');

	let bs_username = document.getElementById('bs_username').value;

	let bs_email = document.getElementById('bs_email').value;

	// let bs_password = document.getElementById('bs_password').value;

	let bs_dob = document.getElementById('bs_dob').value;

	let bs_address = document.getElementById('bs_address').value;

	let bs_image = jQuery('#bs_userprofile').prop('files')[0]; 

	let current_user_id = document.getElementById('current_user_id').value;

	//console.log(bs_image);



	if (bs_username =='' || bs_email =='' || bs_dob =='' || bs_address == '' ) {

		jQuery('#bs_error_message').text('All above Fields are Required');

	} else {

		if(IsEmail(bs_email)==false){

          jQuery('#bs_error_message').text('email is not valid');

        } else {

        	jQuery('#bs_error_message').text('Processing');

        	var form_data = new FormData(); 

        	form_data.append('action', 'bs_update_profile_callback');

        	form_data.append('bs_username', bs_username);

        	form_data.append('bs_email', bs_email);

        	// form_data.append('bs_password', bs_password);

        	form_data.append('bs_dob', bs_dob);

        	form_data.append('bs_address', bs_address);

        	form_data.append('bs_image', bs_image);

        	form_data.append('current_user_id', current_user_id);



			jQuery.ajax({

				url: ajax_url,

				type: 'POST',

				contentType: false,

				processData: false,

				data: form_data,

				success: function (response) {

					jQuery('#bs_error_message').text(response);

				}

			});

		}

	}

});







// Delete user Image

jQuery(document).on('click','#img_del_user',function(){

	

	let current_post = document.getElementById('current_user_id').value;

	// jQuery('#bs_error_message').text('Processing');

	var form_data = new FormData(); 

	form_data.append('action', 'bs_delete_user_imge');

	form_data.append('current_post', current_post);

	jQuery.ajax({

		url: ajax_url,

		type: 'POST',

		contentType: false,

		processData: false,

		data: form_data,

		success: function (response) {

			if (response == 'succ') {

				jQuery(`.remove_img`).remove();

			}

		}

	});

});

