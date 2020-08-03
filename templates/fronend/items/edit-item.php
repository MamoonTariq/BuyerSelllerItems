<?php





if ($_GET['post_id']) {	

	$id =  $_GET['post_id'];



	// $post_tite = get_the_title( $post = 0 )

}

if (!is_user_logged_in() && !empty($id) ) { 

    echo '<h6>You need to login first</h6>';

 } else { 



 	 $current_user = wp_get_current_user();

 	 $current_id_user = $current_user->ID ;



 	 $post_tite = get_the_title($id);

 	$tags  = get_post_meta($id , 'item_tags', true);

	$imag = get_the_post_thumbnail_url($id);

	$location = get_post_meta($id, 'item_location', true);

	$bs_product_type = get_post_meta($id, 'bs_product_type', true);

	$sales_cats = wp_get_object_terms( $id, 'sales_categories' );

	$terms = get_terms( array(
	    'taxonomy' => 'sales_categories',
	    'hide_empty' => false,
	) );

	$added_cats = array();
	if(! empty($sales_cats)){
		foreach ($sales_cats as $value) {
			// print_r($value->term_id);
			$added_cats[] = $value->term_id;
		}
	}

	// print_r($added_cats);

	if ($bs_product_type == 'selling') { ?>
		<!-- <style>
			.desc{
				display: none;
			}
		</style>	 -->
<?php	}



	$content_post = get_post($id);
 $content = $content_post->post_content;
// $content = apply_filters('the_content', $content);
// $content = str_replace(']]>', ']]&gt;', $content);



 	?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<style type="text/css">
	.chosen-container-multi .chosen-choices{
		width: 100%;
		padding: 1.1em;
		transition: border-color 300ms;
		border: solid 1px #bbb;
		background: transparent;
		font-size: 100%;
		max-width: 100% !important;
		margin: 8px 0;
		border-radius: 4px;
	}

	.chosen-container.chosen-container-multi {
	    width: 100% !important;
	}
</style> -->
 	<div class="add_product_page" id="add_product_item">


<form method="POST" enctype="multipart/form-data">

	<div>

		<label>Product Name</label><br>

		<input type="text" name="title" id="bs_item_title" placeholder="Product Name" value="<?php echo $post_tite; ?>">

		<br>

		<label>Product Categories</label><br>

        <?php
			echo "<select data-placeholder='Choose a Category...' class='chosen-select' id='category_select' multiple tabindex='4'>";
			if(! empty($terms)){
				foreach ( $terms as $term ) {
					if(! empty($sales_cats)){
						// foreach ($sales_cats as $value) {
							// print_r($value->term_id);
							$sel = '';
							if (in_array($term->term_id, $added_cats)){
								$sel = 'selected';
							}else{
								$sel = '';
							}
						    echo "<option value='".$term->term_id."' ".$sel.">".$term->name."</option>";
						// }
					}else{
					    echo "<option value='".$term->term_id."'>".$term->name."</option>";
					}
				}
			}

				/*if(! empty($sales_cats)){
					foreach ($sales_cats as $value) {
						print_r($value);
						// echo "<option value='".$value->id."'>".$value->name."</option>";
					}
				}*/
			echo "</select>";
		?>

		<!-- <label>Product Tags</label><br>

		<input type="text" name="tags" id="bs_tags" placeholder="Add meta tags" value="<?php echo $tags; ?>"> -->

		<br>

		<label>City</label><br>

		<input type="text" name="location" id="bs_location" placeholder="Add City" value="<?php echo $location; ?>">

		<br>


		<label>Product Type</label>
		<br>
		<input type="radio" name="product_type" value="selling"  <?php if($bs_product_type=='selling'){ echo "checked=checked";}  ?> id="product_type">Selling
		<input type="radio" name="product_type" value="offered"  <?php if($bs_product_type=='offered'){ echo "checked=checked";}  ?> id="product_type">Offers Required

		<br>

		<div class="desc">
			<label>Description</label>
			<textarea id="desc"><?php echo  html_entity_decode($content); ?></textarea>
		</div>
			<br>
		<label>Product Image</label>
		<div class="img_del">
			
		<?php

		if (!empty($imag)) { ?>

			<a id="img_del">X</a>

			<img src="<?php echo $imag ;?>" style="width: 150px;height: 150px;">

		<?php	

		}



		?>

		

		</div>






		<label>Upload Product Image</label>
		<input type="file" name="file" id="bs_item_img">

		<input type="hidden" name="" id="current_user" value="<?php echo $current_id_user; ?>">

		<input type="hidden" name="" id="current_post" value="<?php echo $id; ?>">

		<input type="button" name="submit" value="Update Product" id="bs_update_item">

	</div>

	<span id="bs_error_message"></span>

</form>

</div>



<script>
	// jQuery(document).on('change',"input[name='product_type']",function(){
	// 	let product_type = jQuery("input[name='product_type']:checked").val();
	// 	if(product_type == 'offered'){
	// 		jQuery('.desc').css({"display": "block"});
	// 	} else if (product_type == 'selling'){
	// 	jQuery('.desc').css({"display": "none"});
	// 	}
	// });
</script>
<script type="text/javascript">
jQuery(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});




</script>

<?php } ?>