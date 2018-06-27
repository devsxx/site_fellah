<?php include apply_filters( "adverts_template_load", ADVERTS_PATH . 'templates/single_2.php' ); ?>
 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <form action="" method="post" style="display:inline">
                <input type="hidden" name="_adverts_action" value="" />
                <input type="hidden" name="_post_id" id="_post_id" value="<?php echo esc_attr($post_id) ?>" />
                <input type="submit" value="<?php _e("Edit ad", "fellah") ?>" class="adverts-cancel-unload" />
            </form>

            <form action="" method="post" style="display:inline">
                <input type="hidden" name="_adverts_action" value="save" />
                <input type="hidden" name="_post_id" id="_post_id" value="<?php echo esc_attr($post_id) ?>" />
                <input type="submit" value="<?php _e("Publish ad", "fellah") ?>" class="adverts-cancel-unload" />
            </form>
            
        </div>
    </div>
</div>
