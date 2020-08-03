<?php



function wporg_usermeta_form_field_birthday( $user )

{

    ?>

    <h3>Birthday</h3>

    <table class="form-table">

        <tr>

            <th>

                <label for="birthday">Birthday</label>

            </th>

            <td>

                <input type="date"

                       class="regular-text ltr"

                       id="birthday"

                       name="birthday"

                       value="<?= esc_attr( get_user_meta( $user->ID, 'birthday', true ) ) ?>"

                       title="Please use YYYY-MM-DD as the date format."

                       pattern="(19[0-9][0-9]|20[0-9][0-9])-(1[0-2]|0[1-9])-(3[01]|[21][0-9]|0[1-9])"

                       required>



                <input type="text"

                       class="regular-text ltr"

                       id="address"

                       name="address"

                       value="<?= esc_attr( get_user_meta( $user->ID, 'address', true ) ) ?>"

                       required>

                <p class="description">

                    Please enter your birthday date.

                </p>




                <input type="text"

                       class="regular-text ltr"

                       id="user_earn"

                       name="user_earn"

                       value="<?= esc_attr( get_user_meta( $user->ID, 'user_earn', true ) ) ?>"

                       >

                <p class="description">

                    Total Earning.

                </p>

            </td>

        </tr>

    </table>

    <?php

}

  

/**

 * The save action.

 *

 * @param $user_id int the ID of the current user.

 *

 * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.

 */

function wporg_usermeta_form_field_birthday_update( $user_id )

{

    // check that the current user have the capability to edit the $user_id

    if ( ! current_user_can( 'edit_user', $user_id ) ) {

        return false;

    }

  

    // create/update user meta for the $user_id

     update_user_meta(

        $user_id,

        'birthday',

        $_POST['birthday']

    );



      update_user_meta(

        $user_id,

        'address',

        $_POST['address']

    );




       update_user_meta(

        $user_id,

        'user_earn',

        $_POST['user_earn']

    );

}

  

// Add the field to user's own profile editing screen.

add_action(

    'show_user_profile',

    'wporg_usermeta_form_field_birthday'

);

  

// Add the field to user profile editing screen.

add_action(

    'edit_user_profile',

    'wporg_usermeta_form_field_birthday'

);

  

// Add the save action to user's own profile editing screen update.

add_action(

    'personal_options_update',

    'wporg_usermeta_form_field_birthday_update'

);

  

// Add the save action to user profile editing screen update.

add_action(

    'edit_user_profile_update',

    'wporg_usermeta_form_field_birthday_update'

);







// For custom Post type





  

abstract class WPOrg_Meta_Box

{

    public static function add()

    {

        $screens = ['buy_sell_items'];

        foreach ($screens as $screen) {

            add_meta_box(

                'wporg_box_id',          // Unique ID

                'Custom Meta Box Title', // Box title

                [self::class, 'html'],   // Content callback, must be of type callable

                $screen                  // Post type

            );

        }

    }

 

    public static function save($post_id)

    {

        if (array_key_exists('item_location', $_POST)) {

            update_post_meta($post_id,'item_location', $_POST['item_location']);

        }

        if (array_key_exists('item_tags', $_POST)) {

            update_post_meta($post_id,'item_tags', $_POST['item_tags']);

        }

         if (array_key_exists('total_earn', $_POST)) {

            update_post_meta($post_id,'total_earn', $_POST['total_earn']);

        }
        if (array_key_exists('bs_product_type', $_POST)) {

            update_post_meta($post_id,'bs_product_type', $_POST['bs_product_type']);

        }


    }

 

    public static function html($post)

    {

        $value = get_post_meta($post->ID, 'item_location', true);

        $item_tags = get_post_meta($post->ID, 'item_tags', true);

        $total_earn = get_post_meta($post->ID, 'total_earn', true);

        $bs_product_type = get_post_meta($post->ID, 'bs_product_type', true);

        ?>

        <label for="item_location">Location field</label>

        <input type="text" name="item_location" id="item_location" class="postbox" value="<?php echo $value; ?>">



        <label for="item_tags">Tags field</label>

        <input type="text" name="item_tags" id="item_tags" class="postbox" value="<?php echo $item_tags; ?>">


        <label for="total_earn">Total Earning this Product</label>

        <input type="text" name="total_earn" id="total_earn" class="postbox" value="<?php echo $total_earn; ?>">


        <label for="bs_product_type">Product Type</label>

        <input type="text" name="bs_product_type" id="bs_product_type" class="postbox" value="<?php echo $bs_product_type; ?>">

        <?php

    }

}

 

add_action('add_meta_boxes', ['WPOrg_Meta_Box', 'add']);

add_action('save_post', ['WPOrg_Meta_Box', 'save']);