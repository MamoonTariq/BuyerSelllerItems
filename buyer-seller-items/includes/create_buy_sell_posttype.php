<?php



	$labels = array(

		'name'                => 'Buy & Sell Items',

		'singular_name'       => 'Buy & Sell Item',

		'menu_name'           => 'Buy & Sell Items',

		'parent_item_colon'   => 'Buy & Sell Items',

		'all_items'           => 'All Items',

		'view_item'           => 'View Items',

		'add_new_item'        => 'Add Items',

		'add_new'             => 'Add New',

		'edit_item'           => 'Edit Items',

		'update_item'         => 'Update Items',

		'search_items'        => 'Search Items',

		'not_found'           => 'Not Found',

		'not_found_in_trash'  => 'Not found in Trash',

	);







	$args = array(

		'label'               => 'Buy & Sell Items',

		'description'         => 'Buy & Sell Items Description',

		'labels'              => $labels,



		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

		 

		//'taxonomies'          => array( 'genres' ),



		'hierarchical'        => false,

		'public'              => true,

		'show_ui'             => true,

		'show_in_menu'        => true,

		'show_in_nav_menus'   => true,

		'show_in_admin_bar'   => true,

		'menu_position'       => 5,

		'can_export'          => true,

		'has_archive'         => true,

		'exclude_from_search' => false,

		'publicly_queryable'  => true,

		'capability_type'     => 'post',

		'show_in_rest' => true,



	);







	register_post_type( 'buy_sell_items', $args );