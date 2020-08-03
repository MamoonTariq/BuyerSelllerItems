<?php



// ---------------------------Registration Form--------------------



function buyer_seller_registration_form_function(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/user_registration_form.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_registration_form', 'buyer_seller_registration_form_function');











// ---------------------------Login Form --------------------



function buyer_seller_login_form_function(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/user_login_form.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_login_form', 'buyer_seller_login_form_function');









function buyer_seller_add_products_form(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'items/add_items.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_add_items', 'buyer_seller_add_products_form');





function buyer_seller_user_sinle_page(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/user_single_page.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_user_single', 'buyer_seller_user_sinle_page');









function buyer_seller_all_products(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'items/all_products.php';



	return ob_get_clean();

}



add_shortcode('seller_all_products', 'buyer_seller_all_products');







function buyer_seller_edit_item_func(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'items/edit-item.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_edit_item', 'buyer_seller_edit_item_func');













function buyer_seller_edit_profile_fun(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/edit-profile.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_edit_profile', 'buyer_seller_edit_profile_fun');







function buyer_seller_user_profile_fun(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/user_page.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_user_profile', 'buyer_seller_user_profile_fun');




// All Users Page.



function buyer_seller_all_user_profiles_func(){

	ob_start();



	require_once plugin_dir_path( __FILE__ ) . 'users/all_user_profiles.php';



	return ob_get_clean();

}



add_shortcode('buyer_seller_all_user_profiles', 'buyer_seller_all_user_profiles_func');



add_shortcode('widget_buyer_seller_items', 'widget_shortcode');
function widget_shortcode($atts){

$per_page = $atts['posts'];
 echo '<div class="side_widget_buy">';
			$args = array(

			'post_type' => 'buy_sell_items',
            'orderby'   => 'meta_value_num',
            'meta_key'  => 'total_earn',
            'order'     => 'DESC',
            'posts_per_page' => $per_page

			);

			$the_query = new WP_Query( $args );

			 if ( $the_query->have_posts() ){

			 	while ( $the_query->have_posts() ){

			 		$the_query->the_post(); 

			 		$location = get_post_meta(get_the_ID(), 'item_location', true);

			 		$tags  = get_post_meta(get_the_ID() , 'item_tags', true);

                    $bs_product_type  = get_post_meta(get_the_ID() , 'bs_product_type', true);

			 		$imag = get_the_post_thumbnail_url();

			 		if (!$imag) {

			 			$imag = get_site_url().'/wp-content/plugins/buyer-seller-items/noprofile.png'; 

			 		}



			 		?>
			 		<article>
			 		<div class="sidebar_widget" id="sing_<?php echo get_the_ID();?>">
			 			<div class="post-meta-thumb widget">
			 			<img src="<?php echo $imag;?>" ></div>

			 			<div class="post-content-container widget">
			 			<!-- <div class="post-meta post-meta-one">
			 			<span><?php echo $tags;?></span>

			 			<span><?php echo $location;?></span></div> -->

			 			


			 			

			 			<div class="post-meta post-meta-two widget">

			 				

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

                        <h2><?php echo get_the_title();?></h2>

                        <?php
                        $article_data = substr(get_the_content(), 0, 75);
                        echo '<p>'.$article_data.'</p>';
                        ?>

						</div>

			 			</div>
			 			</article>
			 	<?php

			 	}

			   wp_reset_postdata(); 

			}else{

			  echo 'Sorry, you have no Products';

			}

			echo "</div>";
}






add_shortcode('widget_buyer_seller_items_latest', 'widget_shortcode_latest');
function widget_shortcode_latest($atts){

$per_page = $atts['posts'];
// echo $per_page;
 echo '<div class="side_widget_buy">';
			$args = array(

			'post_type' => 'buy_sell_items',
            'posts_per_page' => $per_page

			);

			$the_query = new WP_Query( $args );

			 if ( $the_query->have_posts() ){

			 	while ( $the_query->have_posts() ){

			 		$the_query->the_post(); 

			 		$location = get_post_meta(get_the_ID(), 'item_location', true);

			 		$tags  = get_post_meta(get_the_ID() , 'item_tags', true);

                    $bs_product_type  = get_post_meta(get_the_ID() , 'bs_product_type', true);

			 		$imag = get_the_post_thumbnail_url();

			 		if (!$imag) {

			 			$imag = get_site_url().'/wp-content/plugins/buyer-seller-items/noprofile.png'; 

			 		}



			 		?>
			 		<article>
			 		<div class="sidebar_widget" id="sing_<?php echo get_the_ID();?>">
			 			<div class="post-meta-thumb widget">
			 			<img src="<?php echo $imag;?>" ></div>

			 			<div class="post-content-container widget">
			 			<!-- <div class="post-meta post-meta-one">
			 			<span><?php echo $tags;?></span>

			 			<span><?php echo $location;?></span></div> -->

			 			


			 			

			 			<div class="post-meta post-meta-two widget">

			 				

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

                        <h2><?php echo get_the_title();?></h2>

                        <?php
                        $article_data = substr(get_the_content(), 0, 75);
                        echo '<p>'.$article_data.'</p>';
                        ?>

						</div>

			 			</div>
			 			</article>
			 	<?php

			 	}

			   wp_reset_postdata(); 

			}else{

			  echo 'Sorry, you have no Products';

			}

			echo "</div>";
}






function buyer_seller_prod_items($atts){

	ob_start();



	// require_once plugin_dir_path( __FILE__ ) . 'items/mutualshortcode.php';


	define('__ROOT__', plugin_dir_path(__FILE__)); 
	include __ROOT__.'items/mutualshortcode.php'; 

	return ob_get_clean();

}



add_shortcode('buyer_seller', 'buyer_seller_prod_items');