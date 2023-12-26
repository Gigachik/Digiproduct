<?php
    function registration_form() { ?>
        <form id="custom-registration-form">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="tel" name="phone" required>

            <label for="about">About:</label>
            <textarea name="about" required></textarea>

            <input type="submit" value="Register">
        </form>
    <?php }

    add_shortcode('theme_form_registration', 'registration_form');


    function registration_form_ajax() {
        check_ajax_referer('custom-registration-nonce', 'nonce');

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $about = sanitize_textarea_field($_POST['about']);

        $user_id = wp_insert_user(array(
            'user_login' => $name,
            'user_email' => $email,
            'user_pass' => wp_generate_password(),
            'first_name' => $name,
            'description' => $about,
        ));

        if (!is_wp_error($user_id)) {
            $admin_email = get_option('admin_email');
            $subject = 'New user registration';
            $message = "New user registration. ID: $user_id, name: $name, registration_date: " . date('Y-m-d H:i:s');
            wp_mail($admin_email, $subject, $message);

            update_user_meta($user_id, 'phone', $phone);

            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('error' => $user_id->get_error_message()));
        }

        die();
    }

    add_action('wp_ajax_custom_registration', 'registration_form_ajax');
    add_action('wp_ajax_nopriv_custom_registration', 'registration_form_ajax');

    function add_phone_field( $user ) {
        ?>
            <h3>Extra profile information</h3>
            <table class="form-table">
                <tr>
                    <th>
                        <label for="phone">Phone Number</label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
                    </td>
                </tr>
            </table>
        <?php
    }
    add_action( 'show_user_profile', 'add_phone_field' );
    add_action( 'edit_user_profile', 'add_phone_field' );


    function phone_field_edit($user_id) {
        $phone = sanitize_text_field($_POST['phone']);
        update_user_meta($user_id, 'phone', $phone);
    }
    add_action('personal_options_update', 'phone_field_edit');
    add_action('edit_user_profile_update', 'phone_field_edit');

?>
