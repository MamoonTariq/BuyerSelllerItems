<?php if ( is_user_logged_in() ) { 

    echo '<h6>You have already login</h6>';

 } else { ?>

   

    <div class="buyer_seller_reg_form">

    	 <div class="menus_bs">

          <h4>Create your account</h4>

          <!-- <h4><a href="">Login</a></h4>    -->

         </div>

        <form method="POST" name="user_registeration" enctype="multipart/form-data">



            <label>Username*</label>  

            <input type="text" name="username" placeholder="Enter Your Username" id="bs_username" required />

            <br/>



            <label>Email address*</label>

            <input type="text" name="useremail" id="bs_email" placeholder="Enter Your Email" required />

             <br/>



            <label>Password*</label>

            <input type="password" name="password" id="bs_password" placeholder="Enter Your password" required /> 

            <br/>



            <label>Date of Birth*</label>  

            <input type="date" pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])" name="dob" placeholder="Enter Date of Birth" id="bs_dob" required /> 

            <br>



            <label>Address*</label>  

            <input type="text" name="bs_address" placeholder="Enter Address" id="bs_address" required /> 

            <br>


            <label>Upload Profile Photo</label>
            <input type="file" name="file" id="bs_userprofile">



            <input type="button" id="bs_registeration" value="SignUp" />

        </form>

        <span id="bs_error_message"></span>

    </div>

<?php } ?>