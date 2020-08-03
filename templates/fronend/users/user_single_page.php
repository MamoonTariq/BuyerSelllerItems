<?php if (!is_user_logged_in() ) { 

    echo '<h6>You need to login first</h6>';

 } else { 



 	 $current_user = wp_get_current_user();

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







 	 if (isset($_POST['accept'])) {

 	 	global $wpdb;

		$wpdb->update(

		'buy_sell_prod_records',

		array(

			'status' => 'pending'

		),

			array( 'id' => $_POST['current_id'] )

		);

 	 }





 	  if (isset($_POST['review'])) {

 	 	global $wpdb;

		$wpdb->update(

		'buy_sell_prod_records',

		array(

			'status' => 'complete',

			'review' => $_POST['review_text']

		),

			array( 'id' => $_POST['current_id'] )

		);

		$total_earn = get_post_meta($_POST['post_id'] , 'total_earn', true);
		if ($total_earn) {
			$total_earn  = $total_earn + $_POST['price_pd'];
			update_post_meta($_POST['post_id'], 'total_earn',$total_earn);
		} else {
			update_post_meta($_POST['post_id'], 'total_earn',$_POST['price_pd']);
		}


		$total_earn = get_user_meta($_POST['seller_name_id'] , 'user_earn', true);
		if ($total_earn) {
			$total_earn  = $total_earn + $_POST['price_pd'];
			update_user_meta($_POST['seller_name_id'], 'user_earn',$total_earn);
		} else {
			update_user_meta($_POST['seller_name_id'], 'user_earn',$_POST['price_pd']);
		}

		

 	 }





?>

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
		<div class="user-meta user-meta-two">
			<span>
			<a href="<?php echo get_site_url();?>/edit-profile">Edit Profile</a>
			</span>
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



	<div class="add_pro_ban">
		<h6><a href="<?php echo get_site_url().'/add-product-items/'?>">Add New Products</a></h6>
	</div>


	<div class="wrapperddddd">

		<div class="contact_fomr add_product_page">
			<h4>Contact Form</h4>
			<form accept="" method="POST">
				<label>Your Name</label>
				<input type="text" name="">
				<label>Your Email</label>
				<input type="email" name="">
				<label>Message</label>
				<textarea></textarea>
				<input type="submit" name="contact_form" value="submit">
			</form>
		</div>


		<div id="content" class="content-with-sidebar-left blog-page-list">
			<div class="sh-group blog-list blog-style-masonry masonry2">
			<?php

			$args = array(

			'post_type' => 'buy_sell_items',
			'author' => $current_id_user 

			);

			$the_query = new WP_Query( $args );
			 if ( $the_query->have_posts() ){
			 	while ( $the_query->have_posts() ){
			 		$the_query->the_post(); 
			 		$location = get_post_meta(get_the_ID(), 'item_location', true);
			 		$tags  = get_post_meta(get_the_ID() , 'item_tags', true);
			 		$imag = get_the_post_thumbnail_url();
			 		$bs_product_type  = get_post_meta(get_the_ID() , 'bs_product_type', true);

					$sales_cats = wp_get_object_terms( get_the_ID(), 'sales_categories' );

if(isset($_SERVER['REMOTE_ADDR']) == '103.255.5.39'){
	// print_r($sales_cats[0]->name); die();
}
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
			 			<span class="product_cats"><?php 
			 				if(! empty($sales_cats)){
			 					foreach ($sales_cats as $value) {
			 						echo $value->name. ', ';
			 					}
			 				}
			 			?></span>

			 			<span class="product_location"><?php echo $location;?></span>
			 			<span class="product_type"><?php echo $bs_product_type ;?></span>
			 		</div>

			 			<h2><?php echo get_the_title();?></h2>
			 			<div class="post-meta post-meta-two">
			 				<span>
			 					<a href="<?php echo get_site_url().'/edit-item/?post_id='.get_the_ID(); ?>">Edit</a>
		 					
			 				</span>
			 				<span>
			 					<a class="delted_curent_post" id="<?php echo get_the_ID();?>">Delete</a>
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


<!-- Recived Order -->
<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_recevied = '$current_id_user' AND 
			status = 'request_send' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
	 		<h4>Received Orders</h4>
			<table>
			  <tr>
			    <th>Customer Name</th>
			    <th>Product Name</th>
			    <th>Price</th>
			    <th>Description</th>
			    <th>Status</th>
			    <th>Action</th>
			  </tr>
			<?php 
			foreach ($all_records as $key => $value) {
				$current_user_send  = get_user_by( 'ID', $value['user_sender'] );
				echo '<tr>
				    <td>'.$current_user_send->user_login.'</td>
				    <td>'.get_the_title($value['product_id']).'</td>
				    <td>'.$value['prod_price'].'</td>
				    <td>'.$value['prod_des'].'</td>
				    <td>Recived</td>
				    <td>'; ?>
				    <form method="POST">
				    	<input type="hidden" name="current_id" value="<?php echo $value['id'];?>">
				    	<input type="submit" name="accept" value="accept">
				    </form>
				    <?php
				    echo '</td>
			  	</tr>';
			} ?>
			</table>
		</div>
	<?php }	?>


	<!-- Create order -->
	<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_sender = '$current_id_user' AND 
			status = 'request_send' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
	 		<h4>Created Orders</h4>
			<table>
			  <tr>
			    <th>Seller Name</th>
			    <th>Product Name</th>
			    <th>Price</th>
			    <th>Description</th>
			    <th>Status</th>
			    
			  </tr>
			<?php 
			foreach ($all_records as $key => $value) {
				$current_user_send  = get_user_by( 'ID', $value['user_recevied'] );
				echo '<tr>
				    <td>'.$current_user_send->user_login.'</td>
				    <td>'.get_the_title($value['product_id']).'</td>
				    <td>'.$value['prod_price'].'</td>
				    <td>'.$value['prod_des'].'</td>
				    <td>Pending</td>
			  	</tr>';
			} ?>
			</table>
		</div>
	<?php }	?>


	<!-- Product Pending for Review  -->

<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_recevied = '$current_id_user' AND 
			status = 'pending' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
	 		<h4>Pending for Reviews</h4>
			<table>
			  <tr>
			    <th>Customer Name</th>
			    <th>Product Name</th>
			    <th>Price</th>
			    <th>Description</th>
			    <th>Status</th>
			    
			  </tr>
			<?php 
			foreach ($all_records as $key => $value) {
				$current_user_send  = get_user_by( 'ID', $value['user_sender'] );
				echo '<tr>
				    <td>'.$current_user_send->user_login.'</td>
				    <td>'.get_the_title($value['product_id']).'</td>
				    <td>'.$value['prod_price'].'</td>
				    <td>'.$value['prod_des'].'</td>
				    <td>Pending For Review</td>'; ?>
				   
				    <?php
				    echo '</tr>';
			} ?>
			</table>
		</div>
	<?php }	?>


<!-- Sending Reviews -->

<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_sender = '$current_id_user' AND 
			status = 'pending' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
	 		<h4>Your Order is Accepted.. Give review</h4>
			<table>
			  <tr>
			    <th>Seller Name</th>
			    <th>Product Name</th>
			    <th>Price</th>
			    <th>Description</th>
			    <th>Status</th>
			    <th>Action</th>
			  </tr>
			<?php 
			foreach ($all_records as $key => $value) {
				$current_user_send  = get_user_by( 'ID', $value['user_recevied'] );
				echo '<tr>
				    <td>'.$current_user_send->user_login.'</td>
				    <td>'.get_the_title($value['product_id']).'</td>
				    <td>'.$value['prod_price'].'</td>
				    <td>'.$value['prod_des'].'</td>
				    <td>Send Review</td>
				    <td>'; ?>
				    <form method="POST">
				    	<input type="hidden" name="seller_name_id" value="<?php echo $current_user_send->ID;?>">
				    	<input type="hidden" name="post_id" value="<?php echo $value['product_id'];?>">
				    	<input type="hidden" name="price_pd" value="<?php echo $value['prod_price'];?>">
				    	<input type="hidden" name="current_id" value="<?php echo $value['id'];?>">
				    	<input type="text" name="review_text" required="">
				    	<input type="submit" name="review" value="send Review">
			    	</form>
				    <?php
				    echo '</td>
			  	</tr>';
			} ?>
			</table>
		</div>
	<?php }	?>


<!-- Completed Sold Out Orders -->

	<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_recevied = '$current_id_user' AND 
			status = 'complete' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
 		<h4>Sold Out Products</h4>
		<table>
		  <tr>
		    <th>Customer Name</th>
		    <th>Product Name</th>
		    <th>Price</th>
		    <th>Description</th>
		    <th>Status</th>
		    <th>Review</th>
		  </tr>
		<?php 
		foreach ($all_records as $key => $value) {
			$current_user_send  = get_user_by( 'ID', $value['user_sender'] );
			echo '<tr>
			    <td>'.$current_user_send->user_login.'</td>
			    <td>'.get_the_title($value['product_id']).'</td>
			    <td>'.$value['prod_price'].'</td>
			    <td>'.$value['prod_des'].'</td>
			    <td>Complete</td>
			    <td>'.$value['review'].'</td>
		  	</tr>';
		} ?>
		</table>
		</div>
	<?php
	} 
	?>


	<!-- Buying Products -->
	<?php
	global $wpdb;
	$query = "SELECT * FROM buy_sell_prod_records WHERE user_sender = '$current_id_user' AND 
			status = 'complete' ";
	$all_records = $wpdb->get_results($query, ARRAY_A);
	if ($all_records) { ?>
		<div class="all_orders" style="overflow-x:auto;">
 		<h4> Buy Products</h4>
		<table>
		  <tr>
		    <th>Seller Name</th>
		    <th>Product Name</th>
		    <th>Price</th>
		    <th>Description</th>
		    <th>Status</th>
		    <th>Review</th>
		  </tr>
		<?php 
		foreach ($all_records as $key => $value) {
			$current_user_send  = get_user_by( 'ID', $value['user_recevied'] );
			echo '<tr>
			    <td>'.$current_user_send->user_login.'</td>
			    <td>'.get_the_title($value['product_id']).'</td>
			    <td>'.$value['prod_price'].'</td>
			    <td>'.$value['prod_des'].'</td>
			    <td>Complete</td>
			    <td>'.$value['review'].'</td>
		  	</tr>';
		} ?>
		</table>
		</div>
	<?php
	} 
	?>


<?php } ?>




<style>
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
    color: black;
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