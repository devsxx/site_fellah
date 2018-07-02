<?php
/**
 * Plugin Name: BP Add Page
 * Plugin URI:  https://webdevstudios.com
 * Description: Example on adding a page to BuddyPress profiles
 * Author:      WebDevStudios
 * Author URI:  https://webdevstudios.com
 * Version:     1.0.0
 * License:     GPLv2
 */


/**
 * adds the profile user nav link
 */
function bp_custom_user_nav_item() {
    global $bp;

    $args = array(
            'name' => __('Messages', 'fellah'),
            'slug' => 'messages',
            'default_subnav_slug' => 'messages',
            'position' => 50,
            'screen_function' => 'bp_custom_user_nav_item_screen',
            'item_css_id' => 'messages'
    );

    bp_core_new_nav_item( $args );
}

// add_action( 'bp_setup_nav', 'bp_custom_user_nav_item', 99 );

/**
 * the calback function from our nav item arguments
 */
function bp_custom_user_nav_item_screen() {
    add_action( 'bp_template_content', 'bp_custom_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

/**
 * the function hooked to bp_template_content, this hook is in plugns.php
 */
function bp_custom_screen_content() { 
    ob_start();	
    include(get_template_directory() . '/templates/template-user-messages.php');
    ob_end_clean();
    // include realpath(dirname(__FILE__) . '/..' ) . '/templates/template-user-messages.php';
    // echo realpath(dirname(__FILE__) . '/..') . '/buddypress/members/single/template-user-messages.php';

}


add_filter( 'login_redirect', 'fellah_redirect_to_profile', 11, 3 );
 
function fellah_redirect_to_profile( $redirect_to_calculated, $redirect_url_specified, $user ){
 
    if( empty( $redirect_to_calculated ) )
        $redirect_to_calculated = admin_url();
 
    //if the user is not site admin,redirect to his/her profile
 
    if( isset( $user->ID) && ! is_super_admin( $user->ID ) )
        return bp_core_get_user_domain( $user->ID );
    else
        return $redirect_to_calculated; /*if site admin or not logged in,do not do anything much*/
 
}


add_action('wp_logout','fellah_auto_redirect_after_logout');
function fellah_auto_redirect_after_logout(){
	wp_redirect( home_url() );
	exit();
}
