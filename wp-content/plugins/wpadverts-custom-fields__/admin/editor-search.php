<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_script( 'wpadverts-custom-fields-editor-search' );

$form = Adverts::instance()->get("form_search");

$post = get_post( $id );
if( @unserialize( $post->post_content ) ) {
    $update = unserialize( $post->post_content );
    $form["field"] = $update["field"];
    $form["trash"] = $update["trash"];
}

$fields = array(
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
                "name" => "search_type",
                "callback_template" => "wpadverts_custom_fields_option_search_type",
                "callback_js" => "wpadverts_custom_fields_js_search_type"
            ),
            array(
                "name" => "_header_search",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Search", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "cf_search_field",
                "callback_template" => "wpadverts_custom_fields_option_cf_search_field",
                "callback_js" => "wpadverts_custom_fields_js_cf_search_field"
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
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "search_type",
                "callback_template" => "wpadverts_custom_fields_option_search_type",
                "callback_js" => "wpadverts_custom_fields_js_search_type"
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
                "name" => "_header_search",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Search", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "cf_search_field",
                "callback_template" => "wpadverts_custom_fields_option_cf_search_field",
                "callback_js" => "wpadverts_custom_fields_js_cf_search_field"
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
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "search_type",
                "callback_template" => "wpadverts_custom_fields_option_search_type",
                "callback_js" => "wpadverts_custom_fields_js_search_type"
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
                "name" => "_header_search",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Search", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "cf_search_field",
                "callback_template" => "wpadverts_custom_fields_option_cf_search_field",
                "callback_js" => "wpadverts_custom_fields_js_cf_search_field"
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
                "name" => "_header_specific",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Field Specific Settings", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "search_type",
                "callback_template" => "wpadverts_custom_fields_option_search_type",
                "callback_js" => "wpadverts_custom_fields_js_search_type"
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
                "name" => "_header_search",
                "callback_template" => "wpadverts_custom_fields_option_header",
                "label" => __( "Search", "wpadverts-custom-fields" )
            ),
            array(
                "name" => "cf_search_field",
                "callback_template" => "wpadverts_custom_fields_option_cf_search_field",
                "callback_js" => "wpadverts_custom_fields_js_cf_search_field"
            ),
        )
    ),

);

?>
<script type="text/html" id="tmpl-cf-visual-search-separator">
    <div class="inside wpacf-mode-visual wpacf-visual-full wpacf-visual-search-separator" style="">
        <span class="dashicons dashicons-image-flip-vertical"></span>
    </div>
</script>
<?php

wpadverts_custom_fields_editor($data, $form, $fields, $post);

