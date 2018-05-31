<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fellah
 */

?>

	</div><!-- #content -->

<?php get_template_part( 'template-parts/call_to_action' ); ?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-10">
					<div class="site-info">
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'fellah' ) ); ?>">
							<?php printf( esc_html__( 'All rights reserved %d', 'fellah' ), date('Y') ); ?>
						</a>
						<span class="sprt"> - </span>
						<a href="<?php echo esc_url( __( 'https://fellah.ma/', 'fellah' ) ); ?>">Fellah.ma</a>
						<span class="sprt"> | </span>
						<?php $ID = 33;  ?>
						<a href="<?php the_permalink( $ID  ); ?>" class="uppercase"><?php echo get_the_title( $ID ); ?></a>
					</div>
				</div>
				<div class="col-md-2">
					<a href="https://www.facebook.com/FellahAnnonces/" target="_blank" class="facebook">
						<img src="<?php bloginfo( 'template_url' ) ?>/img/icons/facebook.png" alt="">
					</a>
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<a href="#GoToHeader" class="GoToHeader"></a>

<div id="ajaxShadow">
	<div id="ajaxloader"></div>
</div>

<?php  
wp_footer(); ?>

</body>
</html>
