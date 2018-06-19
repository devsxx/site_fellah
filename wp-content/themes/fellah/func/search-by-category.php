<?php

// Plugin Name: WPAdverts Snippets - Search by category
// Version: 1.0
// Author: Greg Winiarski
// Description: Adds categories dropdown input to [adverts_list] search bar.

// The code below you can paste in your theme functions.php or create
// new plugin and paste the code there.

add_filter( 'adverts_form_load', 'search_by_category_form_load' );
add_filter( 'adverts_list_query', 'search_by_category_query' );

/**
 * Adds category dropdown into search form in [adverts_list].
 * 
 * @param array $form Search form scheme
 * @return array Customized search form scheme 
 */
function search_by_category_form_load( $form ) {
    
    if( $form['name'] != 'search' ) {
        return $form;
    }

    $form['field'][] = array(
        "name" => "advert_category",
        "type" => "adverts_field_select",
        "order" => 20,
        "label" => 0,
        "max_choices" => 10,
        "options" => array(),
        "options_callback" => "adverts_taxonomies",
        "meta" => array(
            "search_group" => "visible",
            "search_type" => "full" 
        )
    );

    $form['field'][] = array(
        "name" => "localisation",
        "type" => "adverts_field_select",
        "order" => 20,
        "label" => 0,
        "max_choices" => 10,
        "options" => array(),
        "options_callback" => "adverts_localisation_taxonomies",
        "meta" => array(
            "search_group" => "visible",
            "search_type" => "full" 
        )
    );
 

    return $form;
}

/**
 * Adds tax_query param to WP_Query
 * 
 * The tax_query is added only if it is in $_GET['advert_category']
 * 
 * @param array $args WP_Query args
 * @return array Modified WP_Query args
 */
function search_by_category_query( $args ) {
    
    if( ! adverts_request( "advert_category" ) && ! adverts_request( "localisation" ) ) {
        return $args;
    }

    if( adverts_request( "advert_category" ) ) { 
        $args["tax_query"] = array(
            array(
                'taxonomy' => 'advert_category',
                'field'    => 'term_id',
                'terms'    => adverts_request( "advert_category" ),
            ),
        );
    }

    if( adverts_request( "localisation" ) ) {
        $args["tax_query"] = array(
            array(
                'taxonomy' => 'localisation',
                'field'    => 'term_id',
                'terms'    => adverts_request( "localisation" ),
            ),
        );
    }

    if( adverts_request( "advert_category" ) && adverts_request( "localisation" ) ) {
        
        $args["tax_query"] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'localisation',
                'field'    => 'term_id',
                'terms'    => adverts_request( "localisation" ),
            ),array(
                'taxonomy' => 'advert_category',
                'field'    => 'term_id',
                'terms'    => adverts_request( "advert_category" ),
            )
        );

    }
        
    return $args;
}


/**
 * Returns options for loacation field
 * 
 * This function is being used when generating loacation field in the (for example 
 * "post ad" form).
 * 
 * @uses adverts_walk_loacation_dropdown_tree()
 * @since 0.1
 * @return array
 */
function adverts_localisation_taxonomies( $taxonomy = 'localisation' ) {
     
    $args = array(
        'taxonomy'     => $taxonomy,
        'hierarchical' => true,
        'orderby'       => 'name',
        'order'         => 'ASC',
        'hide_empty'   => false,
        'depth'         => 0,
        'selected' => 0,
        'show_count' => 0,
		'parent'   => 0
        
    );
   
    
    include_once ADVERTS_PATH . '/includes/class-walker-category-options.php';
    
    $walker = new Adverts_Walker_Category_Options;

    $params = array(
        get_terms( $taxonomy, $args ),
        0,
        $args
    );
    
    return call_user_func_array(array( &$walker, 'walk' ), $params );
}

 


add_filter("manage_edit-advert_columns", "my_adverts_edit_columns", 20);
function my_adverts_edit_columns( $columns ) {
    $columns["localisation"] = __("Localisation");
    $columns["type_annonce"] = __("Type annonce");
    $columns['post_views']   = __('Views');
    return $columns;
}
add_action("manage_advert_posts_custom_column", "my_adverts_manage_post_columns", 10, 2);
function my_adverts_manage_post_columns( $column, $post_id ) {


    if($column == "localisation") {
        $localisation = wp_get_post_terms( $post_id, 'localisation');
        if(empty($localisation)) {
            echo "<em>Empty</em>";
        } else {
            $localisations = ' ';
            foreach ( $localisation as $local ) {
                $localisations .= $local->name;
            } 
            echo "<strong>". $localisations ."</strong>";
        }
    }

    if($column == "type_annonce") {
        $type_annonce = wp_get_post_terms( $post_id, 'type_annonce');
        if(empty($type_annonce)) {
            echo "<em>Empty</em>";
        } else {
            $type_annonces = ' ';
            foreach ( $type_annonce as $type ) {
                $type_annonces .= $type->name;
            } 
            echo "<strong>". $type_annonces ."</strong>";
        }
    }
    if($column === 'post_views'){
        echo getPostViews($post_id);
    }
}

 