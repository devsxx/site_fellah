<?php
/*
 * Plugin Name: WP Adverts - Custom Fields
 * Plugin URI: https://wpadverts.com/
 * Description: Customize: Advert Add, Search and Contact forms using easy to use drag and drop editor.
 * Author: Greg Winiarski
 * Text Domain: wpadverts-custom-fields
 * Version: 1.2.0
 * 
 * Adverts is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Adverts is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Adverts. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Adverts
 * @subpackage CustomFields
 * @author Grzegorz Winiarski
 * @global $adverts_namespace array
 * @version 0.1
 */

add_action( 'plugins_loaded', 'wpadverts_custom_fields_namespace' );
add_action( 'init', 'wpadverts_custom_fields_init' );

if( is_admin() ) {
    add_action( 'init', 'wpadverts_custom_fields_init_admin' );
} else {
    add_action( 'init', 'wpadverts_custom_fields_init_frontend' );
}

/**
 * Adds default addon configuration to $adverts_namespace
 * 
 * @global array $adverts_namespace
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function wpadverts_custom_fields_namespace() {
    global $adverts_namespace;

    // Add Fee Per Category to adverts_namespace, in order to store module options and default options
    $adverts_namespace['custom_fields'] = array(
        'option_name' => 'wpadverts_custom_fields',
        'default' => array( )
    );
}

/**
 * Inits Custom Fields plugin
 * 
 * This function executes actions/filters that need to be run with every request
 * when the integration is enabled.
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function wpadverts_custom_fields_init() {
    
    load_plugin_textdomain( "wpadverts-custom-fields", false, dirname( plugin_basename( __FILE__ ) ) . "/languages/" );
    
    $args = array(
        'labels'        => array(),
        'public'        => false,
        'show_ui'       => false,
        'supports'      => array( 'title' ),
        'has_archive'   => false,
    );
  
    register_post_status( 'wpad-form-add' );
    register_post_status( 'wpad-form-search' );
    register_post_status( 'wpad-form-contact' );
    
    register_post_type( 'wpadverts-form', apply_filters( 'adverts_post_type', $args, 'wpadverts-form') ); 
    
    wpadverts_custom_fields_register_data_source(array(
        "name" => "adverts-categories",
        "title" => __( "Adverts Categories", "wpadverts-custom-fields" ),
        "callback" => "adverts_taxonomies"
    ));
    
    include_once dirname( __FILE__ ) . '/includes/ajax.php';
    
}

/**
 * Init Custom Fields admin filters and actions
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function wpadverts_custom_fields_init_admin() {
    
    if( ! defined( "ADVERTS_PATH" ) ) {
        return;
    }
    
    include_once ADVERTS_PATH . 'includes/class-updates-manager.php';
    $manager = new Adverts_Updates_Manager(
        "wpadverts-custom-fields/wpadverts-custom-fields.php", 
        "wpadverts-custom-fields", 
        "1.2.0"
    );
    $manager->connect();

    wp_register_script( 'wpadverts-custom-fields-form-add', plugins_url( 'assets/js/admin-form-add.js', __FILE__ ), array( 'jquery' ), "1", true );
    
    wp_register_script( 
        'wpadverts-custom-fields-editor', 
        plugins_url( 'assets/js/admin-editor.js', __FILE__ ), 
        array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-dialog', 'wp-util' ), 
        "1", 
        true 
    );
    
    wp_register_script( 
        'wpadverts-custom-fields-editor-search', 
        plugins_url( 'assets/js/admin-editor-search.js', __FILE__ ), 
        array( 'wpadverts-custom-fields-editor' ), 
        "1", 
        true 
    );
    
    wp_register_script( 
        'wpadverts-custom-fields-editor-add', 
        plugins_url( 'assets/js/admin-editor-add.js', __FILE__ ), 
        array( 'wpadverts-custom-fields-editor' ), 
        "1", 
        true 
    );

    wp_register_script( 
        'wpadverts-custom-fields-post-type', 
        plugins_url( 'assets/js/admin-post-type.js', __FILE__ ), 
        array( 'jquery', 'jquery-ui-dialog' ), 
        "2", 
        true 
    );
    
    wp_register_style( 
        'wpadverts-custom-fields-editor', 
        plugins_url( '/assets/css/admin-editor.css', __FILE__ ), 
        array("wp-jquery-ui-dialog"), 
        "1" 
    );
    
    wp_register_style( 
        'wpadverts-custom-fields-post-type', 
        plugins_url( '/assets/css/admin-post-type.css', __FILE__ ), 
        array("wp-jquery-ui-dialog"), 
        "1" 
    );
    
    
    wp_localize_script( 'wpadverts-custom-fields-editor', 'wpadverts_custom_fields_editor', array(
        "ok" => __( "OK", "wpadverts-custom-fields" ),
        "delete" => __( "Delete" ),
        "cancel" => __( "Cancel" ),
        "select_icon" => __( "select icon ...", "wpadverts-custom-fields" )
    ) );
    
    include_once dirname( __FILE__ ) . "/includes/admin-post-type.php";
    
    add_action( "adverts_form_bind", "wpadverts_custom_fields_form_bind", 10 );
    add_filter( "adverts_list_query", "wpadverts_custom_fields_list_query", 8, 2 );
    add_filter( "adverts_form_scheme", "wpadverts_custom_fields_form_scheme_admin", 10, 2 );
    add_filter( "adverts_form_load", "wpadverts_custom_fields_form_load", 8 );
    add_action( "post_submitbox_misc_actions", 'wpadverts_custom_fields_form_scheme_meta_box', 12 );
    add_action( "save_post_advert", "wpadverts_custom_fields_save_form_scheme_admin", 10, 2 );
    add_action( "admin_footer-post-new.php", "wpadverts_custom_fields_post_new" );
}

/**
 * Init Custom Fields frontend filters and actions
 * 
 * @access public
 * @since 1.0
 * @return void
 */
function wpadverts_custom_fields_init_frontend() {
    add_action( "adverts_form_bind", "wpadverts_custom_fields_form_bind", 10 );
    add_filter( "adverts_form_load", "wpadverts_custom_fields_form_load", 8 );
    add_filter( "adverts_list_query", "wpadverts_custom_fields_list_query", 8, 2 );
    
    add_filter( "adverts_contact_form_email", "wpadverts_custom_fields_contact_form_email", 10, 3 );
    add_action( "adverts_post_save", "wpadverts_custom_fields_post_save", 10, 2 );
    add_action( "adverts_tpl_single_details", "wpadverts_custom_fields_tpl_single_details" );
    add_action( "adverts_tpl_single_bottom", "wpadverts_custom_fields_tpl_single_bottom", 5 );
    add_filter( "adverts_form_scheme", "wpadverts_custom_fields_form_scheme", 10, 2 );
    add_filter( "shortcode_atts_adverts_add", "wpadverts_custom_fields_extend_adverts_add", 10, 3 );
    add_filter( "shortcode_atts_adverts_manage", "wpadverts_custom_fields_extend_adverts_manage", 10, 3 );
    add_filter( "shortcode_atts_adverts_list", "wpadverts_custom_fields_extend_adverts_list", 10, 3 );
    add_filter( "shortcode_atts_adverts_mal_map", "wpadverts_custom_fields_extend_adverts_list", 10, 3 );

}

global $wpadverts_custom_fields_data_source;

/**
 * Registers new data source
 * 
 * Registered data sources can be used in Custom Fields editor to quickly 
 * fill multiselect (checkbox, radio, select) input options.
 * 
 * wpadverts_custom_fields_register_data_source(array(
 *     "name" => "unique-name-here",            // som unique name of your choosing
 *     "title" => "Options",                    // this will be visible to users 
 *     "callback" => "data_source_function"     // function which will list options
 * ));
 * 
 * 
 * @global array $wpadverts_custom_fields_data_source
 * 
 * @since 1.0.0
 * @access public
 * @param array $data
 * @return void
 */
function wpadverts_custom_fields_register_data_source( $data ) {
    global $wpadverts_custom_fields_data_source;
    
    $wpadverts_custom_fields_data_source[] = $data;
}

/**
 * Returns information about selected data source
 * 
 * Finds a data source in $wpadverts_custom_fields_data_source and returns
 * it.
 * 
 * @global array $wpadverts_custom_fields_data_source
 * 
 * @since 1.0.0
 * @access public
 * @param string $name      Data source name
 * @return array            Data source
 */
function wpadverts_custom_fields_get_data_source( $name = null ) {
    global $wpadverts_custom_fields_data_source;
    
    if( $name === null ) {
        return $wpadverts_custom_fields_data_source;
    }
    
    foreach( $wpadverts_custom_fields_data_source as $source ) {
        if( $source["name"] === $name ) {
            return $source;
        }
    }
    
    return null;
}

/**
 * Sets valuse for hidden _form_scheme and _form_scheme_id fields
 * 
 * @since 1.1.0
 * @access public
 * @param Adverts_Form $form    Form Object
 * @return Adverts_Form
 */
function wpadverts_custom_fields_form_bind( $form ) {
    $scheme = $form->get_scheme();

    if( isset( $scheme["form_scheme"] ) ) {
        $form->set_value( "_form_scheme", $scheme["form_scheme"] );
    }
    
    if( isset( $scheme["form_scheme_id"] ) ) {
        $form->set_value( "_form_scheme_id", $scheme["form_scheme_id"] );
    }
    
    return $form;
}

/**
 * Customizes WPAdverts Forms (search, contact and add).
 * 
 * Loads default form scheme for currently executed form and applies it.
 * 
 * @since 1.0.0
 * @access public
 * @param array $form       Adverts_Form scheme
 * @return array            Updated Adverts_Form scheme
 */
function wpadverts_custom_fields_form_load( $form ) {
    
    $form_group = apply_filters( "wpadverts_cf_form_load_names", array(
        "special" => array( "contact" ),
        "normal" => array( "advert", "search" )
    ) );
    
    // special treatment for contact form
    if( in_array( $form["name"], $form_group["special"] ) ) {
        $scheme = wpadverts_custom_fields_get_form_scheme( $form["name"] );
        
        if( $scheme instanceof WP_Post ) {
            $form_scheme  = wpadverts_custom_fields_form_load_prepare( $scheme );
            $form["field"] = $form_scheme["field"];

            if(isset($form_scheme["layout"])) {
                $form["layout"] = $form_scheme["layout"];
            }
        }
        
        return $form;
    }
    
    // Add, manage and search forms;
    if( ! isset( $form["form_scheme_id"] ) ) {
        return $form;
    }

    if( ! in_array( $form["name"], $form_group["normal"] ) ) {
        return $form;
    } 

    $scheme = get_post( $form["form_scheme_id"] );
    $form_scheme  = wpadverts_custom_fields_form_load_prepare( $scheme );
    
    $form["field"] = $form_scheme["field"];
    
    if(isset($form_scheme["layout"])) {
        $form["layout"] = $form_scheme["layout"];
    }

    $form["field"][] = array(
        "name" => "_form_scheme",
        "type" => "adverts_field_hidden",
        "order" => 0,
        "label" => "",
        "value" => 1,
        "class" => "wpadverts-plupload-multipart-default"
    );
    
    $form["field"][] = array(
        "name" => "_form_scheme_id",
        "type" => "adverts_field_hidden",
        "order" => 0,
        "label" => "",
        "class" => "wpadverts-plupload-multipart-default"
    );

    return $form;
}

/**
 * Appends attributes to form scheme.
 * 
 * This function is executed by 'adverts_form_scheme' filter, which is typically
 * executed inside shortcodes functions (by default in [adverts_list] and [adverts_add])
 * it allows to update form scheme before it is loaded into the form with some
 * shortcode parameters.
 * 
 * @see adverts_form_scheme filter.
 * 
 * @since 1.0.0
 * 
 * @param array $form       Adverts_Form structure
 * @param array $params     Typically array of shortocde params
 * @return array            Updated Adverts_Form structure
 */
function wpadverts_custom_fields_form_scheme( $form, $params ) {
    if( isset( $params["form_scheme"] ) ) {
        $form["form_scheme"] = $params["form_scheme"];
    }
    
    if( isset( $params["form_scheme_id"] ) ) {
        $form["form_scheme_id"] = $params["form_scheme_id"];
    }
    
    return $form;
}

/**
 * Sets a callback function for each multiselect field in the form scheme.
 * 
 * This function prepares form scheme to make it compatible with Adverts_Form
 * array.
 * 
 * @see wpadverts_custom_fields_form_load()
 * 
 * @since 1.0.0
 * @access public
 * @param WP_Post $scheme   WP_Post with post_type = 'wpadverts-form'
 * @return array            Adverts_Form fields
 */
function wpadverts_custom_fields_form_load_prepare( $scheme ) {
    $fields = unserialize( $scheme->post_content );
    $data = array();
    
    if( $fields === false ) {
        return null;
    }
    
    foreach( $fields["field"] as $key => $field ) {
        
        if( isset( $field["max_choices"] ) && $field["max_choices"] > 0 ) {
            $fields["field"][$key]["validator"][] = array(
                "name" => "max_choices",
                "params" => array( "max_choices" => $field["max_choices"] )
            );
        }
        
        if( ! isset($field["meta"]["cf_options_fill_method"]) ) {
            continue;
        }
        
        if( $field["meta"]["cf_options_fill_method"] == "callback" ) {
            $source = wpadverts_custom_fields_get_data_source( $field["meta"]["cf_data_source"] );
            $fields["field"][$key]["options_callback"] = $source["callback"];
        } else {
            
        }
        

    }

    return $fields;
}

/**
 * Customize [adverts_list] query params.
 * 
 * This function is executed via adverts_list_query filter in [adverts_list] 
 * shortocde and applied in wpadverts_custom_fields_init_frontend().
 * 
 * @see wpadverts_custom_fields_init_frontend()
 * 
 * @since 1.0.0
 * @since 1.0.1             $params variable
 * @since 1.2.0             $form_type variable
 * 
 * @access public
 * @param array     $args       WP_Query args
 * @param array     $params     [adverts_list] shortcode params
 * @param string    $form_type  The search form type
 * @return array                Updated WP_Query args
 */
function wpadverts_custom_fields_list_query( $args, $params = null, $form_type = 'search' ) {
    
    $scheme_name = null;
    
    if( isset( $params["form_scheme"] ) ) {
        $scheme_name = $params["form_scheme"];
    }
    
    $scheme = wpadverts_custom_fields_get_form_scheme( $form_type, $scheme_name );

    if( $scheme === null ) {
        return $args;
    }
    
    $form_scheme = wpadverts_custom_fields_form_load_prepare( $scheme );

    if( $form_scheme === null ) {
        return $args;
    }
    
    foreach( $form_scheme["field"] as $field ) {
        
        if( ! isset( $field["meta"]["cf_search_field"] ) ) {
            // no search params set for this field
            continue;
        }
        
        $field_value = adverts_request( $field["name"] );
        
        if( empty( $field_value ) ) {
            // no search value provided
            continue;
        }
        
        $field_meta = $field["meta"];
        
        list( $search_type, $search_field ) = explode( "__", $field_meta["cf_search_field"] );
        
        if( $search_type == "taxonomy" ) {
            
            // Search by Taxonomy
            if( ! isset( $args["tax_query"] ) || ! is_array( $args["tax_query"] ) ) {
                // Make sure the taxonomy is an array
                $args["tax_query"] = array();
            }
            
            $args["tax_query"][] = array(
                'taxonomy'          => $search_field,
                'field'             => $field_meta["cf_search_taxonomy_field"],
                'terms'             => adverts_request( $field["name"] ),
                'include_children'  => $field_meta["cf_search_taxonomy_include_children"],
                'operator'          => str_replace( "-", " ", $field_meta["cf_search_taxonomy_operator"] )
            );
            
        } else if( $search_type == "meta" ) {
            // Search by Meta
            if( ! isset( $args["meta_query"] ) || ! is_array( $args["meta_query"] ) ) {
                // Make sure the meta query is an array
                $args["meta_query"] = array();
            }
            
            $compare = array(
                "equal" => "=",
                "not-equal" => "!=",
                "greater" => ">",
                "greater-or-equal" => ">=",
                "less" => "<",
                "less-or-equal" => "<=",
                "like" => "LIKE",
                "not-like" => "NOT LIKE",
                "in" => "IN",
                "not-in" => "NOT IN"
            );
            
            $value = adverts_request( $field["name"] );
            
            if( is_array( $value ) && ! in_array( $field_meta["cf_search_meta_compare"], array( "in", "not-in" ) ) ) {
                $value = $value[0];
            }
            
            $args["meta_query"][] = array( 
                'key' => $search_field, 
                'value' => $value, 
                'compare' => $compare[ $field_meta["cf_search_meta_compare"] ],
                'type' => $field_meta["cf_search_meta_operator"]
            );
        } else if( $search_type == "date" ) {
            // Search by Date
            if( ! isset( $args["date_query"] ) || ! is_array( $args["date_query"] ) ) {
                // Make sure the date query is an array
                $args["date_query"] = array();
            }
            
            $after = null;
            $before = null;
            
            if( in_array( $field_meta["cf_search_date"], array( "on", "after" ) ) ) {
                $after = adverts_request( $field["name"] );
            }
            
            if( in_array( $field_meta["cf_search_date"], array( "on", "before" ) ) ) {
                $before = adverts_request( $field["name"] );
            }
            
            $args["date_query"][] = array(
                "column" => $search_field,
                "after" => $after,
                "before" => $before,
                "inclusive" => true
            );
        } else if( $field_meta["cf_search_field"] == "defaults__p" ) {
            // Search by ID
            $args["p"] = adverts_request( $field["name"] );
        } else if( $field_meta["cf_search_field"] == "defaults__s") {
            // Search by Keyword
            $args["s"] = adverts_request( $field["name"] );
        } else if( $field_meta["cf_search_field"] == "defaults__title") {
            // Search by Title
            $args["title"] = adverts_request( $field["name"] );
        } else if( $field_meta["cf_search_field"] == "defaults__author_id" ) {
            // Search by Author ID
            $args["author"] = adverts_request( $field["name"] );
        } else if( $field_meta["cf_search_field"] == "defaults__author_name") {
            // Search by Author Name
            $args["author_name"] = adverts_request( $field["name"] );
        }
    }
    
    return $args;
}
 
/** 
 * Extends allowed [adverts_add] attributes.
 *
 * Uses 'shortcode_atts_adverts_add' filter to inject new parameters.
 * 
 * @since 1.0.0
 *
 * @param array  $out       The output array of shortcode attributes.
 * @param array  $pairs     The supported attributes and their defaults.
 * @param array  $atts      The user defined shortcode attributes.
 * @return array            The output array of shortcode attributes.
 */
function wpadverts_custom_fields_extend_adverts_add( $out, $pairs, $atts ) {
    $name = null;
    
    if( isset( $atts["form_scheme"] ) ) {
        $name = $atts["form_scheme"];
    } 
    
    $scheme = wpadverts_custom_fields_get_form_scheme( "add", $name );
    
    if( $scheme ) {
        $out["form_scheme"] = $name;
        $out["form_scheme_id"] = $scheme->ID;
    }

    return $out;
}

/** 
 * Extends allowed [adverts_manage] attributes.
 *
 * Uses 'shortcode_atts_adverts_manage' filter to inject new parameters.
 * 
 * @since 1.0.0
 *
 * @param array  $out       The output array of shortcode attributes.
 * @param array  $pairs     The supported attributes and their defaults.
 * @param array  $atts      The user defined shortcode attributes.
 * @return array            The output array of shortcode attributes.
 */
function wpadverts_custom_fields_extend_adverts_manage( $out, $pairs, $atts ) {

    $advert_id = adverts_request( "advert_id" );
    
    if( ! $advert_id ) {
        return $out;
    }
    
    $scheme = null;
    $scheme_id = get_post_meta( $advert_id, "_wpacf_form_scheme_id", true );
    $scheme_post = get_post( $scheme_id );
    
    if( $scheme_post && $scheme_post->post_type == "wpadverts-form" ) {
        $scheme = $scheme_post;
    } else {
        $scheme = wpadverts_custom_fields_get_form_scheme( "add" );
    }
    
    if( $scheme ) {
        $out["form_scheme"] = $scheme->post_name;
        $out["form_scheme_id"] = $scheme->ID;
    }

    return $out;
}

/** 
 * Extends allowed [adverts_list] attributes.
 *
 * Uses 'shortcode_atts_adverts_list' filter to inject new parameters.
 * 
 * @since 1.0.0
 *
 * @param array  $out       The output array of shortcode attributes.
 * @param array  $pairs     The supported attributes and their defaults.
 * @param array  $atts      The user defined shortcode attributes.
 * @return array            The output array of shortcode attributes.
 */
function wpadverts_custom_fields_extend_adverts_list( $out, $pairs, $atts ) {
    $name = null;
    
    if( isset( $atts["form_scheme"] ) ) {
        $name = $atts["form_scheme"];
    } 
    
    $scheme = wpadverts_custom_fields_get_form_scheme( "search", $name );
    
    if( $scheme ) {
        $out["form_scheme"] = $name;
        $out["form_scheme_id"] = $scheme->ID;
    }

    return $out;
}

/**
 * Save used form scheme id in DB
 * 
 * Saves _wpacf_form_scheme_id meta in wp_postmeta table. This function is executed
 * using 'adverts_post_save' action.
 * 
 * @since 1.0.0
 * 
 * @param Adverts_Form $form
 * @param int $post_id
 * @return void
 */
function wpadverts_custom_fields_post_save( $form, $post_id ) {
    try {
        $form_scheme_id = $form->get_scheme( "form_scheme_id" );
        update_post_meta( $post_id, "_wpacf_form_scheme_id", $form_scheme_id );
    } catch(Exception $e) {
        // silently ignore this
    }
}

/**
 * Loads a form scheme
 * 
 * This function loads form scheme either:
 * - default scheme for $type if $name param is NULL
 * - scheme identified by $type and $name
 * 
 * If scheme cannot be found function returns NULL.
 * 
 * @param string $type      Scheme type, one of "add", "search", "contact".
 * @param string $name      Scheme name (entered when creating form scheme)
 * @return WP_Post          WP_Post object or null
 */
function wpadverts_custom_fields_get_form_scheme( $type, $name = null ) {
    
    $types = array();
    foreach( array_keys( wpadverts_custom_fields_form_types() ) as $t ) {
        $types[] = str_replace( "wpad-form-", "", $t );
    }
    
    if( ! in_array($type, $types ) ) {
        trigger_error( 'First param ($type) is incorrect.' );
    }

    $list = new WP_Query(array(
        'post_type' => 'wpadverts-form', 
        'post_status' => 'wpad-form-' . $type,
        'orderby' => array( 'menu_order' => 'DESC' ),
        'posts_per_page' => 1
    ));
    
    $default = null;
    
    if( ! empty( $list->posts ) && $list->posts[0]->menu_order == 1 ) {
        $default = $list->posts[0];
    }
    
    if( $name === null ) {
        return $default;
    }
    
    $list = new WP_Query(array(
        'post_type' => 'wpadverts-form', 
        'post_status' => 'wpad-form-' . $type,
        'name' => $name,
    ));
 
    if( ! empty( $list->posts ) ) {
        return $list->posts[0];
    }
}

/**
 * Adds additional information into email sent using contact form
 * 
 * This function is executed by adverts_contact_form_email filter.
 * 
 * @since 1.0.0
 * @access public
 * 
 * @param array         $mail       Array with information about mail
 * @param int           $post_id    ID of an Advert to which a reply is being sent
 * @param Adverts_Form  $form       Adverts_Form object
 * @return void                     Updated $mail array
 */
function wpadverts_custom_fields_contact_form_email( $mail, $post_id, $form ) {
    
    $scheme = $form->get_scheme();
    
    $prepend = "";
    $append = "";
    
    foreach( $scheme["field"] as $scheme_field ) {

        if( ! isset( $scheme_field["meta"]["cf_builtin"] ) || $scheme_field["meta"]["cf_builtin"] == "1" ) {
            continue;
        }
        
        $field_value = $form->get_value( $scheme_field["name"] );
        
        if( empty( $field_value ) ) {
            continue;
        }
        
        if( is_array( $field_value ) ) {
            $field_value = join( ", ", $field_value );
        }
        
        if( $scheme_field["type"] == "adverts_field_textarea" ) {
            $append .= "\r\n\r\n" . strtoupper( $scheme_field["label"] );
            $append .= "\r\n" . $field_value;
        } else {
            $prepend .= $scheme_field["label"] . ": " . $field_value . "\r\n";
        }
    }
    
    if( $prepend ) {
        $mail["message"] = $prepend . "\r\n" . $mail["message"];
    } 
    
    if( $append ) {
        $mail["message"] .= $append;
    }

    return $mail;
}

function wpadverts_custom_fields_tpl_single_details( $post_id ) {
    wpadverts_custom_fields_tpl_single( $post_id, "table-row" );
}

function wpadverts_custom_fields_tpl_single_bottom( $post_id ) {
    wpadverts_custom_fields_tpl_single( $post_id, "full-width" );
}

function wpadverts_custom_fields_tpl_single( $post_id, $collect ) {
    $form_scheme_id = get_post_meta( $post_id, "_wpacf_form_scheme_id", true );
    
    if( ! $form_scheme_id ) {
        return;
    }
    
    $form_scheme = get_post( $form_scheme_id );
    $scheme = unserialize( $form_scheme->post_content );
    $fields = array();
    
    if( $scheme === null ) {
        return;
    }
    
    foreach( $scheme["field"] as $field ) {
        
        if( $field["type"] == "adverts_field_header" ) {
            continue;
        }
        
        if( isset( $field["meta"]["cf_builtin"] ) && $field["meta"]["cf_builtin"] == 1 ) {
            continue;
        }
        
        if( ! isset( $field["meta"]["cf_display"] ) ) {
            continue;;
        }
        
        if( $field["meta"]["cf_display"] != "anywhere" ) {
            continue;
        }
        
        if( $field["meta"]["cf_display_type"] != $collect ) {
            continue;
        }
        
        $fields[$field["order"]] = $field;
    }
    
    ksort($fields);
    
    foreach( $fields as $field ) {
        
        $data = array();
        $icon = "";
        $display_as = $field["meta"]["cf_display_as"];
        $is_callback = false;
        $source = null;
        
        if( isset( $field["meta"]["cf_options_fill_method"] ) && $field["meta"]["cf_options_fill_method"] == "callback" ) {
            $is_callback = true;
            $source = wpadverts_custom_fields_get_data_source($field["meta"]["cf_data_source"]);
        }
        
        if( $is_callback && isset( $source["taxonomy"] ) ) {
            
            $terms = wp_get_post_terms( $post_id, $source["taxonomy"]);
            $values = array();
            foreach( $terms as $term ) {
                $term_url = esc_attr( get_term_link( $term ) );
                $term_title = join( " / ", advert_term_path( $term, $source["taxonomy"] ) );
                if( $display_as == "text" ) {
                    $values[] = $term_title;
                } elseif( $display_as == "html" ) {
                    $values[] = sprintf( '<a href="%s">%s</a>', $term_url, $term_title );
                } else {
                    $values = array( "<strong>ERROR</strong>: Incorrect display type set." );
                }
            }
        } else {
            $values = get_post_meta( $post_id, $field["name"] );
        }
        
        if( ! empty( $field["meta"]["cf_display_icon"] ) ) {
            $icon = "adverts-icon-" . $field["meta"]["cf_display_icon"];
        } else {
            $icon = "adverts-icon-none";
        }

        foreach( $values as $value ) {
            if( $display_as == "text" ) {
                $data[] = esc_html( $value );
            } else if( $display_as == "html" ) {
                $data[] = $value;
            } else if( $display_as == "url" ) {
                $data[] = sprintf( '<a href="%s">%s</a>', esc_html( $value ), esc_html( $value ) );
            } else if( $display_as == "image" ) {
                $data[] = sprintf( '<img src="%s" alt="" />', esc_html( $value ) );
            } else if( $display_as == "audio" ) {
                $data[] = wp_audio_shortcode( array( "src" => $value ) );
            } else if( $display_as == "oembed" ) {
                $data[] = wp_oembed_get($value);
            } else if( $display_as == "video" ) {
                $data[] = wp_video_shortcode( array( "src" => $value ) );
            } else {
                $data[] = "";
            }
        }
  
        $data_string = "";
        $row_classes = "adverts-row-name-" . $field["name"];
        
        foreach( $data as $item ) {
            $data_string .= sprintf( '<span class="adverts-row-value">%s</span>', $item );
        }
        
        if( empty( $data_string ) ) {
            continue;
        }
        
        if( ! isset( $field["meta"]["cf_display_style"] ) ) {
            // default to separate by coma
            $row_classes .= " adverts-row-values-inline-coma";
        } else if( $field["meta"]["cf_display_style"] == "inline-none" ) {
            // separate with additional margin
            $row_classes .= " adverts-row-values-inline-none";
        } else if( $field["meta"]["cf_display_style"] == "block" ) {
            // one per line
            $row_classes .= " adverts-row-values-block";
        } else {
            // default to separate by coma
            $row_classes .= " adverts-row-values-inline-coma";
        }
        
        if( $collect == "table-row") {
            ?>
            <div class="adverts-grid-row <?php echo esc_html( $row_classes ) ?>">
                <div class="adverts-grid-col adverts-col-30">
                    <span class="adverts-round-icon <?php echo $icon ?>"></span>
                    <span class="adverts-row-title"><?php echo esc_html( $field["label"] ) ?></span>
                </div>
                <div class="adverts-grid-col adverts-col-65">
                    <?php echo $data_string ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="adverts-single-content <?php echo esc_html( $row_classes ) ?>">
                <h3 class="adverts-single-content-title"><?php echo esc_html( $field["label"] ) ?></h3>
                <div class="adverts-content">
                    <?php echo $data_string ?>
                </div>
            </div>
            <?php
        }
    }
 
}

/**
 * Returns registered form types
 * 
 * @since 1.1.2
 * @return array
 */
function wpadverts_custom_fields_form_types() {
    
    $forms = array(
        "wpad-form-add" => array(
            "class" => "wpadverts-custom-fields-type-add",
            "template" => dirname( ADVERTS_PATH ) . '/wpadverts-custom-fields/admin/editor-add.php'
        ),
        "wpad-form-search" => array(
            "class" => "wpadverts-custom-fields-type-search",
            "template" => dirname( ADVERTS_PATH ) . '/wpadverts-custom-fields/admin/editor-search.php'
        ),
        "wpad-form-contact" => array(
            "class" => "wpadverts-custom-fields-type-contact",
            "template" => dirname( ADVERTS_PATH ) . '/wpadverts-custom-fields/admin/editor-contact.php'
        )
    );
    
    return apply_filters( 'wpadverts_cf_form_types', $forms );
}