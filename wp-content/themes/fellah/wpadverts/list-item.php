<div class="annoce_container">
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
                    <i class="far fa-calendar-plus"></i>
                    <?php echo date_i18n( get_option( 'date_format' ), get_post_time( 'U', false, get_the_ID() ) ) ?>
                </div>
                <div class="lieu">
                    <?php $localisation = get_post_meta( get_the_ID(), "localisation", true ) ?>
                    <?php if( ! empty( $localisation ) ): ?>
                        <i class="fas fa-map-pin"></i>
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
       
  