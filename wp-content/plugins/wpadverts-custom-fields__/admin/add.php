<?php
/**
 * Displays WPAdverts Custom Fields - Create Form Page
 * 
 * This file is a template for wp-admin / Classifieds / Options / Custom Fields / Add New panel. 
 * 
 * It is being loaded by _wpadverts_custom_fields_page_add function.
 * 
 * @see _wpadverts_custom_fields_page_add()
 * @since 1.0.0
 */
?>
<div class="wrap">
    <h2 class="">
        <?php _e("Create a New Form", "wpadverts-custom-fields") ?>
         <a class="add-new-h2" href="<?php echo esc_attr( remove_query_arg( 'add' ) ) ?>"><?php _e("Go Back", "wpadverts-custom-fields") ?></a> </h1>
    </h2>

    <?php adverts_admin_flash() ?>

    <?php if( $soft_redirect ): ?>
    
    <script type="text/javascript">
        window.location.href = '<?php echo ($soft_redirect) ?>';
    </script>
    
    <?php else: ?>
    
    <form action="" method="post" class="adverts-form">
        <table class="form-table">
            <tbody>
            <?php echo adverts_form_layout_config($form) ?>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" value="<?php esc_attr_e($button_text) ?>" class="button-primary" name="<?php _e("Submit") ?>" />
        </p>

    </form>
    
    <?php endif; ?>

</div>
