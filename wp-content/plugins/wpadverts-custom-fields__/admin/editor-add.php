<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'wpadverts-custom-fields-editor-add' );
wp_enqueue_style( 'adverts-icons' );
wp_enqueue_style( 'adverts-upload' );

$form = Adverts::instance()->get("form");

$data_source = wpadverts_custom_fields_get_data_source();
$callback = array();
foreach( $data_source as $ds ) {
    $callback[$ds["callback"]] = $ds;
}

foreach( $form["field"] as $key => $field ) {
    if( isset( $field["options_callback"] ) && isset( $callback[ $field["options_callback"] ] ) ) {
        $form["field"][$key]["options_callback"] = "";
        $form["field"][$key]["meta"] = array(
            "cf_options_fill_method" => "callback",
            "cf_data_source" => $callback[ $field["options_callback"] ]["name"],
        );
    } elseif( isset( $field["options"]) && ! empty( $field["options"] ) ) {
        $form["field"][$key]["meta"] = array(
            "cf_options_fill_method" => "data",
        );
    }
}

$post = get_post( $id );
if( @unserialize( $post->post_content ) ) {
    $update = unserialize( $post->post_content );
    $form["field"] = $update["field"];
    $form["trash"] = $update["trash"];
    $form["layout"] = "aligned";
    
    if(isset($update["layout"])) {
        $form["layout"] = $update["layout"];
    }
    
}

$fields = array(
    array(
        "type" => "adverts_field_hidden",
        "template_id" => "cf-visual-adverts_field_hidden",
        "callback_template" => "wpadverts_custom_fields_template_field_hidden",
        "is_replicable" => false,
        "label" => __( "Hidden", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
        )
    ),
    array(
        "type" => "adverts_field_header",
        "template_id" => "cf-visual-adverts_field_header",
        "callback_template" => "wpadverts_custom_fields_template_field_header",
        "label" => __( "Header", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "description",
                "callback_template" => "wpadverts_custom_fields_option_description",
                "callback_js" => "wpadverts_custom_fields_js_description"
            ),
        )
    ),
    array(
        "type" => "adverts_field_account",
        "template_id" => "cf-visual-adverts_field_account",
        "callback_template" => "wpadverts_custom_fields_template_field_account",
        "is_replicable" => false,
        "label" => __( "Account", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
        )
    ),
    array(
        "type" => "adverts_field_gallery",
        "template_id" => "cf-visual-adverts_field_gallery",
        "callback_template" => "wpadverts_custom_fields_template_field_gallery",
        "is_replicable" => false,
        "label" => __( "Gallery", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "upload",
                "callback_template" => "wpadverts_custom_fields_option_upload",
                "callback_js" => "wpadverts_custom_fields_js_upload"
            )
        )
    ),
    array(
        "type" => "adverts_field_text",
        "template_id" => "cf-visual-adverts_field_text",
        "callback_template" => "wpadverts_custom_fields_template_field_text",
        "label" => __( "Short Text", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "is_required",
                "callback_template" => "wpadverts_custom_fields_option_is_required",
                "callback_js" => "wpadverts_custom_fields_js_is_required"
            ),
            array(
                "name" => "class",
                "callback_template" => "wpadverts_custom_fields_option_class",
                "callback_js" => "wpadverts_custom_fields_js_class"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "placeholder",
                "callback_template" => "wpadverts_custom_fields_option_placeholder",
                "callback_js" => "wpadverts_custom_fields_js_placeholder"
            ),
            array(
                "name" => "string_length",
                "callback_template" => "wpadverts_custom_fields_option_string_length",
                "callback_js" => "wpadverts_custom_fields_js_string_length"
            ),
            array(
                "name" => "string_validate_as",
                "callback_template" => "wpadverts_custom_fields_option_string_validate_as",
                "callback_js" => "wpadverts_custom_fields_js_string_validate_as"
            ),
            array(
                "name" => "filters",
                "callback_template" => "wpadverts_custom_fields_option_filters",
                "callback_js" => "wpadverts_custom_fields_js_filters"
            ),
            array(
                "name" => "_header_display",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Display Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "display",
                "callback_template" => "wpadverts_custom_fields_option_display",
                "callback_js" => "wpadverts_custom_fields_js_display"
            ),
        )
    ),
    array(
        "type" => "adverts_field_textarea",
        "template_id" => "cf-visual-adverts_field_textarea",
        "callback_template" => "wpadverts_custom_fields_template_field_textarea",
        "label" => __( "Text Area", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name"
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "is_required",
                "callback_template" => "wpadverts_custom_fields_option_is_required",
                "callback_js" => "wpadverts_custom_fields_js_is_required"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "placeholder",
                "callback_template" => "wpadverts_custom_fields_option_placeholder",
                "callback_js" => "wpadverts_custom_fields_js_placeholder"
            ),
            array(
                "name" => "string_length",
                "callback_template" => "wpadverts_custom_fields_option_string_length",
                "callback_js" => "wpadverts_custom_fields_js_string_length"
            ),
            array(
                "name" => "textarea_mode",
                "callback_template" => "wpadverts_custom_fields_option_textarea_mode",
                "callback_js" => "wpadverts_custom_fields_js_textarea_mode"
            ),
            array(
                "name" => "_header_display",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Display Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "display",
                "callback_template" => "wpadverts_custom_fields_option_display",
                "callback_js" => "wpadverts_custom_fields_js_display"
            ),
        )
    ),

    array(
        "type" => "adverts_field_select",
        "template_id" => "cf-visual-adverts_field_select",
        "callback_template" => "wpadverts_custom_fields_template_field_select",
        "uses_options" => true,
        "label" => __( "Dropdown", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "is_required",
                "callback_template" => "wpadverts_custom_fields_option_is_required",
                "callback_js" => "wpadverts_custom_fields_js_is_required"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "max_choices",
                "callback_template" => "wpadverts_custom_fields_option_max_choices",
                "callback_js" => "wpadverts_custom_fields_js_max_choices"
            ),
            array(
                "name" => "empty_option",
                "callback_template" => "wpadverts_custom_fields_option_empty_option",
                "callback_js" => "wpadverts_custom_fields_js_empty_option"
            ),
            array(
                "name" => "multiselect_options",
                "callback_template" => "wpadverts_custom_fields_option_multiselect_options",
                "callback_js" => "wpadverts_custom_fields_js_multiselect_options"
            ),
            array(
                "name" => "_header_display",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Display Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "display",
                "callback_template" => "wpadverts_custom_fields_option_display",
                "callback_js" => "wpadverts_custom_fields_js_display"
            ),
        )
    ),
    array(
        "type" => "adverts_field_checkbox",
        "template_id" => "cf-visual-adverts_field_checkbox",
        "callback_template" => "wpadverts_custom_fields_template_field_checkbox",
        "uses_options" => true,
        "label" => __( "Checkbox", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "is_required",
                "callback_template" => "wpadverts_custom_fields_option_is_required",
                "callback_js" => "wpadverts_custom_fields_js_is_required"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "rows",
                "callback_template" => "wpadverts_custom_fields_option_rows",
                "callback_js" => "wpadverts_custom_fields_js_rows"
            ),
            array(
                "name" => "max_choices",
                "callback_template" => "wpadverts_custom_fields_option_max_choices",
                "callback_js" => "wpadverts_custom_fields_js_max_choices"
            ),
            array(
                "name" => "multiselect_options",
                "callback_template" => "wpadverts_custom_fields_option_multiselect_options",
                "callback_js" => "wpadverts_custom_fields_js_multiselect_options"
            ),
            array(
                "name" => "_header_display",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Display Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "display",
                "callback_template" => "wpadverts_custom_fields_option_display",
                "callback_js" => "wpadverts_custom_fields_js_display"
            ),
        )
    ),
    array(
        "type" => "adverts_field_radio",
        "template_id" => "cf-visual-adverts_field_radio",
        "callback_template" => "wpadverts_custom_fields_template_field_radio",
        "uses_options" => true,
        "label" => __( "Radio", "wpadverts-custom-fields" ),
        "config" => array(
            array(
                "name" => "_header_common",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Common Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "name",
                "callback_template" => "wpadverts_custom_fields_option_name",
                "callback_js" => "wpadverts_custom_fields_js_name",
            ),
            array(
                "name" => "label",
                "callback_template" => "wpadverts_custom_fields_option_label",
                "callback_js" => "wpadverts_custom_fields_js_label"
            ),
            array(
                "name" => "is_required",
                "callback_template" => "wpadverts_custom_fields_option_is_required",
                "callback_js" => "wpadverts_custom_fields_js_is_required"
            ),
            array(
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "rows",
                "callback_template" => "wpadverts_custom_fields_option_rows",
                "callback_js" => "wpadverts_custom_fields_js_rows"
            ),
            array(
                "name" => "multiselect_options",
                "callback_template" => "wpadverts_custom_fields_option_multiselect_options",
                "callback_js" => "wpadverts_custom_fields_js_multiselect_options"
            ),
            array(
                "name" => "_header_display",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Display Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "display",
                "callback_template" => "wpadverts_custom_fields_option_display",
                "callback_js" => "wpadverts_custom_fields_js_display"
            ),
        )
    ),
);

wpadverts_custom_fields_editor($data, $form, $fields, $post);


$icons = array("");
$file = file(ADVERTS_PATH . '/assets/css/adverts-glyphs.css');

foreach($file as $line) {
    if(stripos($line, ".adverts-icon-") === 0) {
        $l = explode(":", $line);
        $icons[] = str_replace(".adverts-icon-", "", $l[0]);
    }
}

$current_icon = "";

?>
    <div id="wpadverts-cf-dialog-select-icon" style="display:none" title="<?php _e("Select Icon", "wpadverts-custom-fields") ?>">
        <input type="text" name="wpadverts-custom-fields-icon-filter" id="wpadverts-custom-fields-icon-filter" value="" placeholder="<?php _e( "Filter Icons ...", "wpadverts-custom_fields") ?>" />
        <ul class="wpadverts-custom-fields-icon-picker">
            <?php foreach($icons as $icon): ?>
            <?php $title = ucfirst(str_replace("-", " ", $icon ) ) ?>
            <li data-name="<?php esc_html_e($icon) ?>">
                <a href="#" class="<?php echo $icon==$current_icon ? 'button-primary' : 'button-secondary' ?>" title="<?php esc_html_e( $title ) ?>" data-name="<?php esc_html_e($icon) ?>">
                    <span class="adverts-icon-<?php esc_html_e($icon) ?>"></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php
