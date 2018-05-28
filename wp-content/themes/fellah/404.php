<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package fellah
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container">

			<div class="container">
				<div class="row">
					<div class="col-md-8 offste-md-2">
						<section class="error-404 not-found">
							<header class="page-header">
								<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'fellah' ); ?></h1>
							</header><!-- .page-header --> 
						</section><!-- .error-404 -->
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
