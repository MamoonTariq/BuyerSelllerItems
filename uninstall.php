<?php


/**

* Trigger When Plugin unistall
*
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' )) {
	die;
}

// Clear Data From Database.

// $buy_sell_items = get_posts( array( 'post_type' => 'buy_sell_items' , 'numberposts' => -1) );

// foreach ($buy_sell_items as $buy_sell_item) {
// 	wp_delete_posts( $buy_sell_item->ID, true );
// }

// https://makitweb.com/how-to-send-ajax-request-from-plugin-wordpress/