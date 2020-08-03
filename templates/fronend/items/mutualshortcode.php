
		<div id="content" class="content-with-sidebar-left blog-page-list">
			<div class="sh-group blog-list blog-style-masonry masonry2">
			<?php
			$prod_type = $atts['posts'];

			if ($prod_type == 'latest') {
				$args = array(

			'post_type' => 'buy_sell_items',
            'posts_per_page' => -1

				);
			} else {


			$args = array(

			'post_type' => 'buy_sell_items',
            'orderby'   => 'meta_value_num',
            'meta_key'  => 'total_earn',
            'order'     => 'DESC',
            'meta_query' => array(
                array(

                   'key' => 'bs_product_type',

                   'value' => $prod_type,
                )

             ),
            'posts_per_page' => -1

			);

			}

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
			 		<div class="post-container" id="sing_<?php echo get_the_ID();?>">
			 			<div class="post-meta-thumb">
			 			<img src="<?php echo $imag;?>" ></div>

			 			<div class="post-content-container">
			 			<!-- <div class="post-meta post-meta-one">
			 			<span><?php echo $tags;?></span>

			 			<span><?php echo $location;?></span></div> -->

			 			


			 			

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

                        <h2><?php echo get_the_title();?></h2>

                        <?php
                        $article_data = substr(get_the_content(), 0, 45);
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

			?>

		</div>
		</div>



		<style>
			  
	#content.content-with-sidebar-left {
    width: 100%;
    padding-left: 2%;
   /* float: right;*/
}

.blog-style-masonry {
    margin: 0 -15px;
position: relative;
    height: auto;
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
    height: 233px;
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
    width: 33%;
    margin-left: 2px;
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
    /*text-align: center;*/
    
}
.masonry2 .post-meta-two {
    /*margin-left: -18%;
    margin-right: 92px;
    padding: 19px 0 19px 18%;*/
    position: relative;
}

.content-with-sidebar-left.blog-page-list .post-content-container {
    height: 207px !important;
}

.post-meta.post-meta-one span {
    color: #8d8d8d!important;
    margin-left: 10px;
}
.post-meta.post-meta-two {
    font-family: "Raleway";
    color: #8d8d8d;
    font-size: 14px;
    
    justify-content: space-between;
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
		</style>