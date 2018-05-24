 
<!-- <p>
    <a href="<?php echo esc_attr($baseurl) ?>" class="adverts-button"><?php _e("Go Back", "adverts") ?></a>
    <a href="<?php echo esc_attr(get_post_permalink( $post_id )) ?>" class="adverts-button"><?php _e("View Ad", "adverts") ?></a>
</p>  -->
       
<?php adverts_flash( $adverts_flash ) ?>
<div class="pub_annonce">
    <form action="" method="post" class="adverts-form adverts-form-update">
        <fieldset>
            
            <?php foreach($form->get_fields( array( "type" => array( "adverts_field_hidden" ) ) ) as $field): ?>
                <?php call_user_func( adverts_field_get_renderer($field), $field) ?>
            <?php endforeach; ?>
            
            <?php foreach($form->get_fields( array( "exclude" => array( "account" ) ) ) as $field): ?>
            
            <div class="adverts-control-group <?php echo esc_attr( str_replace("_", "-", $field["type"] ) . " adverts-field-name-" . $field["name"] ) ?> <?php if(adverts_field_has_errors($field)): ?>adverts-field-error<?php endif; ?>">
                
                <?php if($field["type"] == "adverts_field_header"): ?> 
                    <div class=""> 
                        <span class="adverts-field-header-title"><?php echo esc_html($field["label"]) ?></span> 
                    </div>
                <?php elseif($field["type"] == "adverts_field_checkbox"): ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="<?php echo esc_attr($field["name"]) ?>">
                                    <?php echo esc_html($field["label"]) ?>
                                    <?php if(adverts_field_is_required($field)): ?>
                                        <span class="adverts-form-required">*</span>
                                    <?php endif; ?> 
                                </label>

                                <?php call_user_func( adverts_field_get_renderer($field), $field) ?>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="<?php esc_attr_e($field["name"]) ?>">
                                <?php esc_html_e($field["label"]) ?>
                                <?php if(adverts_field_is_required($field)): ?>
                                <span class="adverts-form-required">*</span>
                                <?php endif; ?>
                            </label> 
                            <?php call_user_func( adverts_field_get_renderer($field), $field) ?> 
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(adverts_field_has_errors($field)): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="adverts-field-error-list">
                                <?php foreach($field["error"] as $k => $v): ?>
                                <li><?php echo esc_html($v) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>

            <?php endforeach; ?>
            
            <div  style="border-top:2px solid silver; padding: 1em 0 1em 0">

                <input type="submit" name="submit" value="<?php _e("Update", "adverts") ?>" style="font-size:1.2em" />
            </div>
            
        </fieldset>
    </form>
</div>
