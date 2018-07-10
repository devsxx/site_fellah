<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Renders Custom Fields config form.
 * 
 * The page is rendered in wp-admin / Classifieds / Options / Custom Fields panel
 * 
 * @since 1.0
 * @return void
 */
function wpadverts_custom_fields_page_options() {
    
    include_once WP_PLUGIN_DIR . '/wpadverts-custom-fields/includes/functions.php';
    
    if( adverts_request( "add" ) == "new" ) {
        _wpadverts_custom_fields_page_add();
    } else if( adverts_request( "edit" ) ) {
        _wpadverts_custom_fields_page_edit();
    } else if( adverts_request( "delete") ) {
        _wpadverts_custom_fields_page_delete();
    } else {
        _wpadverts_custom_fields_page_list();
    }
    
    
}

function _wpadverts_custom_fields_page_add() {
    
    adverts_form_add_validator("wpadverts_custom_fields_name_exists", array(
        "callback" => "wpadverts_custom_fields_name_exists",
        "label" => "",
        "params" => array(),
        "default_error" => __( "Some other form is already using this name.", "wpadverts-custom-fields" ),
        "validate_empty" => false
    ));
    
    $form_scheme = array(
        "name" => "custom_fields_add",
        "action" => "",
        "field" => array(
            array(
                "name" => "form_type",
                "type" => "adverts_field_select",
                "order" => 5,
                "label" => __( "Form Type", "wpadverts-custom-fields" ),
                "is_required" => true,
                "max_choices" => 1,
                "empty_option" => true,
                "empty_option_text" => " ",
                "options" => array(
                    array( "value"=> "wpad-form-add", "text"=> __( "Create Advert ([adverts_add])", "wpadverts-custom-fields" ) ),
                    array( "value"=> "wpad-form-search", "text"=> __( "Search Ads ([adverts_list])", "wpadverts-custom-fields" ) ),
                    array( "value"=> "wpad-form-contact", "text"=> __( "Contact", "wpadverts-custom-fields" ) ),
                ),
                "validator" => array(
                    array( "name" => "is_required" ),
                )
            ),
            array(
                "name" => "form_title",
                "type" => "adverts_field_text",
                "order" => 5,
                "label" => __( "Form Title", "wpadverts-custom-fields" ),
                "is_required" => true,
                "validator" => array(
                    array( "name" => "is_required" )
                )
            ),
            array(
                "name" => "form_name",
                "type" => "adverts_field_text",
                "order" => 10,
                "label" => __( "Form Name (a-z, 0-9, - only)", "wpadverts-custom-fields" ),
                "is_required" => true,
                "validator" => array(
                    array( "name" => "is_required" ),
                    array( "name" => "wpadverts_custom_fields_name_exists" )
                )
            ),
            array(
                "name" => "is_default",
                "type" => "adverts_field_checkbox",
                "order" => 15,
                "label" => __( "Default", "wpadverts-custom-fields" ),
                "is_required" => false,
                "validator" => array( ),
                "max_choices" => 1,
                "options" => array(
                    array( "value"=> "1", "text"=> __( "Automatically apply this scheme to form.", "wpadverts-fee-per-category" ) ),
                )
            ),
        )
    );
    
    wp_enqueue_style( 'adverts-admin' );
    wp_enqueue_script( 'wpadverts-custom-fields-form-add' );
    
    $flash = Adverts_Flash::instance();
    $soft_redirect = false;
    $error = array();
    $options = array();
    
    $form = new Adverts_Form( $form_scheme );
    $form->bind( $options );

    if(isset($_POST) && !empty($_POST)) {
        $form->bind( $_POST );
        $valid = $form->validate();

        if($valid) {
            
            $type = $form->get_value("form_type");
            $name = $form->get_value("form_name");
            
            $id = wp_insert_post( array( 
                'post_name' => $form->get_value( "form_name" ),
                'post_title' => $form->get_value( "form_title" ),
                'post_content' => '',
                'post_status' => $form->get_value( "form_type" ),
                'menu_order' => absint( $form->get_value("is_default") ),
                'post_type' => "wpadverts-form"
            ), true );
            
            $m = __('Form Created. Loading Form Editor. If it is taking to long <a href="%s">click here</a>.', "wpadverts-custom-fields");
            
            $soft_redirect = add_query_arg( 'edit', $id, remove_query_arg( 'add' ) );
            $flash->add_info( sprintf( $m, $soft_redirect ) );
        } else {
            $flash->add_error( __("There are errors in your form.", "adverts") );
        }
    }
    
    $button_text = __("Create New Form", "wpadverts-custom-fields");
    
    include dirname( ADVERTS_PATH ) . '/wpadverts-custom-fields/admin/add.php';
}

function _wpadverts_custom_fields_page_edit() {
    $id = adverts_request( "edit" );
    $scheme = get_post( $id );
    
    if( $scheme->post_type != 'wpadverts-form' ) {
        echo __( "Inocrrect Form ID", "wpadverts-custom-fields" );
        return;
    }
    
    $status = $scheme->post_status;
    $forms = wpadverts_custom_fields_form_types();
    
    if( ! isset( $forms[ $scheme->post_status ] ) ) {
        echo __( "Inocrrect Form Type", "wpadverts-custom-fields" );
        return;
    }
    
    $data = $forms[$scheme->post_status];
    $data["scheme"] = $scheme;
    
    wp_enqueue_script( 'wpadverts-custom-fields-editor' );
    wp_enqueue_style( 'wpadverts-custom-fields-editor' );
    
    
    include $data["template"];
}


function _wpadverts_custom_fields_page_list() {
    
    $loop = new WP_Query(array(
        'post_type' => 'wpadverts-form',
        'post_status' => array_keys( wpadverts_custom_fields_form_types() ),
        'posts_per_page' => -1
    ));

    include dirname( ADVERTS_PATH ) . '/wpadverts-custom-fields/admin/options.php';
}

function _wpadverts_custom_fields_page_delete() {
    $post = get_post( adverts_request( 'delete' ) );

    if( !$post || $post->post_type != 'wpadverts-form' ) {
        wp_die(__('Form with given ID does not exist.', 'wpadverts-custom-fields'));
    }

    foreach( get_children( $post->ID ) as $child) {
        wp_delete_post( $child->ID, true );
    }

    $flash = Adverts_Flash::instance();
    $flash->add_info( __("Form deleted.", "wpadverts-custom-fields"));

    wp_delete_post( $post->ID, true );
    wp_redirect( remove_query_arg( array( 'delete', 'noheader', 'pg' ) ) );
    exit;
}

function wpadverts_custom_fields_name_exists( $value ) {
    
    $query = new WP_Query(array(
        "post_type" => "wpadverts-form",
        'post_status' => array_keys( wpadverts_custom_fields_form_types() ),
        "name" => $value
    ));
    
    if( $query->have_posts() ) {
        return "invalid";
    } else {
        return true;
    }
}
