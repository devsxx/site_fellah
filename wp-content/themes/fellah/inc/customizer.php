<?php
/**
 * fellah Theme Customizer
 *
 * @package fellah
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fellah_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'fellah_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'fellah_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'fellah_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function fellah_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function fellah_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fellah_customize_preview_js() {
	wp_enqueue_script( 'fellah-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'fellah_customize_preview_js' );




add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
	register_sidebar( array(
		'name' => __( 'qTranslateXWidget', 'theme-slug' ),
		'id' => 'qTranslateXWidget',
		'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}