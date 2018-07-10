<?php
/**
 * Displays Custom Fields Options Page
 * 
 * This file is a template for wp-admin / Classifieds / Options / Custom Fields panel. 
 * 
 * It is being loaded by wpadverts_custom_fields_page_options function.
 * 
 * @see wpadverts_custom_fields_page_options()
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="wrap">
    <h2 class="">
        <?php _e("Custom Fields", "wpadverts-custom-fields") ?>
        <a class="add-new-h2" href="<?php echo esc_attr( add_query_arg('add', 'new') ) ?>"><?php _e("Add New", "wpadverts-custom-fields") ?></a> </h1>
    </h2>

    <?php adverts_admin_flash() ?>

    <table cellspacing="0" class="widefat post fixed">
        <?php foreach(array("thead", "tfoot") as $tx): ?>
        <<?php echo $tx; ?>>
            <tr>
                <th style="" class="" scope="col"><?php _e("Form", "wpadverts-custom-fields") ?></th>
                <th style="" class="" scope="col"><?php _e("Type", "wpadverts-custom-fields") ?></th>
                <th style="" class="" scope="col"><?php _e("Name", "wpadverts-custom-fields") ?></th>

                <th style="" class="" scope="col"><?php _e("Default", "adverts") ?></th>
            </tr>
        </<?php echo $tx; ?>>
        <?php endforeach; ?>

        <tbody>
            <?php foreach($loop->posts as $i => $item): ?>
            <tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?>  author-self status-publish iedit">
                <td class="">
                    <strong>
                        <a href="<?php esc_attr_e(add_query_arg('edit', $item->ID)) ?>" class=""><?php echo esc_html( $item->post_title ) ?></a>
                    </strong>
                    <div class="row-actions" style="">
                        <span class="edit"><a href="<?php esc_attr_e(add_query_arg('edit', $item->ID)) ?>"><?php _e("Edit Form", "wpadverts-custom-fields") ?></a> | </span>
                        <span class=""><a href="<?php esc_attr_e( add_query_arg( array( "delete" => $item->ID,"noheader" => 1 ) ) ) ?>" title="<?php _e("Delete") ?>" class="adverts-delete"><?php _e("Delete") ?></a> | </span>
                    </div>
                </td>
                <td class="">
                    <?php if($item->post_status == 'wpad-form-add'): ?>
                    <?php _e( "Advert — Create", 'wpadverts-custom-fields' ) ?>
                    <?php elseif($item->post_status == 'wpad-form-search'): ?>
                    <?php _e( "Advert — Search", 'wpadverts-custom-fields' ) ?>
                    <?php elseif($item->post_status == 'wpad-form-contact'): ?>
                    <?php _e( "Advert — Contact", 'wpadverts-custom-fields' ) ?>
                    <?php else: ?>
                    <?php echo apply_filters( 'wpadverts_cf_form_type_label', '—', $item ); ?>
                    <?php endif; ?>
                </td>
                <td class="">
                    <code><?php echo esc_html( $item->post_name ) ?></code>
                </td>
                <td class="">
                    <?php if($item->menu_order > 0): ?>
                    <span class="dashicons dashicons-yes"></span>
                    <?php else: ?>
                    -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
