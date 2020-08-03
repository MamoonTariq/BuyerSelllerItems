<?php if (!is_user_logged_in() ) { 

    echo '<h6>You need to login first</h6>';

 } else { 



 	 $current_user = wp_get_current_user();

 	 $current_id_user = $current_user->ID ;

	$terms = get_terms( array(
	    'taxonomy' => 'sales_categories',
	    'hide_empty' => false,
	) );

?>	


<div class="add_product_page" id="add_product_item">


<form method="POST" enctype="multipart/form-data">

	<div>

		<label>Product Name</label><br>

		<input type="text" name="title" id="bs_item_title" placeholder="Product Name">

		<br>

		<label>Product Categories</label><br>

        <?php
			echo "<select data-placeholder='Choose a Category...' class='chosen-select' id='category_select' multiple tabindex='4'>";
			foreach ( $terms as $term ) {
			    echo "<option value='".$term->term_id."'>".$term->name."</option>";
			}
			echo "</select>";
		?>

		 <br>

		<!-- <label>Product Tags</label><br>

		<input type="text" name="tags" id="bs_tags" placeholder="Add meta tags">

		<br> -->

		<label>City</label><br>

		<input type="text" name="location" id="bs_location" placeholder="Add City">

		<br>

		<label>Product Type</label>
		<br>
		<input type="radio" name="product_type" value="selling" id="product_type">Selling
		<input type="radio" name="product_type" value="offered" id="product_type">Offers Required

		<br>

		<div class="desc">
			<label>Description</label>
			<textarea id="desc"></textarea>
		</div>

		<label>Upload Image</label>
		<input type="file" name="file" id="bs_item_img">

		<input type="hidden" name="" id="current_user" value="<?php echo $current_id_user; ?>">

		<input type="button" name="submit" value="Add Product" id="bs_add_item">

	</div>

	<span id="bs_error_message"></span>

</form>

</div>



<?php } ?>


<script type="text/javascript">
	jQuery(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
</script>



