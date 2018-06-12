<?php 
/* 
 * included by adverts/includes/shortcodes.php shortcodes_adverts_list() 
 * 
 * @var $loop WP_Query
 * @var $query string
 * @var $location string
 * @var $paged int
 */
?>


<?php if( $search_bar == "enabled" ): ?>

<div id="header_fix" class="header_bandeau_content">
    <div class="header_bandeau">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo esc_attr( get_permalink( $redirect_to ) ) ?>" class="adverts-search-form" id="adverts-search-form" method="get">
                        <div class="search_zone">
                            <?php foreach($form->get_fields( array( "type" => array( "adverts_field_hidden" ) ) ) as $field): ?>
                                <?php call_user_func( adverts_field_get_renderer($field), $field) ?>
                            <?php endforeach; ?>
                            
                            <?php if( !empty( $fields_visible ) ): ?>
                            <?php //var_dump($fields_visible); ?>
                            <!-- <div class="adverts-search"> -->
                                <?php foreach( $fields_visible as $field ): ?>
                                <?php if( $field['name'] !='location'){ ?>
                                <div class="advert-input <?php echo esc_attr( $field['adverts_list_classes'] ) ?>">
                                    <?php if( isset( $field["label"] ) && ! empty( $field["label"] ) ): ?>
                                    <span class="adverts-search-input-label"><?php echo esc_html( $field["label"] ) ?></span>
                                    <?php endif; ?>
                                    <?php call_user_func( adverts_field_get_renderer($field), $field) ?>
                                </div>
                                <?php  } ?>
                                <?php endforeach; ?>
                            <!-- </div> -->
                            <?php endif; ?>
                            
                            <?php if( !empty( $fields_hidden ) ): ?>
                            <div class="adverts-search adverts-search-hidden">
                                <?php foreach( $fields_hidden as $field ): ?>
                                <div class="advert-input <?php echo esc_attr( $field['adverts_list_classes'] ) ?>">
                                    <?php if( isset( $field["label"] ) && ! empty( $field["label"] ) ): ?>
                                    <span class="adverts-search-input-label"><?php echo esc_html( $field["label"] ) ?></span>
                                    <?php endif; ?>
                                    <?php call_user_func( adverts_field_get_renderer($field), $field) ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
 
                            <?php if($allow_sorting): ?>
                                <span class="adverts-list-sort-wrap">
                                    <a href="#" class="adverts-button-small adverts-list-sort-button" title="<?php echo esc_attr( $sort_current_title ) ?>">
                                        <span class="adverts-list-sort-label"><?php echo esc_html( $sort_current_text ) ?></span> 
                                        <span class="adverts-icon-sort"></span>
                                    </a>

                                    <div id="adverts-list-sort-options-wrap" class="adverts-multiselect-holder">
                                        <div class="adverts-multiselect-options adverts-list-sort-options">

                                            <?php foreach( $sort_options as $sort_group): ?>
                                                <span class="adverts-list-sort-option-header">
                                                    <strong><?php echo esc_html( $sort_group["label"] ) ?></strong>
                                                </span>
                                                <?php foreach( $sort_group["items"] as $sort_item_key => $sort_item): ?>
                                                    <a href="<?php echo esc_html( add_query_arg( "adverts_sort", $sort_item_key ) ) ?>" class="adverts-list-sort-option">
                                                        <?php echo esc_html( $sort_item ) ?>
                                                        <?php if($adverts_sort==$sort_item_key): ?><span class="adverts-icon-asterisk" style="opacity:0.5"></span><?php endif; ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                    

                                        </div>
                                    </div>
                                </span> 
                            <?php endif; ?> 

                            <div class="adverts-js">
                                <?php if( !empty( $fields_hidden ) ): ?>
                                <a href="#" class="adverts-form-filters adverts-button-small"><span><?php _e("Advanced Search", "adverts") ?> <span class="adverts-advanced-search-icon adverts-icon-down-open"></a>
                                <?php endif; ?>
                                <a href="#" class="adverts-form-submit adverts-button-small"><?php _e("Search", "fellah") ?> <span class="adverts-icon-search"><span></a>
                            </div>

                            <div class="adverts-options-fallback adverts-no-js">
                                <input type="submit" value="<?php _e("Filter Results", "adverts") ?>" />
                            </div>

                            <div class="custom_sorting">
                                <div class="custom_sorting_container">
                                    <div class="custom_sorting_titre">
                                        <?php _e('Sort by: ','fellah'); ?>
                                    </div>

                                    <div class="budget-range-container"> 
                                        <div class="budget-range">
                                            <p id="amount-LCD"></p>
                                            <input type="hidden" id="input-amount-LCD" name="price" readonly>
                                            <div id="slider-range-LCD"></div>
                                        </div>
                                    </div>


                                    <div class="pics-container"> 
                                        <div class="checkbox_pics">
                                            <label for="pics" <?php echo ( adverts_request('pics') != null && adverts_request('pics') == 'on') ? 'class="checked"' : '' ; ?>>
                                                <input type="checkbox" name="pics" id="pics" <?php echo ( adverts_request('pics') != null && adverts_request('pics') == 'on') ? 'checked' : '' ; ?> >
                                                <?php _e('Pics','fellah'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php  
                                if( adverts_request('pics') != null || adverts_request('price') != null ){ ?>
                                    <div class="decocher_filtres">
                                        <a href="<?php the_permalink( 4 ); ?>"> <?php _e('Décocher les filtres', 'fellah'); ?> <i class="fas fa-times"></i></a>
                                    </div>
                                <?php }?>

                            </div>

                        </div>
                    </form>
                </div> 
            </div>
        </div>
        

    </div>
</div>
<?php endif; ?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
        
            <?php the_breadcrumb(); ?>
            <?php  
            if(isset($_GET['advert_category'])){
                $term = get_term($_GET['advert_category'][0] , 'advert_category' ); ?>
                <h3>
                <?php echo $term->name; ?>
                <?php 
                if( isset($_GET['location']) ) printf( __( " in %s", "fellah"),  $_GET['location'] ); ?> 
                </h3>
                <p><?php echo $term->description; ?> </p>  
            <?php }else{ ?>
                <?php do_action( "adverts_sh_list_before", $params ) ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php if( $show_results ): ?>
    <div class="adverts-list adverts-bg-hover">
        <?php if( $loop->have_posts() ): ?>
        <div class="container">
            <div class="row">
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php include apply_filters( "adverts_template_load", ADVERTS_PATH . 'templates/list-item.php' ) ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php else: ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="adverts-list-empty"><em><?php _e("There are no ads matching your search criteria.", "adverts") ?></em></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php wp_reset_query(); ?>
    </div>


    <?php if( $show_pagination ): ?>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
            <div class="adverts-pagination">
                    <?php echo paginate_links( array(
                        'base' => $paginate_base,
                        'format' => $paginate_format,
                        'current' => max( 1, $paged ),
                        'total' => $loop->max_num_pages,
                        'prev_next' => false
                    ) ); ?>
                </div>
            </div>
       </div>
   </div>
    <?php endif; ?>

<?php endif; ?>

