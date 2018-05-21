<?php

    $cat = 0;
    $exclude_post = $post_id;

    wp_enqueue_style( 'adverts-frontend' );
    wp_enqueue_style( 'adverts-icons' );
    wp_enqueue_style( 'adverts-icons-animate' );
    wp_enqueue_script( 'adverts-frontend' );

?>

<?php do_action( "adverts_tpl_single_top", $post_id ) ?>

<div class="container">
    <div class="row"> 
    
        <div class="col-md-12">
            <!-- start breadcrumbs -->
                <?php the_breadcrumb(); ?>
            <!-- end breadcrumbs -->
        </div>

		<div class="col-md-7"> 
 
            <div class="advert_single_container">
               
                <div class="advert_info">

                    <div class="advert_date">
                        <i class="far fa-calendar-plus"></i>
                        <?php printf( __('%1$s', "adverts"), date_i18n( get_option( 'date_format' )  )) ?>
                    </div>

                    <div class="advert_lieu"> 
                        <?php $advert_localisation = get_the_terms( $post_id, 'localisation' );
                        if(!empty($advert_localisation)): ?> 
                        <i class="fas fa-map-pin"></i>
                        <span><?php echo $advert_localisation[0]->name; ?> </span>
                        <?php endif; ?>
                    </div>

                    <div class="advert_share">
                        <?php 
                            $shareURL = urlencode(get_permalink()); 
                            $shareTitle = str_replace( ' ', '%20', get_the_title());
                        ?>
                        <a class="btn btn-facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$shareURL" target="_blank" data-network="facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a class="btn btn-twitter" href="https://twitter.com/intent/tweet?text='.$shareTitle.'&amp;url='.$shareURL.'&amp;via=share" target="_blank" data-network="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a class="btn btn-googleplus" href="https://plus.google.com/share?url='.$shareURL" target="_blank" data-network="google"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a>
                        <a class="btn btn-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url='.$shareURL.'&amp;title='.$shareTitle" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a> 
                    </div>

                </div>

                <div class="advert_title">
                    <?php the_title() ?>
                </div>

                <div class="advert_category">
                    <?php 
                    $advert_category = get_the_terms( $post_id, 'advert_category' );
                    if($advert_category) {
                        foreach( $advert_category as $term ) { 
                            if ( isset($term->parent) && $term->parent > 0) {
                                $term = get_term_by("id", $term->parent, "advert_category");
                            }
                             
                            $cat_obj = get_term($term->term_id, 'advert_category');
                            $cat = $term->term_id; 
                            $cat_name = $cat_obj->name; 
                        }
                    }
                    if(!empty($advert_category)): ?> 
                       <?php echo $cat_name ?>
                    <?php endif; ?>
                    
                </div>

            </div> 

            <div class="adverts_content">
                <?php echo $post_content ?>
            </div> 
		</div>
        
		<div class="col-md-5">  
            <div class="annonce_detail_side">

                <?php if( get_post_meta( $post_id, "adverts_price", true) ): ?>
                    <div class="annonce-row">
                        <span class="name"><?php _e('Price', 'fellah'); ?></span><span class="annonce-price-box"><?php echo esc_html( adverts_get_the_price( $post_id ) ) ?></span>
                    </div>
                <?php endif; ?> 

                <?php if( get_post_meta( $post_id, "adverts_phone", true) ): ?>
                    <div class="annonce-row">
                        <span class="name"><?php _e('Phone', 'fellah'); ?></span>
                        <span><?php echo get_post_meta( $post_id, "adverts_phone", true ) ?></span>
                    </div>
                <?php endif; ?> 

                <?php if(!empty(get_the_terms( $post_id, 'localisation' ))): ?>   
                    <?php $localisation = get_the_terms( $post_id, 'localisation' ) ?>
                    <div class="annonce-row">
                        <span class="name"><?php _e('Region', 'fellah'); ?></span>
                        <span>
                            <?php foreach($localisation as $lc): ?> 
                                <?php echo $lc->name ?>   
                            <?php endforeach; ?>
                        </span>
                    </div>  
                <?php endif; ?>      
                
                <div class="annonce-row">
                    <span class="name"><?php _e('Name', 'fellah'); ?></span> 
                    <span class="author"><?php the_author(); ?></span>
                </div>
                 
                <?php set_get_PostViews($post_id); ?>

                <?php //do_action( "adverts_tpl_single_details", $post_id ) ?>
           </div>
        </div> 

    </div>
</div>

<div class="contacter_annonceur">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <?php do_action( "adverts_tpl_single_bottom", $post_id ) ?>
            </div>
        </div>
    </div>
</div>

<?php 
    wp_reset_query();
    next_posts_link( 'Older Entries' );
    previous_posts_link( 'Newer Entries' );
?>

<section>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section_title">
                    <div class="div"><?php _e('Annonces similaires','fellah') ?></div> 
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
            'post_type'         => 'advert', 
            'post_status'       => 'publish',
            'posts_per_page'    => 16,  
            'orderby'           => 'date',
            // 'cat'               => $cat,
            'post__not_in'      => array($exclude_post) 
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
                                        <i class="far fa-calendar-plus"></i>
                                        <?php echo date_i18n( get_option( 'date_format' ), get_post_time( 'U', false, get_the_ID() ) ) ?>
                                    </div>
                                    <div class="lieu">
                                        <?php 
                                        if(!empty(get_the_terms( get_the_ID(), 'localisation' ))):
                                        $advert_localisation = get_the_terms( get_the_ID(), 'localisation' );
                                        ?> 
                                            <i class="fas fa-map-pin"></i>
                                            <span> 
                                                <?php echo $advert_localisation[0]->name; ?> 
                                            </span>
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
                                    <?php echo get_the_term_list( get_the_ID(), 'advert_category', '', ', ' ); ?>
                                </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>
        
    </div>

</section>