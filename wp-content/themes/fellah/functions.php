<?php
/**
 * fellah functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fellah
 */

if ( ! function_exists( 'fellah_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fellah_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on fellah, use a find and replace
		 * to change 'fellah' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fellah', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'fellah' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fellah_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'fellah_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fellah_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'fellah_content_width', 640 );
}
add_action( 'after_setup_theme', 'fellah_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fellah_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fellah' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'fellah' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fellah_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fellah_scripts() {
	
	wp_enqueue_style( 'fellah-fonts', 'https://fonts.googleapis.com/css?family=Raleway:200,200i,300,300i,400,400i,500,600,700' );
	wp_enqueue_style( 'fellah-fonts-2', 'https://fonts.googleapis.com/css?family=Quicksand:300,400,500' );
	wp_enqueue_style( 'fellah-style', get_stylesheet_uri() );


	wp_enqueue_script( 'tether', 			get_template_directory_uri() . '/js/libs/tether/dist/js/tether.min.js', array(), '20151215', true );
	wp_enqueue_script( 'bootstrap', 		get_template_directory_uri() . '/js/libs/bootstrap/dist/js/bootstrap.min.js', array(), '20151215', true );
	wp_enqueue_script( 'owl.carousel', 		get_template_directory_uri() . '/js/libs/owl.carousel/src/js/owl.carousel.js', array(), '20151215', true );
	wp_enqueue_script( 'owl.navigation',	get_template_directory_uri() . '/js/libs/owl.carousel/src/js/owl.navigation.js', array(), '20151 ', true );

	wp_enqueue_script( 'script',   			get_template_directory_uri() . '/js/script.js', array(), '20151215', true ); 
	wp_enqueue_script( 'fellah-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'fellah-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

 
 
 

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fellah_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_filter( 'get_the_archive_title', function ($title) {

	if ( is_category() ) {

			  $title = single_cat_title( '', false );

		 } elseif ( is_tag() ) {

			  $title = single_tag_title( '', false );

		 } elseif ( is_author() ) {

			  $title = '<span class="vcard">' . get_the_author() . '</span>' ;

		 }

	return $title;

});

function custom_excerpt_length( $length ) { return 33; }
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


add_filter( 'manage_advert_posts_columns', array( 'WPPostRatingsAdmin', 'postrating_admin_column_title' ) );
add_action( 'manage_advert_posts_custom_column', array( 'WPPostRatingsAdmin', 'postrating_admin_column_content' ) ); 




$adverts_namespace['gallery'] = array(
	'option_name' => 'adverts_gallery',
	'default' => array(
		 'ui' => 'pagination', // either paginator or thumbnails
		 'visible_items' => 5,
		 'scrolling_items' => 1,
		 'lightbox' => 1,
		 'image_edit_cap' => 'read',
		 'image_sizes' => array(
			  // supported sizes: adverts-upload-thumbnail, adverts-list, adverts-gallery
			  "adverts-gallery" => array( 'enabled' => 1, 'width' => 650, 'height' => 300, 'crop' => true ),
			  "adverts-list" => array( 'enabled' => 1, 'width' => 255, 'height' => 255, 'crop' => true ),
			  "adverts-upload-thumbnail" => array( 'enabled' => 1, 'width' => 150, 'height' => 150, 'crop' => true ),
			  //"adverts-gallery-thumbnail"
		 ),
	)
);



require get_template_directory() . '/func/add-currency.php';
require get_template_directory() . '/func/custom-fields-taxonomies.php';
require get_template_directory() . '/func/override_templates.php';
require get_template_directory() . '/func/search-by-category.php';
// require get_template_directory() . '/func/search-by-price.php';

require get_template_directory() . '/func/compteur-vues.php';
require get_template_directory() . '/func/breadcrumb.php';


if( !defined("ADVERTS_FILE") ) {
	define( "ADVERTS_FILE", __FILE__ );
	define( "ADVERTS_PATH", plugin_dir_path( ADVERTS_FILE ) );
	define( "ADVERTS_URL", plugins_url() . "/" . basename(ADVERTS_PATH) );
} 


add_shortcode('form_search', 'shortcode_adverts_form_search');
function shortcode_adverts_form_search( $atts ) {
 
	wp_enqueue_style( 'adverts-frontend' );
	wp_enqueue_style( 'adverts-icons' );
	wp_enqueue_style( 'adverts-icons-animate' );

	wp_enqueue_script( 'adverts-frontend' );
	wp_enqueue_script( 'adverts-frontend-manage' );

	$params = shortcode_atts(array(
		 'name' => 'default',
		 'author' => null,
		 'redirect_to' => '',
		 'search_bar' => adverts_config( 'config.ads_list_default__search_bar' ),
		 'show_results' => true,
		 'category' => null,
		 'columns' => adverts_config( 'config.ads_list_default__columns' ),
		 'display' => adverts_config( 'config.ads_list_default__display' ),
		 'switch_views' => adverts_config( 'config.ads_list_default__switch_views' ),
		 'allow_sorting' => 0,
		 'order_by' => 'date-desc',
		 'paged' => adverts_request("pg", 1),
		 'posts_per_page' => adverts_config( 'config.ads_list_default__posts_per_page' ),
		 'show_pagination' => true
	), $atts, 'adverts_list' );
	
	extract( $params );
	$action = get_permalink( $redirect_to );
 
	$taxonomy = null;
	$meta = array();
	$orderby = array();
	
	$query = adverts_request("query");
	$location = adverts_request("location");
	
	if($location) {
		 $meta[] = array('key'=>'adverts_location', 'value'=>$location, 'compare'=>'LIKE');
	}
	
	if($category) {
		$taxonomy =  array(
			  array(
					'taxonomy' => 'advert_category',
					'field'    => 'term_id',
					'terms'    => $category,
			  ),
  		);
	}

	if($allow_sorting && adverts_request("adverts_sort")) {
		 $adverts_sort = adverts_request("adverts_sort");
	} else {
		 $adverts_sort = $order_by;
	}
	
	// options: title, post_date, adverts_price
	$sort_options = apply_filters( "adverts_list_sort_options", array(
		 "date" => array(
			  "label" => __("Publish Date", "adverts"),
			  "items" => array(
					"date-desc" => __("Newest First", "adverts"),
					"date-asc" => __("Oldest First", "adverts")
			  )
		 ),
		 "price" => array(
			  "label" => __("Price", "adverts"),
			  "items" => array(
					"price-asc" => __("Cheapest First", "adverts"),
					"price-desc" => __("Most Expensive First", "adverts")
			  )
		 ),
		 "title" => array(
			  "label" => __("Title", "adverts"),
			  "items" => array(
					"title-asc" => __("From A to Z", "adverts"),
					"title-desc" => __("From Z to A", "adverts")
			  )
		 )
	) );
	
	$sarr = explode("-", $adverts_sort);
	$sort_current_text = __("Publish Date", "adverts");
	$sort_current_title = sprintf( __( "Sort By: %s - %s", "adverts"), __("Publish Date", "adverts"), __("Newest First", "adverts") );
	
	if( isset( $sarr[1] ) && isset( $sort_options[$sarr[0]]["items"][$adverts_sort] ) ) {

		 $sort_key = $sarr[0];
		 $sort_dir = $sarr[1];

		 if($sort_dir == "asc") {
			  $sort_dir = "ASC";
		 } else {
			  $sort_dir = "DESC";
		 }

		 if($sort_key == "title") {
			  $orderby["title"] = $sort_dir;
		 } elseif($sort_key == "date") {
			  $orderby["date"] = $sort_dir;
		 } elseif($sort_key == "price") {
			  $orderby["adverts_price__orderby"] = $sort_dir;
			  $meta["adverts_price__orderby"] = array(
					'key' => 'adverts_price',
					'type' => 'NUMERIC',
					'compare' => 'NUMERIC',
			  );
		 } else {
			  // apply sorting using adverts_list_query filter.
		 }

		 $sort_current_text = $sort_options[$sort_key]["label"] ;
		 $s_descr = $sort_options[$sort_key]["items"][$adverts_sort];
		 $sort_current_title = sprintf( __( "Sort By: %s - %s", "adverts"), $sort_current_text, $s_descr );
	} else {
		 $adverts_sort = $order_by;
		 $orderby["date"] = "desc"; 
	}
	
	$args = apply_filters( "adverts_list_query", array( 
		 'author' => $author,
		 'post_type' => 'advert', 
		 'post_status' => 'publish',
		 'posts_per_page' => $posts_per_page, 
		 'paged' => $paged,
		 's' => $query,
		 'meta_query' => $meta,
		 'tax_query' => $taxonomy,
		 'orderby' => $orderby
	), $params);

	if( $category && is_tax( 'advert_category' ) ) {
		 $pbase = get_term_link( get_queried_object()->term_id, 'advert_category' );
	} else {
		 $pbase = get_the_permalink();
	}
	
	$loop = new WP_Query( $args );
	$paginate_base = apply_filters( 'adverts_list_pagination_base', $pbase . '%_%' );
	$paginate_format = stripos( $paginate_base, '?' ) ? '&pg=%#%' : '?pg=%#%';
	
	include_once ADVERTS_PATH . 'includes/class-html.php';
	include_once ADVERTS_PATH . 'includes/class-form.php';

	if( $switch_views && in_array( adverts_request( "display", "" ), array( "grid", "list" ) ) ) {
		 $display = adverts_request( "display" );
		 add_filter( "adverts_form_load", "adverts_form_search_display_hidden" );
	}

	if( $display == "list" ) {
		 $columns = 1;
	}
	
	if( adverts_request( "reveal_hidden" ) == "1" ) {
		 add_filter( "adverts_form_load", "adverts_form_search_reveal_hidden" );
	}
	
	$form_scheme = apply_filters( "adverts_form_scheme", Adverts::instance()->get("form_search"), $params );
	$form = new Adverts_Form( $form_scheme );
	$form->bind( stripslashes_deep( $_GET ) );
	$fields_hidden = array();
	$fields_visible = array();
	
	$counter = array(
		 "visible-half" => 0,
		 "visible-full" => 0,
		 "hidden-half" => 0,
		 "hidden-full" => 0
	);
	
	foreach($form->get_fields() as $field) {
		 
		 $search_group = "hidden";
		 $search_type = "half";
		 
		 if( isset( $field['meta']["search_group"] ) ) {
			  $search_group = $field['meta']['search_group'];
		 }
		 
		 if( isset( $field['meta']['search_type'] ) ) {
			  $search_type = $field['meta']['search_type'];
		 }
		 
		 $counter[ $search_group . '-' . $search_type ]++;
		 
		 if( $search_type == 'full' ) {
			  $field['adverts_list_classes'] = 'advert-input-type-full';
		 } else if( $counter[ $search_group . '-' . $search_type ] % 2 == 0 ) {
			  $field['adverts_list_classes'] = 'advert-input-type-half advert-input-type-half-right';
		 } else {
			  $field['adverts_list_classes'] = 'advert-input-type-half advert-input-type-half-left';
		 }
		 
		 if( $search_group == "visible" ) {
			  $fields_visible[] = $field;
		 } else {
			  $fields_hidden[] = $field;
		 }
	}
	
	// adverts/templates/form_search.php
	ob_start();
	include apply_filters( "adverts_template_load", get_template_directory() . 'wpadverts/form_search.php' );
	return ob_get_clean();
}

	remove_action('adverts_tpl_single_bottom', 'adext_contact_form');
	remove_action('adverts_tpl_single_bottom', 'adverts_single_contact_information');
 
	// add_action('adverts_tpl_single_bottom', 'adext_contact_form_custom');
 
	function adext_contact_form_custom( $post_id ) {
   
		include_once ADVERTS_PATH . 'includes/class-form.php';
		include_once ADVERTS_PATH . 'includes/class-html.php';
		
		$show_form = false;
		$flash = array( "error" => array(), "info" => array());;
		$email = get_post_meta( $post_id, "adverts_email", true );
		$phone = get_post_meta( $post_id, "adverts_phone", true );
		$message = null;
		$form = new Adverts_Form( Adverts::instance()->get( "form_contact_form" ) );
		$buttons = array(
			 array(
				  "tag" => "input",
				  "name" => "adverts_contact_form",
				  "type" => "submit",
				  "value" => __( "Send Message", "adverts" ),
				  "style" => "font-size:1.2em; margin-top:1em",
				  "html" => null
			 ),
		);
		
		if( adverts_request( "adverts_contact_form" ) ) {
			 
			 wp_enqueue_script( 'adverts-contact-form-scroll' );
			 
			 $form->bind( stripslashes_deep( $_POST ) );
			 $valid = $form->validate();
			 
			 if( $valid ) {
				  
				  $reply_to = $form->get_value( "message_email" );
				  
				  if( $form->get_value( "message_name" ) ) {
						$reply_to = $form->get_value( "message_name" ) . "<$reply_to>";
				  }
				  
				  $mail = array(
						"to" => get_post_meta( $post_id, "adverts_email", true ),
						"subject" => $form->get_value( "message_subject" ),
						"message" => $form->get_value( "message_body" ),
						"headers" => array(
							 "Reply-To: " . $reply_to
						)
				  );
				  
				  $mail = apply_filters( "adverts_contact_form_email", $mail, $post_id, $form );
				 
				  add_filter( 'wp_mail_from', 'adext_contact_form_mail_from' );
				  add_filter( 'wp_mail_from_name', 'adext_contact_form_mail_from_name' );
				  
				  wp_mail( $mail["to"], $mail["subject"], $mail["message"], $mail["headers"] );
				  
				  remove_filter( 'wp_mail_from', 'adext_contact_form_mail_from' );
				  remove_filter( 'wp_mail_from_name', 'adext_contact_form_mail_from_name' );
				  
				  $form->bind( array() );
				  
				  $flash["info"][] = array(
						"message" => __( "Your message has been sent.", "adverts" ),
						"icon" => "adverts-icon-ok"
				  );
			 } else {
				  $flash["error"][] = array(
						"message" => __( "There are errors in your form.", "adverts" ),
						"icon" => "adverts-icon-attention-alt"
				  );
				  $show_form = true; 
			 }
		} else {
			 
			 if( get_current_user_id() > 0 ) {
				  $user = wp_get_current_user();
				  /* @var $user WP_User */
				  
				  $bind = array(
						"message_name" => $user->display_name,
						"message_email" => $user->user_email
				  );
				  
				  $form->bind( $bind );
				  
			 }
		}
		
		?>
  
		<div id="adverts-contact-form-scroll"></div>
  
		<?php adverts_flash( $flash ) ?>
  
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="adverts-single-actions">
						<?php if( ! empty( $email ) ): ?>
						<a href="#" class="adverts-button adverts-show-contact-form">
							<?php esc_html_e("Send Message", "adverts") ?>
							<span class="adverts-icon-down-open"></span>
						</a>
						<?php endif; ?>
						
						<?php if( adverts_config( "contact_form.show_phone") == "1" && ! empty( $phone ) ): ?>
						<span class="adverts-button" style="background-color: transparent; cursor: auto">
							<?php esc_html_e( "Phone", "adverts" ) ?>
							<a href="tel:<?php echo esc_html( $phone ) ?>"><?php echo esc_html( $phone ) ?></a>
							<span class="adverts-icon-phone"></span>
						</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
  
		<?php if( ! empty( $email ) ): ?>
		<div class="adverts-contact-box" <?php if($show_form): ?>style="display: block"<?php endif ?>>
			 <?php include apply_filters( "adverts_template_load", ADVERTS_PATH . 'templates/form.php' ) ?>
		</div>
		<?php endif; ?>
  
		<?php
  }
  

// function filter_print() {
// 	global $wp_filter;
// 	echo '<pre>';
// 	print_r( $wp_filter['adverts_tpl_single_bottom'] );
// 	echo '</pre>';
// 	die();
// }
// add_action( 'admin_init', 'filter_print' );