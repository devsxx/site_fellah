<div class="actu">
      <div class="bloc">
            <div class="left_bloc">
                  <div class="image">
                  <a href="<?php the_permalink( ) ?>">
                        <?php if( get_the_post_thumbnail( ) ) { ?>  
                        <?php the_post_thumbnail( 'thumbnail', array('class' => 'img_zoom' ) )  ?>
                        <?php }else{ ?>
                        <img src="<?php bloginfo( 'template_url' ) ?>/img/img_blog.jpg" alt="" class="img_zoom">
                        <?php } ?>
                  </a>
                  </div>
            </div>
            <div class="right_bloc">
                  <div class="info">
                        <div class="date">
                              <i class="far fa-calendar-plus"></i>
                              <?php echo get_the_date('j.m.Y'); ?>
                        </div>
                        <div class="titre">
                              <a href="<?php the_permalink(  ) ?>">
                              <?php the_title( )?>
                              </a>
                        </div>
                        <div class="cats">
                              <i class="far fa-folder"></i>
                              <?php echo get_the_term_list( $post->ID, 'category', '', ', ' ); ?>
                        </div>
                        <div class="resume">
                              <?php the_excerpt() ?>
                        </div>
                  </div>
            </div>
      </div>
</div> 