<?php
/**
 * AJAX Actions
 * 
 * This functions are executed when user is doing an AJAX request.
 *
 * @package     Adverts
 * @subpackage  CustomFields
 * @copyright   Copyright (c) 2016, Grzegorz Winiarski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('wp_ajax_wpadverts-custom-fields-data-store', 'wpadverts_custom_fields_data_store');
add_action('wp_ajax_wpadverts-custom-fields-save', 'wpadverts_custom_fields_save');

/**
 * Returns options for $_REQUEST['data_source']
 * 
 * Action: wpadverts_custom_fields_data_store
 * 
 * @since 1.0.0
 * @return void
 */
function wpadverts_custom_fields_data_store() {
    
    if( ! check_ajax_referer( 'wpadverts-custom-fields', 'nonce', false ) ) {
        echo json_encode( array( 
            "result" => 0, 
            "error" => __( "Invalid Session. Please refresh the page and try again.", "adverts" ) 
        ) );
        
        exit;
    }
    
    $source = wpadverts_custom_fields_get_data_source( adverts_request( "data_source" ) );
    $data = call_user_func( $source["callback"] );
    
    echo json_encode( array(
        "result" => 1,
        "data" => $data,
        "source" => $source
    ) );
    
    exit;
}

/**
 * Saves Custom Fields Form in DB
 * 
 * Action: wpadverts_custom_fields_save
 * 
 * @since 1.0.0
 * @return void
 */
function wpadverts_custom_fields_save() {
    
    if( ! check_ajax_referer( 'wpadverts-custom-fields', 'nonce', false ) ) {
        echo json_encode( array( 
            "result" => 0, 
            "error" => __( "Invalid Session. Please refresh the page and try again.", "adverts" ) 
        ) );
        
        exit;
    }

    $response = new stdClass();
    $response->result = 1;
    
    $form_id = adverts_request( "form_id" );
    
    if( adverts_request( "is_string" ) == "1" ) {
        $data = json_decode( adverts_request( "form" ), true );
    } else {
        $data = adverts_request( "form" );
    }
    
    if( adverts_request( "is_default") == "1" ) {

        $post = get_post( $form_id );
        $query = new WP_Query(array(
            'post_type' => 'wpadverts-form', 
            'post_status' => $post->post_status,
            'post__not_in' => array( $post->ID )
        ));
    
        foreach( $query->posts as $p ) {
            wp_update_post(array(
                "ID" => $p->ID,
                "menu_order" => 0
            ));
        }
    }
    
    wp_update_post(array(
        "ID" => $form_id,
        "post_content" => serialize( $data ),
        "menu_order" => absint( adverts_request( "is_default" ) )
    ));
    
    echo json_encode( $response );
    exit;
}