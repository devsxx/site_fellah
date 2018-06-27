<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fellah
 */

get_header();


?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php require 'template-parts/categories.php'; ?>

			<?php require 'template-parts/nouveautes.php'; ?>

			<?php require 'template-parts/top_annonces.php'; ?>

			<?php require 'template-parts/actus_header.php'; ?>
	 
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
