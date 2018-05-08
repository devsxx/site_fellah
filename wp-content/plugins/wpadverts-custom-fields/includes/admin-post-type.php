<?php

/**
 * Appends attributes to form scheme.
 * 
 * This function is executed by 'adverts_form_scheme' filter, it will apply
 * either default "add" scheme or a scheme applied to this Ad.
 * 
 * @see adverts_form_scheme filter.
 * 
 * @since 1.0.0
 * 
 * @param array $form       Adverts_Form structure
 * @param array $params     Typically array of shortocde params
 * @return array            Updated Adverts_Form structure
 */
function wpadverts_custom_fields_form_scheme_admin( $form, $params ) {
    
    $advert_id = null;
    $scheme_id = null;
    
    if( adverts_request( "_wpacf_form_scheme_id" ) ) {
        // scheme id sent in POST or GET request
        $scheme_id = adverts_request( "_wpacf_form_scheme_id" );
    } else if( defined( "DOING_AJAX" ) && DOING_AJAX && adverts_request( "_form_scheme_id" ) ) {
        $scheme_id = adverts_request( "_form_scheme_id" );
    } else if( adverts_request( "post" ) ) {
        $advert_id = adverts_request( "post" );
    } else if( adverts_request( "post_ID" ) ) {
        $advert_id = adverts_request( "post_ID" );
    } else {
        return $form;
    }
    
    $scheme = null;
    
    if( ! $scheme_id ) {
        $scheme_id = get_post_meta( $advert_id, "_wpacf_form_scheme_id", true );
    }
    
    $scheme_post = get_post( $scheme_id );
    
    if( $scheme_post && $scheme_post->post_type == "wpadverts-form" ) {
        $scheme = $scheme_post;
    } else {
        $scheme = wpadverts_custom_fields_get_form_scheme( "add" );
    }
    
    if( $scheme ) {
        $form["form_scheme"] = $scheme->post_name;
        $form["form_scheme_id"] = $scheme->ID;
    }

    return $form;
}

/**
 * Fires when custom post type advert is saved in wp-admin
 * 
 * This function is executed by save_post_advert filter.
 * 
 * @see save_post_advert filter
 * 
 * @since 1.0.0
 * @global string   $pagenow    String identfying currently viewed page
 * 
 * @param int       $post_id    Post ID
 * @param WP_Post   $post       Post Object
 * @return void
 */
function wpadverts_custom_fields_save_form_scheme_admin( $post_id, $post ) {
    global $pagenow;

    $nonce = '_wpacf_form_scheme_id_nonce';
    $nonce_action = '_wpacf_form_scheme_id_nonce_action';
    
    if ( ! in_array($pagenow, array("post.php", "post-new.php") ) ) {
        return;
    }
    
    if ( ! isset( $_POST[$nonce_action] ) || ! wp_verify_nonce( $_POST[$nonce_action], $nonce ) ) {
        return;
    }
        
    if ( $post->post_type != 'advert' ) {
        return;
    }
    
    if ( defined( "DOING_AJAX" ) && DOING_AJAX ) {
        return;
    }
    
    update_post_meta( $post_id, "_wpacf_form_scheme_id", adverts_request( "_wpacf_form_scheme_id" ) );
}

/**
 * Adds "Form Scheme" checkbox into Publish metabox.
 * 
 * This function is executed by post_submitbox_misc_actions filter.
 * 
 * @see post_submitbox_misc_actions action
 * 
 * @since 1.0.0
 * @global WP_Post $post
 * @global string $pagenow
 * @return void
 */
function wpadverts_custom_fields_form_scheme_meta_box() {
    global $post, $pagenow;
    
    // Do this for adverts only.
    if($post->post_type != 'advert') {
        return;
    }
    
    $form_id = get_post_meta( $post->ID, "_wpacf_form_scheme_id", true );
    
    $forms = new WP_Query(array(
        "post_type" => "wpadverts-form",
        "post_status" => "wpad-form-add",
        "order" => "ASC",
        "orderby" => "title",
        "posts_per_page" => -1
    ));
    
    if( empty( $forms->posts ) ) {
        return;
    }
    
    $list = array();
    $default = null;
    
    foreach( $forms->posts as $form ) {
        if( $form->menu_order > 0 ) {
            $default = $form;
        } else {
            $list[] = $form;
        }
    }
    
    wp_enqueue_style( "wpadverts-custom-fields-post-type" );
    wp_enqueue_script( "wpadverts-custom-fields-post-type" );
    
    ?>

    <div class="misc-pub-section wpacf-form-scheme-wrap">
        <label for="_wpacf_form_scheme_id"><?php _e( "Form Scheme", "wpadverts-custom-fields" ) ?>:</label>
        <span id="wpacf-form-scheme-id-display"></span>
        
        <a href="#_wpacf_form_scheme_id" class="edit-form-scheme-id hide-if-no-js" style="display: inline;">
            <span aria-hidden="true"><?php _e( "Edit" ) ?></span> 
            <span class="screen-reader-text"><?php _e( "Edit form scheme", "wpadverts-custom-fields" ) ?></span>
        </a>

        <div id="form-scheme-id-select" class="hide-if-js" style="display: none;">

            <?php wp_nonce_field( "_wpacf_form_scheme_id_nonce", "_wpacf_form_scheme_id_nonce_action", false ) ?>
            
            <select name="_wpacf_form_scheme_id" id="wpacf_form_scheme_id">
                <?php foreach( $forms->posts as $form ): ?>
                <option value="<?php echo esc_attr( $form->ID ) ?>" data-title="<?php echo esc_html( $form->post_title ) ?>" <?php selected( $form->ID == $form_id ) ?>>
                    <?php if( $form->menu_order > 0): ?>
                        <?php echo esc_html( sprintf( __( "%s (default)", "wpadverts-custom-fields" ), $default->post_title ) ) ?>
                    <?php else: ?>
                        <?php echo esc_html( $form->post_title ) ?>
                    <?php endif; ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <input type="hidden" name="_form_scheme" id="_form_scheme" class="wpadverts-plupload-multipart-default" value=""  />
            <input type="hidden" name="_form_scheme_id" id="_form_scheme_id" class="wpadverts-plupload-multipart-default" value="<?php echo esc_attr( $form_id ) ?>"  />

            <a href="#wpacf_form_scheme_id" class="save-form-scheme-id hide-if-no-js button"><?php _e( "OK" ) ?></a>
            <a href="#wpacf_form_scheme_id" class="cancel-form-scheme-id hide-if-no-js button-cancel"><?php _e( "Cancel" ) ?></a>
        </div>

    </div>

    <?php 
}

/**
 * Displays scheme selector when posting a new Ad from wp-admin panel
 * 
 * This function generates HTML code for modal box with scheme selector which
 * allows to select which of defined schemes you wish to use before filling the form.
 * 
 * Note that scheme selector will show only if there is two or more schemes to
 * choose from.
 * 
 * @since 1.0.0
 * @return void
 */
function wpadverts_custom_fields_post_new() {
    if( adverts_request( "post_type") != "advert" ) {
        return;
    }
    
    
}