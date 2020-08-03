<?php



 $page = get_page_by_path( 'add-product-items' , OBJECT );
 if (!isset($page)) {
	$my_post = array(
		'post_title'    => wp_strip_all_tags( 'Add Product Items' ),
		'post_content'  => '[buyer_seller_add_items]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'add-product-items',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $my_post );
 }



  $page2 = get_page_by_path( 'user-details' , OBJECT );
 if (!isset($page2)) {
	$my_posts = array(
		'post_title'    => wp_strip_all_tags( 'User Details' ),
		'post_content'  => '[buyer_seller_user_profile]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'user-details',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $my_posts );
 }


  $page3 = get_page_by_path( 'all-products' , OBJECT );
 if (!isset($page3)) {
	$my_posts3 = array(
		'post_title'    => wp_strip_all_tags( 'All Products' ),
		'post_content'  => '[seller_all_products]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'all-products',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $my_posts3 );
 }



$page4 = get_page_by_path( 'my-profile' , OBJECT );
 if (!isset($page4)) {
	$my_posts4 = array(
		'post_title'    => wp_strip_all_tags( 'My Profile' ),
		'post_content'  => '[buyer_seller_user_single]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'my-profile',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $my_posts4 );
 }

$page4 = get_page_by_path( 'edit-item' , OBJECT );
 if (!isset($page4)) {
	$my_posts4 = array(
		'post_title'    => wp_strip_all_tags( 'Edit Item' ),
		'post_content'  => '[buyer_seller_edit_item]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'edit-item',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $my_posts4 );
 }


$page6 = get_page_by_path( 'edit-profile' , OBJECT );
 if (!isset($page6)) {
	$page6 = array(
		'post_title'    => wp_strip_all_tags( 'Edit Profile' ),
		'post_content'  => '[buyer_seller_edit_profile]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'name'          => 'edit-profile',
		'post_type'     => 'page',
	);
	$post_id = wp_insert_post( $page6 );
 }



global $wpdb;
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
if (count($wpdb->get_var('SHOW TABLES LIKE "buy_sell_prod_records"')) == 0){
		$sql =  "CREATE TABLE `buy_sell_prod_records` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_sender` int(11) NOT NULL,
 `user_recevied` int(11) NOT NULL,
 `product_id` int(11) NOT NULL,
 `prod_price` int(11) NOT NULL,
 `prod_des` text DEFAULT NULL,
 `status` text DEFAULT NULL,
 `review` text DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4";
		dbDelta($sql);
	}