<?php 





if (isset($_POST['submit'])) {



	if (!is_user_logged_in() ) { 

		echo "You Need to Login First";

	//die();

	} else {

		global $wpdb;

		$success = $wpdb->insert("buy_sell_prod_records",

			array(

				"user_sender" => $_POST['sender_user'],

				"user_recevied" => $_POST['received_user'],

				"product_id" => $_POST['prod_id'],

				"prod_price" => $_POST['price'],

				"prod_des" => $_POST['description'],

				"status" => 'request_send'

			)

		);



		$id =  $wpdb->insert_id;

		if ($success) {

			$success = 'Your request has been submitted';


		}

	}

}







if (isset($_GET['user'])) {

	$use = $_GET['user'];

	 $use;



	if(username_exists($use)){

 		$current_user  = get_user_by( 'login', $use );



 		if (is_user_logged_in() ) { 

			$current_user_new = wp_get_current_user();

			$current_login_user = $current_user_new->user_login;

			if ($current_login_user == $use) {

				echo "This Prodcut is created by you!";

				die();

			}

		}









 	 //$current_user = wp_get_current_user();

 	 $current_id_user = $current_user->ID ;

 	   $birthday = get_user_meta($current_id_user,'birthday',true);

     $address = get_user_meta($current_id_user,'address',true);

 	 $image = get_user_meta($current_id_user, 'image',true);	

 	 if ($image) {

 	 	$img = wp_get_attachment_image_src($image);

 	 	$img_scr  = $img[0];

 	 } else {

 	 	$img_scr = get_site_url().'/wp-content/plugins/buyer-seller-items/noprofile.png';

 	 }



 	 if (isset($_GET['sear_title'])) {

 	 	$sear_title = $_GET['sear_title'];

 	 } else {

		$sear_title = '';

 	 }



 	 if (isset($_GET['searh_locat'])) {

 	 	$searh_locat = $_GET['searh_locat'];

 	 } else {

		$searh_locat = '';

 	 }





?>



		<?php 

		if (isset($_GET['user']) && isset($_GET['prod_id']) ) { 

			if (!empty($_GET['prod_id'])) {

				$sender_user_id = wp_get_current_user();

			?>

	<div class="buyer_seller_reg_form send_request" <?php if(isset($success)){ ?> style="display: none;" <?php } ?>>

		<form method="POST">

			<label>Send Offer Request With Price</label><br>

			<label>Price</label>

			<input type="number" name="price" required="">

			<label>Description</label>

			<input type="text" name="description" class="input-desc">

			<input type="hidden" name="prod_id" value="<?php echo $_GET['prod_id']; ?>" >

			<input type="hidden" name="received_user" value="<?php echo $current_id_user; ?>">

			<input type="hidden" name="sender_user" value="<?php echo $sender_user_id->ID ; ?>"> 

			<input type="submit" name="submit" class="send_request" value="send Request">

		</form>

	</div>

	<?php

	}

	 } ?>

<?php if(isset($success)){ 

	echo $success;
}?>

	<div class="user-container">
		<div class="user-meta-thumb">
			<img src="<?php echo $img_scr ;?>">
		</div>

		<div class="user-content-container">
			<div class="personal_informaion">
			<h2><?php echo $current_user->user_login ;?></h2>
			<div class="user-meta user-meta-one">
				<span><b>Email: </b><?php echo $current_user->user_email; ?></span>
				<span><b>Born: </b><?php echo $birthday; ?></span>
				<span><b>Address: </b><?php echo $address; ?></span>

			</div>
			
			</div>
			<?php
			global $wpdb;
			$query = "SELECT * FROM buy_sell_prod_records WHERE user_recevied = '$current_id_user' AND 
			status = 'complete' ";
			$all_records = $wpdb->get_results($query, ARRAY_A);
			if ($all_records) {  
				$total_price = 0;
				$total_prod = count($all_records);
				$total_rev = count($all_records);
				foreach ($all_records as $key => $value) {
					$total_price = $total_price + $value['prod_price'];
				} 
			} else {
				$total_price = 0;
				$total_prod = 0;
				$total_rev = 0;
			}

			?>	


			<div class="orders_infromaion">
				<div class="orders">
					<h5>Earning</h5>
					<span><b><?php echo $total_price; ?></b></span>
				</div>
				<div class="orders">
					<h5>Sold Items</h5>
					<span><b><?php echo $total_prod; ?></b></span>
				</div>
				<div class="orders">
					<h5>Reviews</h5>
					<span><b><?php echo $total_rev; ?></b></span>
				</div>
			</div>

		</div>
	</div>

	<div class="Filter_form">
		<form method="GET">

				<div class="search boxes">

					<input type="hidden" name="user" value="<?php echo wp_strip_all_tags($use); ?>">

					<input type="search" name="sear_title" placeholder="Title Search" value="<?php echo $sear_title;?>" >

					<input type="search" name="searh_locat" placeholder="City Search" value="<?php echo $searh_locat;?>" >

					<input type="submit" name="search" value="Search">

				</div>

			</form>
	</div>



<div class="wrapperddddd">

		<div class="contact_fomr add_product_page">
			<h4>Contact Form</h4>
			<form method="POST">
				<label>Your Name</label>
				<input type="text" name="name" id="name_bs">
				<label>Your Email</label>
				<input type="email" name="email" id="email_bs">
				<label>Message</label>
				<textarea name="message" id="message"></textarea>
				<input type="button" id="contact_form" value="submit">
				<span id="bs_error_message"></span>
			</form>
		</div>


		<div id="content" class="content-with-sidebar-left blog-page-list">
			<div class="sh-group blog-list blog-style-masonry masonry2">
			<?php

			$args = array(

			'post_type' => 'buy_sell_items',

			'author' => $current_id_user ,

			's' => $sear_title,

			'meta_query' => array(

		        array(

		           'key' => 'item_location',

		           'value' => $searh_locat,

		           'compare' => 'LIKE'

		        )

		     )

			);

			$the_query = new WP_Query( $args );
			 if ( $the_query->have_posts() ){
			 	while ( $the_query->have_posts() ){
			 		$the_query->the_post(); 
			 		$location = get_post_meta(get_the_ID(), 'item_location', true);
			 		$tags  = get_post_meta(get_the_ID() , 'item_tags', true);
			 		$imag = get_the_post_thumbnail_url();
			 		 $bs_product_type  = get_post_meta(get_the_ID() , 'bs_product_type', true);

			 		if (!$imag) {

			 			$imag = get_site_url().'/wp-content/plugins/buyer-seller-items/noprofile.png'; 
			 		}
			 		?>
			 		<article>
			 		<div class="post-container" id="sing_<?php echo get_the_ID();?>">
			 			<div class="post-meta-thumb">
			 				<img src="<?php echo $imag;?>" >
			 			</div>
			 			<div class="post-content-container">
			 			<div class="post-meta post-meta-one">
			 			<span><?php echo $tags;?></span>

			 			<span><?php echo $location;?></span></div>

			 			<h2><?php echo get_the_title();?></h2>
			 			<div class="post-meta post-meta-two">
			 				<span>
			 					<?php
			 					$auth_name = get_the_author_meta( 'login' );

			 					if ($bs_product_type == 'offered') {
                                    echo '<a href="'.get_site_url().'/user-details/?user='.$auth_name.'&prod_id='.get_the_ID().'">Offered</a>';
                                } else{

			 					echo '<a href="'.get_site_url().'/user-details/?user='.$auth_name.'&prod_id='.get_the_ID().'">Accept</a>';
                                }

			 					?>
		 					
			 				</span>
			 				<span>
			 					<a href="<?php echo get_site_url().'/user-details/?user='; ?><?php echo $auth_name; ?>">Contact</a>
			 				</span>

			 			</div>

						</div>

			 			</div>
			 			</article>
			 	<?php

			 	}

			   wp_reset_postdata(); 

			}else{

			  echo 'Sorry, you have no Products';

			}

			?>

			</div>
		</div>
	</div>



<?php
			global $wpdb;
			$query = "SELECT * FROM buy_sell_prod_records WHERE user_recevied = '$current_id_user' AND 
			status = 'complete' ";
			$all_records = $wpdb->get_results($query, ARRAY_A);
			if ($all_records) {  
				echo '<div class="all_reviews">';
				foreach ($all_records as $key => $value) { 
					$current_user_send  = get_user_by( 'ID', $value['user_sender'] );
					 $image = get_user_meta($value['user_sender'], 'image',true);	
				 	 if ($image) {
				 	 	$img = wp_get_attachment_image_src($image);
				 	 	$img_scr  = $img[0];
				 	 } else {
				 	 	$img_scr = get_site_url().'/wp-content/plugins/buyer-seller-items/noprofile.png';
				 	 }
					?>
					
					<div class="review">
						<img src="<?php echo $img_scr ;?>" alt="Avatar" style="width:90px">
						<span><?php echo $current_user_send->user_login;?></span>
						<p><?php echo $value['review'];?></p>
					</div>

				<?php
				} 

				echo '</div>';
			}

			?>	






	


<?php



} else {

	echo "User Not exist";

}



} else {

	echo "Some thing wents wrong";

}

?>







 	<style>
 		.buyer_seller_reg_form.send_request {
    margin-bottom: 33px !important;
}

			.review {
  border: 2px solid #ccc;
  background-color: #eee;
  border-radius: 5px;
  padding: 16px;
  margin: 16px 0
}

.review::after {
  content: "";
  clear: both;
  display: table;
}

.review img {
  float: left;
  margin-right: 20px;
  border-radius: 50%;
}

.review span {
  font-size: 20px;
  margin-right: 15px;
}

.all_reviews {
    float: left;
    width: 100%;
}
.Filter_form {
    margin-bottom: 44px;
}

.Filter_form input[type="search"] , .Filter_form input[type="submit"] { 
    width: 33%;
    flex-wrap: wrap;
}

		#content.content-with-sidebar-left {
    width: 73%;
    padding-left: 2%;
    float: right;
}

.blog-style-masonry {
    margin: 0 -15px;
position: relative;
   
}
   .post-meta-thumb {
    position: relative;
    display: block;
    overflow: hidden;
    max-height: 700px;
    overflow: hidden;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    -o-flex-direction: column;
    flex-direction: column;
    -webkit-flex-direction: column;
    -moz-justify-content: center;
    -ms-justify-content: center;
    -o-justify-content: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.post-meta-thumb img {
    width: 100%;
    min-width: 100%;
    height: 305px;
    transition: all .3s ease-in-out;
    margin-bottom: 0;
}
   .post-container {
    margin: 0 15px;
    position: relative;
}

.blog-style-masonry article {
    float: left;
    margin-bottom: 45px;
    width: 32%;
}
.masonry2 article .post-content-container {
    transition: .3s all ease-in-out;
    box-shadow: 0px 15px 45px -9px rgba(0,0,0,.2);
    overflow: hidden;
    position: relative;
}
.masonry2 article .post-content-container {
    padding-left: 13%;
    padding-right: 13%;
    padding-top: 32px;
    background-color: #fff;
    height: 260px;
}

.post-meta.post-meta-one {
    font-family: Montserrat;
}
.masonry2 article h2 {
    font-size: 28px;
    margin-top: 12px;
    margin-bottom: 14px;
    line-height: 100%!important;
    font-family: "Raleway";
    color: #8d8d8d;
    text-align: center;
    
}
.masonry2 .post-meta-two {
    margin-left: -18%;
    margin-right: 92px;
    padding: 19px 0 19px 18%;
    position: relative;
}
.post-meta-two {
    border-top: 1px solid #e9e9e9;
    padding-top: 15px;
}

.post-meta.post-meta-one span {
    color: #8d8d8d!important;
    margin-left: 10px;
}
.post-meta.post-meta-two {
    font-family: "Raleway";
    color: #8d8d8d;
    font-size: 14px;
    width: 100%;
    text-align: center;
}
.orders_infromaion{
     margin-top: 45px !important;
}

.post-meta.post-meta-two span {
    text-transform: uppercase;
    border-width: 0;
    box-shadow: none;
    border-radius: 5px;
    padding: 0 12px;
    line-height: 32px;
    background-color: #f0f0f0;
    transition: .3s all ease-in-out;
    display: inline-block;
    position: relative;
    padding: 0 10px;
    line-height: 30px;
    background-color: #f4f4f4;
    color: #8d8d8d;
    /* margin-right: 10px; */
    font-size: 13px!important;
    margin-bottom: 12px;
    border-radius: 100px;
    border: 3px solid #fff;
    box-shadow: 0px 1px 4px 1px rgba(0,0,0,.1);
    font-weight: 700;
}
.contact_fomr {
    width: 25%;
    float: left;
}

.all_orders {
    width: 100%;
    float: left;
}
.add_pro_ban {
    width: 100%;
    text-align: right;
    background: #8d8d8d;
    height: 68px;
    margin-top: 35px;
    margin-bottom: 55px;
    padding-right: 73px;
    padding-top: 1px;
    border-radius: 38px;
}

.add_pro_ban h6 {
    font-family: "Raleway";
    color: #8d8d8d;
    text-transform: uppercase;
    font-size: 15px;
}
@media screen and (max-width: 1024px) {
	.blog-style-masonry article{
		width: 50%;
	}
}


</style>
<script>
	jQuery(document).on('click','#contact_form',function(){

	jQuery('#bs_error_message').text('');

	let bs_name = jQuery("#name_bs").val();

	let bs_email = jQuery("#email_bs").val();

	let message = jQuery.trim(jQuery("#message").val());



	if (bs_name =='' || bs_email =='' || message =='' ) {

		jQuery('#bs_error_message').text('All above Fields are Required');

	} else {

		if(IsEmail(bs_email)==false){

          jQuery('#bs_error_message').text('email is not valid');

        } else {

        	jQuery('#bs_error_message').text('Processing');

        	var form_data = new FormData(); 

        	form_data.append('action', 'bs_contact_form');

        	form_data.append('bs_username', bs_name);

        	form_data.append('bs_email', bs_email);

        	form_data.append('bs_mes', message);

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


</script>