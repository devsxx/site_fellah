<div class="catgories">
    <div class="container">
        <?php if(!empty($terms)): ?>
        <div class="adverts-flexbox adverts-categories-all">
            <?php foreach($terms as $term):
                $image = get_field('image', $term);
                $color = get_field('bg_color', $term); ?>
                <?php $icon = adverts_taxonomy_get("advert_category", $term->term_id, "advert_category_icon", "folder") ?>
                <?php $count = adverts_category_post_count( $term ); ?>
                <div class="<?php echo $columns ?> <?php echo "adverts-category-slug-".$term->slug ?>">
                    <!-- <span class="adverts-flexbox-wrap"> -->
                        <div class="adverts-category-all-main"> 
                            <?php do_action( "adverts_category_pre_title", $term, "small") ?>
                            <a class="" href="<?php echo esc_attr(get_term_link($term)) ?>">
                                <div class="categorie first_cat">
                                    <img class="img_zoom" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                                    <div class="cat_titre">
                                        <?php echo esc_html($term->name) ?> 
                                    </div>
                                    <div class="hover" style="background-color: <?php echo $color ?>;"></div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="adverts-flexbox-list">
                            <?php
                                $subs = get_terms( 'advert_category', array( 
                                    'hide_empty' => 0, 
                                    'parent' => $term->term_id ,
                                    'number' => $sub_count
                                ) );
                            ?>
                        
                            <?php
                            foreach($subs as $sub): 
                                $image_sub = get_field('image', $sub); ?> 

                                <a class="" href="<?php echo esc_attr(get_term_link($sub)) ?>">
                                    <div class="categorie">
                                        <img class="img_zoom" src="<?php echo $image_sub['url'] ?>" alt="<?php echo $image_sub['alt'] ?>">
                                        <div class="cat_titre">
                                            <?php echo esc_html($sub->name) ?> 
                                        </div>
                                        <div class="hover" style="background-color: <?php echo $color ?>;"></div>
                                    </div>
                                </a> 

                            <?php endforeach; ?>
                            
                        </div>
                    <!-- </span> -->
                </div> 
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="adverts-grid-row">
            <div class="adverts-col-100">
                <span><?php _e("No categories found.", "adverts") ?></span>
            </div>
        </div>
        <?php endif; ?> 
    </div>
</div>