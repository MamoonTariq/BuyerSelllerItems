<?php

/*

  Plugin Name:   Buyer Seller Items

  Plugin URI:    https://www.google.com

  Description:   Registration, Login, Buyyer and Seller Full Functionality.

  Version:       1.1.1

  Author:        M Mamoon Tariq

  Author URI:    http://github.com/MamoonTariq

*/



if ( ! defined( 'ABSPATH' ) ) {

	die( 'Please Contact Wiht Plugin Developer.' );

}



class BuySellItems {



	function __construct() {



		add_action( 'init', array( $this , 'custom_post_type' ) );



		add_action( 'wp_enqueue_scripts', array( $this , 'enqueue_assets' ) );



		add_action( 'admin_menu' ,  array( $this , 'buyer_seller_admin_page' ) );



	}





	function activate() {

		

		$this->custom_post_type();



		flush_rewrite_rules();



		require_once plugin_dir_path( __FILE__ ) . 'includes/add_pages_admin.php';



	}





	function deactivate() {

		

		flush_rewrite_rules();



	}





	function custom_post_type() {



		require_once plugin_dir_path( __FILE__ ) . 'includes/create_buy_sell_posttype.php';



	}



	// Include Assests

	function enqueue_assets() {



		wp_enqueue_style( 'adminCss' , plugins_url('/assets/css/style.css' , __FILE__ ) , array(), '1.0.0', false );
		
		wp_enqueue_style( 'ChosenCss' , plugins_url('/assets/css/chosen.min.css' , __FILE__ ) , array(), '1.0.0', false );



		wp_enqueue_script( 'BuyerSellerJs' , plugins_url('/assets/js/by_scripts.js' , __FILE__ ) , array('jquery'), '1.0.0', true);
		
		// wp_enqueue_script( 'JQueryJs' , plugins_url('/assets/js/jquery.min.js' , __FILE__ ) , array('jquery'), '1.0.0', true);
		
		wp_enqueue_script( 'ChosenJs' , plugins_url('/assets/js/chosen.jquery.min.js' , __FILE__ ) , array('jquery'), '1.0.0', false);



		wp_localize_script( 'BuyerSellerJs', 'bs_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );



	}



	// Add Options Page in Admin

	function buyer_seller_admin_page() {



		add_menu_page('Buyer & Seller Settings' , 'Buyer Seller' , 'manage_options' , 'buy-sell-options' , array( $this , 'buyer_seller_admin_index') , 'dashicons-store', 110);

		

	}





	function buyer_seller_admin_index() {



		require_once plugin_dir_path( __FILE__ ) . 'templates/admin/buyer_seller_admin_page.php';



	}

}





if ( class_exists( 'BuySellItems' ) ) {



	$BuySellItems = new BuySellItems();



}









// activation

register_activation_hook( __FILE__ , array( $BuySellItems , 'activate' ));



// Deactivation 

register_deactivation_hook( __FILE__ , array( $BuySellItems , 'deactivate' ));



// Frontend Forms

require_once plugin_dir_path( __FILE__ ) . 'templates/fronend/all_forms.php';



// Call Backs

require_once plugin_dir_path( __FILE__ ) . 'templates/callbacks/callbacks.php';



require_once plugin_dir_path( __FILE__ ) . 'templates/user_custom_fields.php';


function sales_taxonomy() {
    register_taxonomy(
        'sales_categories',
        'buy_sell_items',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Sales Categories', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'sales_categorie',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'sales_taxonomy');
