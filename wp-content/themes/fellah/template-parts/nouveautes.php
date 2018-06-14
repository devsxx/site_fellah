<section>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="section_title">
								<div class="div"><?php _e('Nouveautés','fellah') ?></div> 
							</div>
							<div class="section_sousTitle">
								<?php _e('Découvrez toutes les dernières annonces','fellah') ?>
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
										<?php 
										if($image): ?>
											<img src="<?php echo esc_attr($image) ?>" alt="" class="advert-item-grow" />
										<?php else: 
										
										$terms = get_the_terms( get_the_ID(), 'advert_category' );
										if ($terms ){
											foreach ( $terms as $term ) { 
												$color = get_field('bg_color', $term);
												$image = get_field('image', $term);
												if($term->parent == 0){
													echo $term->parent;
													?>
													<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
													<div class="hover_2" style="background-color: <?php echo $color; ?>;"></div>
													<?php 
													break; 
												}
											} 
										} ?>

										<?php endif; ?>
									<div class="hover"></div>
								</div>

								<div class="info_container">
										<div class="info">
											<div class="date">
												<!-- <i class="far fa-calendar-plus"></i> -->
												<?php // echo get_the_date('j.m.Y'); ?>
												<?php $price = get_post_meta( get_the_ID(), "adverts_price", true ) ?>
												<?php if( $price ): ?>
													<div class=""><?php echo esc_html( adverts_get_the_price( get_the_ID(), $price ) ) ?></div>
												<?php endif; ?>
											</div>
											<div class="lieu">
												 <?php 
												if(!empty(get_the_terms( get_the_ID(), 'localisation' ))):
                                    $advert_localisation = get_the_terms( get_the_ID(), 'localisation' );
												?> 
                                       <i class="fas fa-map-pin"></i>
                                       <span><?php echo $advert_localisation[0]->name; ?> </span>
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