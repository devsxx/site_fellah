<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fellah
 */

?>

<div class="container">
	<div class="row">
		<div class="col-md-12 offset-lg-1 col-lg-10">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>  

				<div class="entry-content">
					<?php the_content(); ?>
				</div> 
 
			</article><!-- #post-<?php the_ID(); ?> -->
		</div>
	</div>
</div>

