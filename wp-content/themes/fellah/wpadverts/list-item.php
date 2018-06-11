
<?php $has_image = adverts_request('pics');?>
<?php if( $has_image == 'on' ){ ?>
    <?php $image = adverts_get_main_image( get_the_ID() ) ?>
    <?php if($image): ?>
        <div class="col-md-6 col-lg-3">
            <div class="annoce_container">
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>">
                    
                    <div class="annoce">
                        <?php if($image): ?>
                            <img src="<?php echo esc_attr($image) ?>" alt="" class="advert-item-grow" />
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
                                <?php if(!empty(get_the_terms( get_the_ID(), 'localisation' ))):
                                $advert_localisation = get_the_terms( get_the_ID(), 'localisation' ); ?> 
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
        </div>
    <?php endif; ?>
<?php }else{ ?>
        <div class="col-md-6 col-lg-3">
            <div class="annoce_container">
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>">
                    
                    <div class="annoce">
                        <?php $image = adverts_get_main_image( get_the_ID() ) ?>
                        <?php if($image): ?>
                            <img src="<?php echo esc_attr($image) ?>" alt="" class="advert-item-grow" />
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
                                <?php if(!empty(get_the_terms( get_the_ID(), 'localisation' ))):
                                $advert_localisation = get_the_terms( get_the_ID(), 'localisation' ); ?> 
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
        </div>
<?php } ?>
       
  