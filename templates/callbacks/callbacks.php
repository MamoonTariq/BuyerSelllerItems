<?php



add_action( 'wp_ajax_bs_registeration_callback', 'bs_registeration_callback_callback' );

add_action( 'wp_ajax_nopriv_bs_registeration_callback', 'bs_registeration_callback_callback' );

function bs_registeration_callback_callback() {

   

	$bs_username  = $_REQUEST['bs_username'];

	$bs_email  = $_REQUEST['bs_email'];

	$bs_password  = $_REQUEST['bs_password'];

	$bs_dob  = $_REQUEST['bs_dob'];

	$bs_address  = $_REQUEST['bs_address'];

	$image_url = $_FILES['bs_image'];

	

	$exists = email_exists( $bs_email );



	if ( $exists ) {

		echo "That E-mail is already Exist";

	} else {

		$userdata = array(

			'user_pass'   => $bs_password,  

			'user_login'  => $bs_username, 

			'user_nicename' => $bs_username,   

			'user_email'   => $bs_email, 

			'role'       => 'subscriber',   

		);

		$user_id = wp_insert_user( $userdata ) ;



	

        //echo $attach_id;



		if ( ! is_wp_error( $user_id ) ) {

			echo "You have registered Successfully";



        	

			add_user_meta($user_id,'birthday',$bs_dob);

			add_user_meta($user_id,'address',$bs_address);

			add_user_meta($user_id,'user_earn','');



			if ($image_url) {

				$file_name = $_FILES['bs_image']['name'];

		        $file_temp = $_FILES['bs_image']['tmp_name'];

		        $upload_dir = wp_upload_dir();

		        $image_data = file_get_contents( $file_temp );

		        $filename = basename( $file_name );

		        $filetype = wp_check_filetype($file_name);

		        $filename = time().'.'.$filetype['ext'];

		        if ( wp_mkdir_p( $upload_dir['path'] ) ) {

		          $file = $upload_dir['path'] . '/' . $filename;

		        }

		        else {

		          $file = $upload_dir['basedir'] . '/' . $filename;

		        }

		        file_put_contents( $file, $image_data );

		        $wp_filetype = wp_check_filetype( $filename, null );

		        $attachment = array(

		          'post_mime_type' => $wp_filetype['type'],

		          'post_title' => sanitize_file_name( $filename ),

		          'post_content' => '',

		          'post_status' => 'inherit'

		        );

		        $attach_id = wp_insert_attachment( $attachment, $file );

		        require_once( ABSPATH . 'wp-admin/includes/image.php' );

		        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		        wp_update_attachment_metadata( $attach_id, $attach_data );

		        add_user_meta( $user_id, 'image', $attach_id );

			}



		} else{

			echo $user_id->get_error_message();

		}

	}



	wp_die(); 

}









// Login Form



add_action( 'wp_ajax_bs_login_callback', 'bs_login_callback_callback' );

add_action( 'wp_ajax_nopriv_bs_login_callback', 'bs_login_callback_callback' );

function bs_login_callback_callback() {

   

	

	$bs_email  = $_REQUEST['bs_email'];

	$bs_password  = $_REQUEST['bs_password'];



	$exists = email_exists( $bs_email );

	$bs_username = username_exists($bs_email);



	if ( $exists || $bs_username ) {

		if ($exists) {

			$user = get_user_by( 'email', $bs_email );

		}

		if($bs_username){

			$user = get_user_by( 'login', $bs_email );

		}



		// $user = get_user_by( 'email', $bs_email );

		

		if ( $user && wp_check_password( $bs_password, $user->data->user_pass, $user->ID ) ) {

			//echo "Login Successfully";

			$user_login = $user->data->user_login;

			// print_r($user_login);
			// die('dfs');

			wp_clear_auth_cookie();
	        wp_set_current_user ( $user->ID ); // Set the current user detail
	        wp_set_auth_cookie  ( $user->ID ); // Set auth details in cookie
	        echo "Logged in successfully";

			// wp_redirect(home_url()); 

		} else{

			echo "Password Not Matched";

		}



	} else {

		echo "User Not Exists";

	}



	wp_die(); 

}









// Added Products



add_action( 'wp_ajax_bs_add_item_callback', 'bs_add_item_callback_callback' );

add_action( 'wp_ajax_nopriv_bs_add_item_callback', 'bs_add_item_callback_callback' );

function bs_add_item_callback_callback() {

   

	

	$bs_item_title  = $_REQUEST['bs_item_title'];

	// $bs_tags  = $_REQUEST['bs_tags'];
	$bs_cat  = $_REQUEST['bs_choosen_cat'];
	$final_cats = explode(',', $bs_cat);
	$categories = array_map(
	    function($value) { return (int)$value; },
	    $final_cats
	);
	// print_r($bs_tags); die();

	$current_user  = $_REQUEST['current_user'];

	$bs_location  = $_REQUEST['bs_location'];

	$image_url = $_FILES['bs_item_img'];

	$product_type  = $_REQUEST['product_type'];

	$description  = $_REQUEST['description'];

	// print_r($image_url);

	// die();



	$my_post = array(

		'post_title'    => wp_strip_all_tags( $bs_item_title ),

		'post_status'   => 'publish',

		'post_author'   => $current_user,

		'post_type'     => 'buy_sell_items',

		'post_content'  => $description

	);

	

	$post_id = wp_insert_post( $my_post );

	if(!is_wp_error($post_id)){

		echo 'Product Created Successfully';

		add_post_meta($post_id , 'item_location',$bs_location );

		// add_post_meta($post_id , 'item_tags',$bs_tags );
		wp_set_object_terms( $post_id, $categories, 'sales_categories' );

		add_post_meta($post_id , 'bs_product_type',$product_type );

		add_post_meta($post_id , 'total_earn','' );

		if ($image_url) {

				$file_name = $_FILES['bs_item_img']['name'];

		        $file_temp = $_FILES['bs_item_img']['tmp_name'];

		        $upload_dir = wp_upload_dir();

		        $image_data = file_get_contents( $file_temp );

		        $filename = basename( $file_name );

		        $filetype = wp_check_filetype($file_name);

		        $filename = time().'.'.$filetype['ext'];

		        if ( wp_mkdir_p( $upload_dir['path'] ) ) {

		          $file = $upload_dir['path'] . '/' . $filename;

		        }

		        else {

		          $file = $upload_dir['basedir'] . '/' . $filename;

		        }

		        file_put_contents( $file, $image_data );

		        $wp_filetype = wp_check_filetype( $filename, null );

		        $attachment = array(

		          'post_mime_type' => $wp_filetype['type'],

		          'post_title' => sanitize_file_name( $filename ),

		          'post_content' => '',

		          'post_status' => 'inherit'

		        );

		        $attach_id = wp_insert_attachment( $attachment, $file );

		        require_once( ABSPATH . 'wp-admin/includes/image.php' );

		        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		        wp_update_attachment_metadata( $attach_id, $attach_data );

		        set_post_thumbnail($post_id , $attach_id);

			}

	}else{ 

	echo $post_id->get_error_message();

	}



	wp_die(); 

}







// Delted Post Thumbail

add_action( 'wp_ajax_bs_delete_thumnail_callback', 'bs_delete_thumnail_callback' );

add_action( 'wp_ajax_nopriv_bs_delete_thumnail_callback', 'bs_delete_thumnail_callback' );

function bs_delete_thumnail_callback() {



	$current_post_id  = $_REQUEST['current_post'];

	if (delete_post_thumbnail($current_post_id)) {

		echo "succ";

	} else{

		echo "fail";

	}





	wp_die(); 

}









// Update Post Thumbnail





add_action( 'wp_ajax_bs_update_item_callback', 'bs_update_item_callback' );

add_action( 'wp_ajax_nopriv_bs_update_item_callback', 'bs_update_item_callback' );

function bs_update_item_callback() {

   	$bs_cat  = $_REQUEST['bs_choosen_cat'];
	$final_cats = explode(',', $bs_cat);
	$categories = array_map(
	    function($value) { return (int)$value; },
	    $final_cats
	);

	$bs_item_title  = $_REQUEST['bs_item_title'];

	// $bs_tags  = $_REQUEST['bs_tags'];

	$current_user  = $_REQUEST['current_user'];

	$bs_location  = $_REQUEST['bs_location'];

	$current_post_id  = $_REQUEST['current_post_id'];

	$image_url = $_FILES['bs_item_img'];


	$product_type  = $_REQUEST['product_type'];

	$description  = $_REQUEST['description'];

	// print_r($image_url);

	// die();



	$my_post = array(

		'ID'           => $current_post_id,

		'post_title'    => wp_strip_all_tags( $bs_item_title ),

		'post_status'   => 'publish',

		'post_author'   => $current_user,

		'post_type'     => 'buy_sell_items',

		'post_content'  => $description

	);

	

	$post_id = wp_update_post( $my_post );

	if(!is_wp_error($post_id)){

		echo 'Product updated Successfully';

		update_post_meta($post_id , 'item_location',$bs_location );

		// update_post_meta($post_id , 'item_tags',$bs_tags );

		wp_set_object_terms( $post_id, $categories, 'sales_categories' );

		update_post_meta($post_id , 'bs_product_type',$product_type );

		if ($image_url) {

				$file_name = $_FILES['bs_item_img']['name'];

		        $file_temp = $_FILES['bs_item_img']['tmp_name'];

		        $upload_dir = wp_upload_dir();

		        $image_data = file_get_contents( $file_temp );

		        $filename = basename( $file_name );

		        $filetype = wp_check_filetype($file_name);

		        $filename = time().'.'.$filetype['ext'];

		        if ( wp_mkdir_p( $upload_dir['path'] ) ) {

		          $file = $upload_dir['path'] . '/' . $filename;

		        }

		        else {

		          $file = $upload_dir['basedir'] . '/' . $filename;

		        }

		        file_put_contents( $file, $image_data );

		        $wp_filetype = wp_check_filetype( $filename, null );

		        $attachment = array(

		          'post_mime_type' => $wp_filetype['type'],

		          'post_title' => sanitize_file_name( $filename ),

		          'post_content' => '',

		          'post_status' => 'inherit'

		        );

		        $attach_id = wp_insert_attachment( $attachment, $file );

		        require_once( ABSPATH . 'wp-admin/includes/image.php' );

		        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		        wp_update_attachment_metadata( $attach_id, $attach_data );

		        set_post_thumbnail($post_id , $attach_id);

			}

	}else{ 

	echo $post_id->get_error_message();

	}



	wp_die(); 

}









add_action( 'wp_ajax_bs_delete_post', 'bs_delete_post_callback' );

add_action( 'wp_ajax_nopriv_bs_delete_post', 'bs_delete_post_callback' );

function bs_delete_post_callback() {



	$current_post_id  = $_REQUEST['current_post'];

	if (wp_trash_post($current_post_id)) {

		echo "succ";

	} else{

		echo "fail";

	}





	wp_die(); 

}









// Update Profile



add_action( 'wp_ajax_bs_update_profile_callback', 'bs_update_profile_callback' );

add_action( 'wp_ajax_nopriv_bs_update_profile_callback', 'bs_update_profile_callback' );

function bs_update_profile_callback() {

   

	$bs_username  = $_REQUEST['bs_username'];

	$bs_email  = $_REQUEST['bs_email'];

	// $bs_password  = $_REQUEST['bs_password'];

	$bs_dob  = $_REQUEST['bs_dob'];

	$bs_address  = $_REQUEST['bs_address'];

	$current_user_id  = $_REQUEST['current_user_id'];

	$image_url = $_FILES['bs_image'];

	

	$exists = email_exists( $bs_email );



	// if ( $exists ) {

	// 	echo "That E-mail is already Exist";

	// } else {

		$userdata = array(

			'ID' => $current_user_id,

			// 'user_pass'   => $bs_password,  

			'user_login'  => $bs_username, 

			'user_nicename' => $bs_username,   

			'user_email'   => $bs_email, 

			// 'role'       => 'subscriber',   

		);

		$user_id = wp_update_user( $userdata ) ;





		if ( ! is_wp_error( $user_id ) ) {

			echo "Updated Successfully";



        	

			update_user_meta($user_id,'birthday',$bs_dob);

			update_user_meta($user_id,'address',$bs_address);



			if ($image_url) {

				$file_name = $_FILES['bs_image']['name'];

		        $file_temp = $_FILES['bs_image']['tmp_name'];

		        $upload_dir = wp_upload_dir();

		        $image_data = file_get_contents( $file_temp );

		        $filename = basename( $file_name );

		        $filetype = wp_check_filetype($file_name);

		        $filename = time().'.'.$filetype['ext'];

		        if ( wp_mkdir_p( $upload_dir['path'] ) ) {

		          $file = $upload_dir['path'] . '/' . $filename;

		        }

		        else {

		          $file = $upload_dir['basedir'] . '/' . $filename;

		        }

		        file_put_contents( $file, $image_data );

		        $wp_filetype = wp_check_filetype( $filename, null );

		        $attachment = array(

		          'post_mime_type' => $wp_filetype['type'],

		          'post_title' => sanitize_file_name( $filename ),

		          'post_content' => '',

		          'post_status' => 'inherit'

		        );

		        $attach_id = wp_insert_attachment( $attachment, $file );

		        require_once( ABSPATH . 'wp-admin/includes/image.php' );

		        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		        wp_update_attachment_metadata( $attach_id, $attach_data );

		        update_user_meta( $user_id, 'image', $attach_id );

			}



		} else{

			echo $user_id->get_error_message();

		}

	// }



	wp_die(); 

}







// Removed User IMAGE





add_action( 'wp_ajax_bs_delete_user_imge', 'bs_delete_user_imge' );

add_action( 'wp_ajax_nopriv_bs_delete_user_imge', 'bs_delete_user_imge' );

function bs_delete_user_imge() {



	$current_post_id  = $_REQUEST['current_post'];

	if (delete_user_meta($current_post_id, 'image')) {

		echo "succ";

	} else{

		echo "fail";

	}





	wp_die(); 

}



// Contact Form
add_action( 'wp_ajax_bs_contact_form', 'bs_contact_form' );

add_action( 'wp_ajax_nopriv_bs_contact_form', 'bs_contact_form' );

function bs_contact_form() {



	$name  = $_REQUEST['bs_username'];
	$email  = $_REQUEST['bs_email'];
	$message  = $_REQUEST['bs_mes'];

	 $to = "m.mamoon.tariq@gmail.com";
        
         $subject = "Product";

		
		$message = $message; 
		$from = $name.'<>'.$email;


    
         
         $retval = mail ($to,$subject,$message);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }






	wp_die(); 

}