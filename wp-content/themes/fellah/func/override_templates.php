<?php

add_action("adverts_template_load", "override_templates");

/**
 * Loads WPAdverts templates from current theme or child-theme directory.
 *
 * By default WPAdverts loads templates from wpadverts/templates directory,
 * this function tries to load files from your current theme 'wpadverts'
 * directory for example wp-content/themes/twentytwelve/wpadverts.
 *
 * The function will look for templates in three places, if the template will
 * be found in fist one the other places are not being checked.
 
 * @param string $tpl Absolute path to template file
 * @return string
 */
function override_templates( $tpl ) {
     
    $dirs = array();
    // first check in child-theme directory
    $dirs[] = get_stylesheet_directory() . "/wpadverts/";
    // next check in parent theme directory
    $dirs[] = get_template_directory() . "/wpadverts/";
    // if nothing else use default template
    $dirs[] = ADVERTS_PATH . "/templates/";
     
    $basename = basename( $tpl );
     
    foreach($dirs as $dir) {
        if( file_exists( $dir . $basename ) ) {
            return $dir . $basename;
        }
    }
}


// List functions attached to adverts_tpl_single_posted_by.
add_action( 'wp_head', 'wp_filter_for_one_action' );
function wp_filter_for_one_action() {
  global $wp_filter;
  echo '<!-- ', var_export( $wp_filter[ 'adverts_tpl_single_posted_by' ], true ), ' -->';
}