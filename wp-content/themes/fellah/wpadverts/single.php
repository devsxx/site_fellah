<?php
    wp_enqueue_style( 'adverts-frontend' );
    wp_enqueue_style( 'adverts-icons' );
    wp_enqueue_style( 'adverts-icons-animate' );
    wp_enqueue_script( 'adverts-frontend' );
?>

<?php do_action( "adverts_tpl_single_top", $post_id ) ?>

<div class="container">
    <div class="row"> 
 
		<div class="col-md-7"> 
 
            <div class="advert_single_container">
                <div class="advert_info">
                    <div class="advert_date">
                        <i class="fa fa-calendar-plus"></i>
                        <?php printf( __('%1$s', "adverts"), date_i18n( get_option( 'date_format' )  )) ?>
                    </div>

                    <div class="advert_lieu"> 
                        <?php $advert_localisation = get_the_terms( $post_id, 'localisation' );
                        if(!empty($advert_localisation)): ?> 
                        <i class="fa fa-map-pin"></i>
                        <span><?php echo $advert_localisation[0]->name; ?> </span>
                        <?php endif; ?>
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
                            $term = get_term_by("id", $term->parent, "advert_category");
                            if ($term->parent > 0) {
                                $term = get_term_by("id", $term->parent, "advert_category");
                            }
                            $cat_obj = get_term($term->term_id, 'advert_category');
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
                <div class="annonce-row">
                    <span class="name"><?php _e('Phone', 'fellah'); ?></span>
                    <span><?php echo get_post_meta( $post_id, "adverts_phone", true ) ?></span>
                </div>
                <div class="annonce-row">
                    <span class="name"><?php _e('Name', 'fellah'); ?></span>
                    <span><?php echo apply_filters( "adverts_tpl_single_posted_by", sprintf( __("<strong>%s</strong>", "adverts"), get_post_meta($post_id, 'adverts_person', true) ), $post_id ) ?></span>
                </div>
                <?php $localisation = get_the_terms( $post_id, 'localisation' ) ?>
                <?php if(!empty($localisation)): ?>   
                <div class="annonce-row">
                    <span class="name"><?php _e('Region', 'fellah'); ?></span>
                    <span>
                        <?php foreach($localisation as $lc): ?> 
                            <?php echo $lc->name ?>   
                        <?php endforeach; ?>
                    </span>
                </div>  
                <?php endif; ?>      
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
 