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

			<section>
				<div class="container">

					<div class="row">
						<div class="col-md-12">
							<div class="section_title">
								<div class="div"><?php _e('Catgories','fellah') ?></div>
								<a href="<?php the_permalink( 56 ) ?>" class="toutes_cats">
									<?php _e('Parcourir toutes les catégories', 'fellah'); ?>
								</a>
							</div>
							<div class="section_sousTitle">
								<?php _e('Lorem ipsum dolor sit.','fellah') ?>
							</div>
						</div>
					</div>

					<div class="catgories">
						<div class="row">
							<?php $advert_categories = get_terms("advert_category", array("orderby" => "date", "parent" => 0, 'hide_empty' => false,)); ?>
							
								<?php foreach($advert_categories as $key => $advert_category) :
									$image = get_field('image', $advert_category);
									$color = get_field('bg_color', $advert_category);
								?>
								<div class="col-md-3">
									<a href="<?php echo get_term_link($advert_category); ?>">
									<div class="categorie">
									<img class="img_zoom" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
										<div class="cat_titre">
											<?php echo $advert_category->name; ?>
										</div>
										<div class="hover" style="background-color: <?php echo $color ?>;"></div>
									</div>
									</a>
								</div>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
			</section>
	 
			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="section_title">
								<div class="div"><?php _e('Nouveautés','fellah') ?></div> 
							</div>
							<div class="section_sousTitle">
								<?php _e('Lorem ipsum dolor sit.','fellah') ?>
							</div>
						</div>
					</div>
				</div>

				<div id="annoces_slider" class="annoces_slider owl-carousel owl-theme"> 
					<?php 
					$args =  array( 
						'post_type' => 'advert', 
						'post_status' => 'publish',
						'posts_per_page' => 16,  
						'orderby' => 'date'
				  ); 
				  $loop = new WP_Query( $args );
				  if( $loop->have_posts() ): ?>
				  <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<div class="annoce_container items">
							<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>">
								<?php $image = adverts_get_main_image( get_the_ID() ) ?>
								
								<div class="annoce">
										<?php if($image): ?>
											<img src="<?php echo esc_attr($image) ?>" alt="" class="advert-item-grow" />
										<?php endif; ?>
									<div class="hover"></div>
								</div>

								<div class="info_container">
										<div class="info">
											<div class="date">
												<i class="fa fa-calendar-plus"></i>
												<?php echo date_i18n( get_option( 'date_format' ), get_post_time( 'U', false, get_the_ID() ) ) ?>
											</div>
											<div class="lieu">
												<?php $localisation = get_post_meta( get_the_ID(), "localisation", true ) ?>
												<?php if( ! empty( $localisation ) ): ?>
														<i class="fa fa-map-pin"></i>
														<span><?php echo esc_html( $localisation ) ?></span>
												<?php endif; ?>
												<?php $price = get_post_meta( get_the_ID(), "adverts_price", true ) ?>
											<?php if( $price ): ?>
											<div class=""><?php // echo esc_html( adverts_get_the_price( get_the_ID(), $price ) ) ?></div>
											<?php endif; ?>
											</div>
										</div>
										<div class="titre"> 
											<?php the_title() ?> 
											<?php do_action( "adverts_list_after_title", get_the_ID() ) ?> 
										</div>
										<div class="cats">
											<?php echo get_the_term_list( $post->ID, 'advert_category', '', ', ' ); ?>
										</div>
								</div>
													
							</a>
						</div>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</section>

			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="section_title">
								<div class="div"><?php _e('Top annonces','fellah') ?></div> 
							</div>
							<div class="section_sousTitle">
								<?php _e('Lorem ipsum dolor sit amet consecteteur.','fellah') ?>
							</div>
						</div>
					</div>
				</div>
				<div id="top_annoces_slider" class="annoces_slider owl-carousel owl-theme"> 
					<?php 
					$args =  array( 
						'post_type' => 'advert', 
						'post_status' => 'publish',
						'posts_per_page' => 16,  
						'orderby' => 'date'
				  ); 
				  $loop = new WP_Query( $args );
				  if( $loop->have_posts() ): ?>
				  <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<div class="annoce_container items">
							<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>">
								<?php $image = adverts_get_main_image( get_the_ID() ) ?>
								
								<div class="annoce">
										<?php if($image): ?>
											<img src="<?php echo esc_attr($image) ?>" alt="" class="advert-item-grow" />
										<?php endif; ?>
									<div class="hover"></div>
								</div>

								<div class="info_container">
										<div class="info">
											<div class="date">
												<i class="fa fa-calendar-plus"></i>
												<?php echo date_i18n( get_option( 'date_format' ), get_post_time( 'U', false, get_the_ID() ) ) ?>
											</div>
											<div class="lieu">
												<?php $localisation = get_post_meta( get_the_ID(), "localisation", true ) ?>
												<?php if( ! empty( $localisation ) ): ?>
														<i class="fa fa-map-pin"></i>
														<span><?php echo esc_html( $localisation ) ?></span>
												<?php endif; ?>
												<?php $price = get_post_meta( get_the_ID(), "adverts_price", true ) ?>
											<?php if( $price ): ?>
											<div class=""><?php // echo esc_html( adverts_get_the_price( get_the_ID(), $price ) ) ?></div>
											<?php endif; ?>
											</div>
										</div>
										<div class="titre"> 
											<?php the_title() ?> 
											<?php do_action( "adverts_list_after_title", get_the_ID() ) ?> 
										</div>
										<div class="cats">
											<?php echo get_the_term_list( $post->ID, 'advert_category', '', ', ' ); ?>
										</div>
								</div>
													
							</a>
						</div>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</section>
	
			<section class="home_actualites">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="section_title">
								<?php _e('Actualités de FALLAH', 'fellah'); ?>
								<div class="toutes_cats"></div>
							</div>
							<div class="section_sousTitle"></div>
						</div>
					</div>
					<div class="row"> 
						<?php 
							global $post; 
							$myposts = get_posts(  array('posts_per_page' => 2 ) );
							foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
								<div class="col-md-4"> 
									<div class="actu">
										<a href="<?php the_permalink( ) ?>">
											<div class="bloc">
												<?php if(get_the_post_thumbnail( )): ?>
													<?php the_post_thumbnail( ); ?>
												<?php else: ?>	
													<img src="<?php bloginfo( 'template_url' ) ?>/img/img-actu.jpg" alt="">
												<?php endif; ?>	
												<div class="info"> 
													<div class="titre">
														<?php the_title( ); ?>
													</div>
													<div class="date">
														<?php echo get_the_date( ); ?>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div> 
							<?php endforeach; 
							wp_reset_postdata();?>

						<div class="col-md-4">
							<div class="facebook_box">
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12&appId=1630338777079719&autoLogAppEvents=1';
								fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>

								<div  class="fb-page" data-href="https://www.facebook.com/FellahAnnonces/" 
										data-width="350" data-height="190" data-small-header="true" 
										data-adapt-container-width="true" data-hide-cover="false"
										data-show-facepile="true">
										<blockquote cite="https://www.facebook.com/FellahAnnonces/" class="fb-xfbml-parse-ignore">
												<a href="https://www.facebook.com/FellahAnnonces/">Fellah.ma</a>
										</blockquote>
								</div>
								<br>
							</div>
						</div>
					</div> 
			</section>
	  
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
