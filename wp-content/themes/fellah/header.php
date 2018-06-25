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
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />

	<?php wp_head(); ?>
</head>
<body <?php // body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fellah' ); ?></a>

		<header id="masthead" class="site-header">
			<div class="site-header-container">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-lg-2">
							<div class="site-branding">
								<a href="<?php bloginfo( 'url' ) ?>">
									<img src="<?php bloginfo( 'template_url' ) ?>/img/logo.png" alt="Fellah">
								</a>
							</div><!-- .site-branding -->
						</div>
						<div class="col-md-12 col-lg-7">
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
						<div class="col-md-12 col-lg-3"> 
							<div class="header_picto_container">
								<div class="header_picto">
									<?php 
										$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
										$userID = bp_displayed_user_id();
										$userURL = bp_core_get_username($userID);
										$profilPageURL = $_SERVER['SERVER_NAME'].'/oe/fellah/members/'. $userURL . '/'; 
										// echo $profilPageURL;
									?>
									<div class="compte">
										<?php if(is_user_logged_in()){ 
											$current_user = wp_get_current_user(); ?>
											<a href="<?php echo bp_loggedin_user_domain(); ?>" class="active">
												<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/compte.png" class="first" alt="Fellah">
												<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/compte_hover.png" class="second" alt="Fellah">
												<span><?php echo $current_user->user_lastname; ?></span>
											</a>
										<?php }else{ ?> 
											<a href="<?php the_permalink( 2285 ) ?>" class="<?php if ( $profilPageURL == $host ) { ?> active <?php } ?>">
												<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/compte.png" class="first" alt="Fellah">
												<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/compte_hover.png" class="second" alt="Fellah">
												<span><?php _e('My account','fellah'); ?></span>
											</a>
										<?php } ?>
									</div>
									<div class="compte">
										<a href="<?php the_permalink( 2362 ) ?>" class="<?php if ( is_page(2362) ) { ?> active <?php } ?>">
											<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/contact.png" class="first" alt="Fellah">
											<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/contact_hover.png" class="second" alt="Fellah">
											<span><?php _e('Contact','fellah'); ?></span>
										</a>
									</div>
									<div class="compte">
										<a href="https://www.facebook.com/FellahAnnonces/" target="_blank">
											<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/follow-us.png" class="first" alt="Fellah">
											<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/follow-us_hover.png" class="second" alt="Fellah">
											<span><?php _e('Follow-us','fellah'); ?></span>
										</a>
									</div> 
									<div class="compte">
										<div id="selecteur_lang">
											<div id="lang_animate" class="picto langues" >
												<?php if (qtrans_getLanguage()=="ar"): ?>
													<?php $active = 'active_ar'; ?> 
												<?php else: ?>
													<?php $active = 'active_fr'; ?>
												<?php endif; ?> 

												<div class="container_lang">
													<figure class="cube_lang <?php echo $active; ?>">
														<div class="fr"></div>
														<div class="ar"></div> 
													</figure> 
												</div> 

												<?php the_widget('qTranslateXWidget', array('type' => 'dropdown', 'format' => '%n', 'hide-title' => true) ); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->
		
		<?php if (is_home() || is_page( 2264 ) || is_404() || is_post_type_archive('post')) : ?> 
			<?php echo do_shortcode( "[form_search redirect_to='4']" );  ?> 
		<?php endif; ?>

	<div id="content" class="site-content">
