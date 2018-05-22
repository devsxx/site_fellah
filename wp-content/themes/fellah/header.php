<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fellah
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fellah' ); ?></a>

		<header id="masthead" class="site-header">
			<div class="container">
				<div class="row">
					<div class="col-md-2">
						<div class="site-branding">
							<a href="<?php bloginfo( 'url' ) ?>">
								<img src="<?php bloginfo( 'template_url' ) ?>/img/logo.png" alt="Fellah">
							</a>
						</div><!-- .site-branding -->
					</div>
					<div class="col-md-7">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'fellah' ); ?></button>
							<?php
							wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							) );
							?>
						</nav><!-- #site-navigation -->
					</div>
					<div class="col-md-3"> 
						<div class="header_picto_container">
							<div class="header_picto">
								<div class="compte">
									<a href="<?php the_permalink( 2330 ) ?>">
										<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/compte.png" alt="Fellah">
										<span><?php _e('My account','fellah'); ?></span>
									</a>
								</div>
								<div class="compte">
									<a href="<?php the_permalink( 2330 ) ?>">
										<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/contact.png" alt="Fellah">
										<span><?php _e('Contact','fellah'); ?></span>
									</a>
								</div>
								<div class="compte">
									<a href="#">
										<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/follow-us.png" alt="Fellah">
										<span><?php _e('follow-us','fellah'); ?></span>
									</a>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->
		<?php if (is_home()) : ?> 
			<?php echo do_shortcode( "[form_search redirect_to='4']" );  ?> 
		<?php endif; ?>

	<div id="content" class="site-content">
