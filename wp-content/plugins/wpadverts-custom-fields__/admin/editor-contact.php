<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$form = Adverts::instance()->get("form_contact_form");

$post = get_post( $id );
if( @unserialize( $post->post_content ) ) {
    $update = unserialize( $post->post_content );
    $form["field"] = $update["field"];
    $form["trash"] = $update["trash"];
}

$fields = array(
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
        )
    ),
);

wpadverts_custom_fields_editor($data, $form, $fields, $post);


