<?php if ( !is_user_logged_in() ) { 

    echo '<h6>You Need to login</h6>';

 } else { 



     $current_user = wp_get_current_user();

     $current_id_user = $current_user->ID ;

     $image = get_user_meta($current_id_user, 'image',true);    

     if ($image) {

        $img = wp_get_attachment_image_src($image);

        $img_scr  = $img[0];

     }

     //echo "<pre>";

     $user  = get_user_by( 'id', $current_id_user );



     

     $birthday = get_user_meta($current_id_user,'birthday',true);

     $address = get_user_meta($current_id_user,'address',true);







    ?>

   

    <div class="buyer_seller_reg_form">

    	 <h3>Update Account</h3>

        <form method="POST" name="user_registeration" enctype="multipart/form-data">



            <label>Username*</label>  

            <input type="text" name="username" placeholder="Enter Your Username" 

            id="bs_username" value="<?php echo $user->user_login;?>" disabled/>

            <br/>



            <label>Email address*</label>

            <input type="text" name="useremail" id="bs_email" placeholder="Enter Your Email" 

            value="<?php echo $user->user_email;?>" />

             <br/>



            <!-- <label>Password*</label>

            <input type="password" name="password" id="bs_password" placeholder="Enter Your password" required /> 

            <br/> -->



            <label>Date of Birth*</label>  

            <input type="date" pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])" name="dob" placeholder="Enter Date of Birth" id="bs_dob" value="<?php echo $birthday; ?>" /> 

            <br>



            <label>Address*</label>  

            <input type="text" name="bs_address" placeholder="Enter Address" id="bs_address" value="<?php echo $address; ?>" /> 

            <br>
            <label>Profile Photo</label>
            <div class="remove_img">

        <?php

         if ($image) {

        $img = wp_get_attachment_image_src($image);

        $img_scr  = $img[0]; ?>

            <a id="img_del_user">X</a>

            <img src="<?php echo $img_scr ;?>" style="width: 150px;height: 150px;">

        <?php   

        }



        ?>

        </div>
        <label>Upload Profile Photo</label>
            <input type="file" name="file" id="bs_userprofile">





            <input type="hidden" name="" value="<?php echo $current_id_user; ?>" id="current_user_id">



            <input type="button" id="bs_update_profile" value="SignUp" />

        </form>

        <span id="bs_error_message"></span>

    </div>

<?php } ?>