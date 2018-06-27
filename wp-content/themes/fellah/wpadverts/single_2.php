<?php

$cat = 0;
$exclude_post = $post_id;
$post = get_post( $post_id );

wp_enqueue_style( 'adverts-frontend' );
wp_enqueue_style( 'adverts-icons' );
wp_enqueue_style( 'adverts-icons-animate' );
wp_enqueue_script( 'adverts-frontend' );

?>
<div class="advert_bandeau">
    <?php echo do_shortcode( "[form_search redirect_to='4']" );  ?> 
</div>

<div class="single_advert_slider">
    <div class="container">
        <div class="row"> 
            <div class="col-md-12">
                <?php do_action( "adverts_tpl_single_top", $post_id ) ?>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row"> 

        <div class="col-md-12">
            <!-- start breadcrumbs -->
            <?php the_breadcrumb(); ?>
            <!-- end breadcrumbs -->
        </div>

        <div class="col-md-12 col-lg-12"> 

            <div class="advert_single_container">

                <div class="advert_info">

                    <div class="advert_date">
                        <i class="far fa-calendar-plus"></i>
                        <?php echo get_the_date('j.m.Y'); ?> 
                    </div>

                    <div class="advert_lieu"> 
                        <?php $advert_localisation = get_the_terms( $post_id, 'localisation' );
                        if(!empty($advert_localisation)): ?> 
                            <i class="fas fa-map-pin"></i>
                            <span><?php echo $advert_localisation[0]->name; ?> </span>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="advert_title">
                    <?php echo get_the_title($post_id); ?>
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
 

                <div class="adverts_content">
                    <?php echo $post_content ?>
                </div> 
            </div>
        </div>
    </div>
</div>
 
<?php wp_reset_query(); ?>
