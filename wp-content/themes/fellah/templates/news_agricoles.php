<?php 
/* Template Name: News agricoles */

get_header();
?>

<div id="primary" class="content-area">
      <main id="main" class="site-main">

            <div class="container">
                  <div class="row">
                  
                        <div class="col-md-12">
                              <!-- start breadcrumbs -->
                              <?php the_breadcrumb(); ?>
                              <!-- end breadcrumbs -->
                        </div>
                        <div class="col-md-8">
                              <div class="page_blog">
                                    <div class="page_titre"><?php _e('Actualités', 'fellah'); ?></div>
                                    <?php
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
                                    $args = array( 
                                          'post_type' => 'post',
                                          'order' => 'DESC',
                                          'orderby' => 'date', 
                                          'paged' => $paged
                                    );  
                                    $the_query = new WP_Query( $args ); 
                                    ?>
                                    <?php if ( $the_query->have_posts() ) : 
                                          while ( $the_query->have_posts() ) : $the_query->the_post(); 
                                                $date = get_the_date(); 
                                                get_template_part('template-parts/actus');
                                          endwhile;
                                          
                                          if ( $the_query->found_posts > 6):  
                                          wp_pagenavi( 
                                                array( 
                                                'options' => PageNavi_Core::$options->get_defaults(),
                                                'query' => $the_query
                                                )
                                                ); 
                                                
                                          endif;
                                          wp_reset_query(); ?> 

                                    <?php else:  ?>
                                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                                    <?php endif; ?>
                              </div>
                        </div>

                        <div class="col-md-4">
				      <?php get_template_part( 'template-parts/single','side' ) ?>
                        </div>

                  </div>
            </div>
            
      </main><!-- #main -->
</div><!-- #primary -->

<?php 
get_footer();
