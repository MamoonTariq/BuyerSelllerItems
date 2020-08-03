<?php if ( is_user_logged_in() ) { 

    echo '<div class="login_page_messg"><h6><a href="'.wp_logout_url().'">Logout</a></h6></div>';

 } else { ?>

 	<div class="buyer_seller_reg_form" id="login_form_page">

		<form>
					<span class="login100-form-title">
						Sign In
					</span>
			<div>

				<!-- <label>Email*</label> -->

				<input type="email" name="email" id="bs_email" placeholder="email">


				<!-- <label>Password*</label>
 -->
				<input type="password" name="password" id="bs_password" placeholder="password">
				
				<input type="button" name="submit" value="login" id="bs_login">

			</div>

			<span id="bs_error_message"></span>

		</form>

	</div>

<?php } ?>