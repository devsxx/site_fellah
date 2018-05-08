<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function wpadverts_custom_fields_get_unique_metas() {
    $metas = array();
    $forms = new WP_Query(array(
        'post_type' => 'wpadverts-form', 
        'post_status' => 'wpad-form-add',
        'orderby' => array( 'menu_order' => 'DESC' ),
        'posts_per_page' => -1
    ));
    
    foreach( $forms->posts as $form ) {
        $form_scheme = unserialize( $form->post_content );
        foreach( $form_scheme["field"] as $f ) {
            
            if( $f["type"] == "adverts_field_header" ) {
                continue;
            }
            
            if( isset( $f["meta"]["cf_builtin"] ) && ! $f["meta"]["cf_builtin"] ) {
                $metas[$f["name"]] = array(
                    "name" => $f["name"],
                    "label" => $f["label"]
                );
            }
        }
    }
    

    return $metas;
}

function wpadverts_custom_fields_editor( $data, $form, $fields, $post ) {

    ?>

 
    <div id="wpadverts-cf-dialog-pre-save" style="display:none" title="<?php _e("Cannot save (yet)", "wpadverts-custom-fields") ?>">
        <p><?php _e("'Update' or 'Cancel' all fields edition before saving the form.", "wpadverts-custom-fields") ?></p>
    </div>

    <div id="wpadverts-cf-dialog-delete-field" style="display:none" title="<?php _e("Permanently delete field?", "wpadverts-custom-fields") ?>">
        <p><?php _e("Field <strong></strong> will be permanently deleted and cannot be recovered. Are you sure?", "wpadverts-custom-fields") ?></p>
    </div>

    <div id="wpadverts-cf-dialog-delete" style="display:none" title="<?php _e("Permanently delete form?", "wpadverts-custom-fields") ?>">
        <p><?php _e("Form will be permanently deleted and cannot be recovered. Are you sure?", "wpadverts-custom-fields") ?></p>
    </div>

    <div class="wrap">
        <h2 class="">
            <?php _e("Custom Fields", "wpadverts-custom-fields") ?>
            <a class="add-new-h2" href="<?php echo esc_attr( remove_query_arg( 'edit' ) ) ?>"><?php _e("Go Back", "wpadverts-custom-fields") ?></a> 
        </h2>

        <div id="wpadverts-custom-fields-wrap" class="<?php echo esc_html($data["class"]) ?>">
            <div id="wpadverts-custom-fields" class="metabox-holder">
                <div id="postbox-container-1" class="postbox-container">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                        <!-- START Custom Fields Editor -->
                        <div id="wpadverts-custom-fields-editor" class="postbox ">

                        </div>
                        <!-- END -->

                    </div>	
                </div>

                <div id="postbox-container-2" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">

                        <div id="submitdiv" class="postbox ">
                            <h2 class="hndle ui-sortable-handle"><span><?php _e( "Form", "wpadverts-custom-fields" ) ?></span></h2>
                            <div class="inside" style="margin:0; padding: 0">
                                <div class="submitbox adverts-ph-edit-sidebar" id="submitpost">

                                    <div id="minor-publishing">

                                        <div id="misc-publishing-actions">

                                        <!-- .misc-pub-section -->

                                            <div class="inside">
                                                <div class="">
                                                    <p>
                                                        <span class="label"><strong><?php _e( "Title", "wpadverts-custom-fields" ) ?></strong></span>&nbsp;
                                                        <span>
                                                            
                                                        <?php echo esc_html( $post->post_title ) ?> -
                                                            
                                                        <?php if($post->post_status == 'wpad-form-add'): ?>
                                                        <?php _e( "Create Ad", 'wpadverts-custom-fields' ) ?>
                                                        <?php elseif($post->post_status == 'wpad-form-search'): ?>
                                                        <?php _e( "Search", 'wpadverts-custom-fields' ) ?>
                                                        <?php elseif($post->post_status == 'wpad-form-contact'): ?>
                                                        <?php _e( "Contact", 'wpadverts-custom-fields' ) ?>
                                                        <?php else: ?>
                                                        <?php endif; ?>
                                                        </span>
                                                    </p>
                                                </div>

                                                <div class="">
                                                    <p>
                                                        <span class="label"><strong><?php _e( "Name", "wpadverts-custom-fields" ) ?></strong></span>&nbsp;
                                                        <span><code><?php echo esc_html( $post->post_name ) ?></code></span>
                                                    </p>
                                                </div>
                                                
                                                <div class="">
                                                    <p>
                                                        <span class="label"><strong><?php _e( "Default", "wpadverts-custom-fields" ) ?></strong></span>&nbsp;
                                                        <span>
                                                            <input type="checkbox" name="is_default" id="wpadverts-cf-is-default" value="1" <?php checked($post->menu_order) ?> />
                                                            <label for="wpadverts-cf-is-default"><?php _e( "Automatically apply this scheme.", "wpadverts-custom-fields") ?></label>
                                                        </span>
                                                    </p>
                                                </div>
                                                
                                                <?php if(in_array($post->post_status, array('wpad-form-add', 'wpad-form-contact'))): ?>
                                                <?php $form_layout = isset($form["layout"]) ? $form["layout"] : "aligned"; ?>
                                                <div class="wpadverts-cf-uses-from-layout">
                                                    <p>
                                                        <span class="label"><strong><?php _e( "Form Layout", "wpadverts-custom-fields" ) ?></strong></span>&nbsp;
                                                        <span>
                                                            <label for="wpadverts-cf-form-layout-aligned">
                                                                <input type="radio" name="form_layout" id="wpadverts-cf-form-layout-aligned" value="aligned" <?php checked($form_layout, "aligned") ?> />
                                                                <?php _e("Aligned", "wpadverts-custom-fields") ?>
                                                            </label>
                                                            &nbsp;
                                                            <label for="wpadverts-cf-form-layout-stacked">
                                                                <input type="radio" name="form_layout" id="wpadverts-cf-form-layout-stacked" value="stacked" <?php checked($form_layout, "stacked") ?> />
                                                                <?php _e("Stacked", "wpadverts-custom-fields") ?>
                                                            </label>
                                                            
                                                        </span>
                                                    </p>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <div class="wpadverts-cf-save-error">
                                                    <p>
                                                        <span></span>
                                                    </p>
                                                </div>
                                                
                                            </div>


                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                    <div id="major-publishing-actions">
                                        <div id="delete-action">
                                            <a class="submitdelete deletion wpadverts-cf-from-delete" href="<?php echo esc_url( add_query_arg( array( "edit" => null, "delete" => adverts_request( "edit" ), "noheader"=>"1")) ) ?>"><?php _e("Delete") ?></a>
                                        </div>

                                        <div id="publishing-action">
                                            <span class="wpadverts-custom-fields-save-ok dashicons dashicons-yes"></span>
                                            <span class="wpadverts-custom-fields-save-spinner spinner"></span>
                                            
                                            <input name="save" type="submit" class="button button-primary button-large" id="wpadverts-custom-fields-save" value="<?php _e("Update", "wpadverts-custom-fields") ?>" data-form-id="<?php echo $data["scheme"]->ID ?>">
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle"><span><?php _e( "Basic Fields", "wpadverts-custom-fields" ) ?></span></h2>
                            <div class="inside" >
                                <ul id="wpadverts-custom-fields-basic-fields"></ul>
                            </div>
                        </div>

                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle"><span><?php _e( "Trash", "wpadverts-custom-fields" ) ?></span></h2>
                            <div class="inside" id="wpadverts-custom-fields-trash">

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <?php

    foreach( $fields as $field ) {
        call_user_func( $field["callback_template"], $field );
    }

    ?>

    <script type="text/javascript">
    var _WPADVERTS_CF_NONCE = "<?php echo wp_create_nonce( "wpadverts-custom-fields" ); ?>";
    var _WPADVERTS_CF_FORM = <?php echo wp_json_encode( $form ) ?>;    
    var _WPADVERTS_CF_FIELDS = <?php echo wp_json_encode( $fields ) ?>;

    var _WPADVERTS_CF_VALIDATE = { };
    <?php foreach( $fields as $field ): ?>
    _WPADVERTS_CF_VALIDATE.<?php echo $field["type"] ?> = [];
    <?php endforeach; ?>

    var _WPADVERTS_CF_CALLBACK = { };
    <?php foreach( $fields as $field ): ?>
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?> = [];
    <?php endforeach; ?>
    </script>

    <?php 
        foreach( $fields as $field ) {
            foreach( $field["config"] as $config ) {
                if( isset($config["callback_js"]) && is_callable($config["callback_js"]) ) {
                    call_user_func( $config["callback_js"], $field );
                }
            }
        }


    ?>

    <script type="text/html" id="tmpl-cf-field-icon">
        <li class="wpadverts-custom-fields-input-template" data-field="{{ data.type }}" data-name="{{ data.name }}">
            <span class="button-large button">
                <strong>{{ data.label }}</strong>
                <# if( data.name ) { #>
                ({{ data.name }})

                <# if( ! data.builtin ) { #>
                <a href="#" class="wpadverts-cf-field-delete dashicons dashicons-trash"></a>
                <# } #>

                <# } #>
            </span>
        </li>
    </script>

    <?php
}

function wpadverts_custom_fields_option_header($config) {
    ?>
    <div class="wpacf-config-fieldset">
        <span class="wpacf-config-legend">
            <span class="dashicons dashicons-arrow-down-alt2"></span>
            <?php echo $config["label"] ?>
        </span>
    </div>

    <hr/>
    <?php
}

function wpadverts_custom_fields_option_name() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Field Name", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="name" value="{{ data.name }}" <# if( field.getMeta( "cf_saved" ) == "1" || field.getMeta( "cf_builtin" ) == "1" ) { #>readonly="readonly"<# } #> />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_description() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Description", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="description" value="{{ data.description }}" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_class() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "CSS Class", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="class" value="{{ data.class }}" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_label() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Field Label", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="label" value="{{ data.label }}" />
        </div>
    </div>
    <?php
}
    
function wpadverts_custom_fields_option_is_required() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label">
            <?php _e("Required", "wpadverts-custom-fields") ?>
        </label>
        <div class="wpacf-config-input">
            <input type="checkbox" name="is_required" value="1" {{ HTML.checked(field.hasValidator("is_required")) }} />
        </div>
    </div>
    <?php
}
    
function wpadverts_custom_fields_option_cf_visibility() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Visibility", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <# var v = field.getMeta("cf_visibility") #>
            <label><input type="radio" name="cf_visibility" value="anyone" {{ HTML.checked( v == "anyone" || v == "" ) }} /><?php _e("Anyone", "wpadverts-custom-fields") ?> </label> &nbsp;
            <label><input type="radio" name="cf_visibility" value="forms-only" {{ HTML.checked( v == "forms-only" ) }} /><?php _e("Forms Only", "wpadverts-custom-fields") ?> </label> &nbsp;
            <label><input type="radio" name="cf_visibility" value="admin-only" {{ HTML.checked( v == "admin-only" ) }} /><?php _e("Admin Only", "wpadverts-custom-fields") ?> </label> &nbsp;
        </div>
    </div>
    <?php
}
    
function wpadverts_custom_fields_option_placeholder() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Placeholder", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="placeholder" value="{{ data.placeholder }}" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_string_length() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Length", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">

            <input type="text" name="string_lenth_min" placeholder="<?php _e("Min.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("string_length", "min") }}" style="width:105px" />
            <input type="text" name="string_lenth_max" placeholder="<?php _e("Max.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("string_length", "max") }}" style="width:105px" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_string_validate_as() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Validate As", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <select name="string_validate_as">
                <option value=""><?php _e("None", "wpadverts-custom-fields") ?></option>
                <option value="is_email" {{ HTML.selected( field.hasValidator("is_email" ) ) }}><?php _e("Email", "wpadverts-custom-fields") ?></option>
                <option value="is_url" {{ HTML.selected( field.hasValidator("is_url" ) ) }}><?php _e("URL", "wpadverts-custom-fields") ?></option>
                <option value="is_number" {{ HTML.selected( field.hasValidator("is_number" ) ) }}><?php _e("Number", "wpadverts-custom-fields") ?></option>
                <option value="is_integer" {{ HTML.selected( field.hasValidator("is_integer" ) ) }}><?php _e("Integer", "wpadverts-custom-fields") ?></option>
            </select>
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_textarea_mode() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Type", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">{{ data.mode }}
            <label><input type="radio" name="mode" value="plain-text" {{ HTML.checked( data.mode == "plain-text" || ! data.mode ) }} /><?php _e("Plain Text", "wpadverts-custom-fields") ?> </label> &nbsp;
            <label><input type="radio" name="mode" value="tinymce-mini" {{ HTML.checked( data.mode == "tinymce-mini" ) }} /><?php _e("Editor", "wpadverts-custom-fields") ?> </label> &nbsp;
            <label><input type="radio" name="mode" value="tinymice-full" {{ HTML.checked( data.mode == "tinymice-full" ) }} /><?php _e("Full Editor", "wpadverts-custom-fields") ?> </label> &nbsp;
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_filters() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Filters", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            
            <?php foreach( Adverts::instance()->get("field_filter") as $filter_name => $filter ): ?>
            <label><input type="checkbox" name="filters" value="<?php echo esc_html( $filter_name ) ?>" {{ HTML.checked( field.hasFilter( "<?php echo esc_html( $filter_name ) ?>" ) ) }} /> <?php echo esc_html( $filter["description"] ) ?> </label><br/>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_search_type() {
    ?>
    <# var v = field.getMeta("search_type") #>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Field Width", "wpadverts-custom-fields") ?></label>
        <div class="wpacf-config-input">
            <label><input type="radio" name="search_type" value="half" {{ HTML.checked( v == "half" ) }} /><?php _e("50%", "wpadverts-custom-fields") ?> </label> &nbsp;
            <label><input type="radio" name="search_type" value="full" {{ HTML.checked( v == "full" ) }} /><?php _e("100%", "wpadverts-custom-fields") ?> </label> &nbsp;
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_display() {
    ?>
    
    <# if( data.meta.cf_builtin ) { #>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Display", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <?php _e("Cannot modify display options for builtin fields.", "wpadverts-custom-fields") ?>
        </div>
    </div>
    <# } else { #>
    
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Display", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <select name="cf_display">
                <option value="anywhere" {{ HTML.selected( field.getMeta("cf_display" ) == "anywhere" ) }}><?php _e("Forms and Ad details page.", "wpadverts-custom-fields") ?></option>
                <option value="forms-only" {{ HTML.selected( field.getMeta("cf_display" ) == "forms-only" ) }}><?php _e("Forms only", "wpadverts-custom-fields") ?></option>
                <option value="admin-only" {{ HTML.selected( field.getMeta("cf_display" ) == "admin-only" ) }}><?php _e("Admin only", "wpadverts-custom-fields") ?></option>
            </select>
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-field-display-type">
        <label class="wpacf-config-label"><?php _e("Display Type", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <# var cf_display_type = field.getMeta("cf_display_type") #>
            <label for="cf_display_type_table_row"><input type="radio" id="cf_display_type_table_row" name="cf_display_type" value="table-row" {{ HTML.checked( cf_display_type == "" || cf_display_type == "table-row" ) }} /><?php _e("Table Row", "wpadverts-custom-fields") ?></label>
            <label for="cf_display_type_full_width"><input type="radio" id="cf_display_type_full_width" name="cf_display_type" value="full-width" {{ HTML.checked( cf_display_type == "full-width" ) }} /><?php _e("Full Width", "wpadverts-custom-fields") ?></label>
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-field-display-as">
        <label class="wpacf-config-label"><?php _e("Display As", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <select name="cf_display_as">
                <option value="text" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "text" ) }}><?php _e("Text", "wpadverts-custom-fields") ?></option>
                <option value="html" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "html" ) }}><?php _e("HTML", "wpadverts-custom-fields") ?></option>
                <option value="url" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "url" ) }}><?php _e("URL", "wpadverts-custom-fields") ?></option>
                <option value="image" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "image" ) }}><?php _e("Image", "wpadverts-custom-fields") ?></option>
                <option value="audio" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "audio" ) }}><?php _e("Audio", "wpadverts-custom-fields") ?></option>
                <option value="video" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "video" ) }}><?php _e("Video", "wpadverts-custom-fields") ?></option>
                <option value="oembed" {{ HTML.selected( field.getMeta( "cf_display_as" ) == "oembed" ) }}><?php _e("oEmbed", "wpadverts-custom-fields") ?></option>
            </select>
        </div>
    </div>
    
    <# if( field.conf.uses_options ) { #>
    <div class="wpacf-config-field wpacf-field-display-style">
        <label class="wpacf-config-label"><?php _e("Display Style", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <select name="cf_display_style">
                <option value="inline-coma" {{ HTML.selected( field.getMeta( "cf_display_style" ) == "inline-coma" ) }}><?php _e("Inline - separated by coma", "wpadverts-custom-fields") ?></option>
                <option value="inline-none" {{ HTML.selected( field.getMeta( "cf_display_style" ) == "inline-none" ) }}><?php _e("Inline - without separator", "wpadverts-custom-fields") ?></option>
                <option value="block" {{ HTML.selected( field.getMeta( "cf_display_style" ) == "block" ) }}><?php _e("Block - one item per line", "wpadverts-custom-fields") ?></option>

            </select>
        </div>
    </div>
    <# } #>
    
    <div class="wpacf-config-field wpacf-field-display-icon">
        <label class="wpacf-config-label"><?php _e("Icon", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <a href="#" class="button wpacf-action-select-icon">
                <# if( field.getMeta("cf_display_icon") == "" ) { #>
                <?php _e( "select icon ...", "wpadverts-custom-fields" ) ?>
                <# } else { #>
                <span class="adverts-icon-{{ field.getMeta("cf_display_icon") }}"></span>
                <# } #>
            </a>
            <input type="hidden" name="cf_display_icon" value="{{ field.getMeta("cf_display_icon") }}" />
        </div>
    </div>
    
    <# } #>
    <?php
}

function wpadverts_custom_fields_option_upload() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Limit Files Number", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="upload_limit_min" placeholder="<?php _e("Min.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_limit", "min") }}" style="width:105px" />
            <input type="text" name="upload_limit_max" placeholder="<?php _e("Max.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_limit", "max") }}" style="width:105px" />
            
        </div>
    </div>
    
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Limit File Size", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="upload_size_min" placeholder="<?php _e("Min.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_size", "min") }}" style="width:105px" />
            <input type="text" name="upload_size_max" placeholder="<?php _e("Max. (2MB)", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_size", "max") }}" style="width:105px" />
            
        </div>
    </div>
    
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Allowed File Types", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <div>
                <# var allowed = field.getValidatorParam("upload_type", "allowed") #>
                <label><input type="checkbox" name="upload_type_allowed" value="image" {{ HTML.checked( allowed && allowed.indexOf("image") !== -1 ) }} /><?php _e("Images", "wpadverts-custom_fields") ?></label>
                &nbsp;
                <label><input type="checkbox" name="upload_type_allowed" value="video" {{ HTML.checked( allowed && allowed.indexOf("video") !== -1 ) }} /><?php _e("Videos", "wpadverts-custom_fields") ?></label>
                &nbsp;
                <label><input type="checkbox" name="upload_type_allowed" value="audio" {{ HTML.checked( allowed && allowed.indexOf("audio") !== -1 ) }} /><?php _e("Audio", "wpadverts-custom_fields") ?></label>
            </div>
        </div>
    </div>
    
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Additional File Extensions", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="upload_type_extensions" placeholder="<?php _e("e.g. pdf, doc, docx", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_type", "extensions") }}" />
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-image-dimensions">
        <label class="wpacf-config-label"><?php _e("Image dimensions", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <label>
                <input type="checkbox" name="upload_dimensions_strict" value="1" {{ HTML.checked( field.getValidatorParam("upload_dimensions", "strict") ) }}" />
                <?php _e("If image dimensions cannot be checked do not allow the file upload.", "wpadverts-custom-fields" ) ?>
            </label>
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-image-dimensions">
        <label class="wpacf-config-label"><?php _e("Image Width", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="upload_dimensions_min_width" placeholder="<?php _e("Min.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_dimensions", "min_width") }}" style="width:105px" />
            <input type="text" name="upload_dimensions_max_width" placeholder="<?php _e("Max.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_dimensions", "max_width") }}" style="width:105px" />
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-image-dimensions">
        <label class="wpacf-config-label"><?php _e("Image Height", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="upload_dimensions_min_height" placeholder="<?php _e("Min.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_dimensions", "min_height") }}" style="width:105px" />
            <input type="text" name="upload_dimensions_max_height" placeholder="<?php _e("Max.", "wpadverts-custom-fields") ?>" value="{{ field.getValidatorParam("upload_dimensions", "max_height") }}" style="width:105px" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_cf_search_field() {
    ?>
    
    <# if( data.meta.cf_builtin ) { #>
    <?php _e("Cannot modify search params for builtin fields.", "wpadverts-custom-fields") ?>
    
    <# } else { #>
    
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e("Search By", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">

            <select name="cf_search_field">
                <option value=""></option>
                
                <optgroup label="<?php echo esc_attr( "Advert Fields", "wpadverts-custom-fields" ) ?>">
                    <option value="defaults__p" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "defaults__p" ) }}><?php _e( "ID" ) ?></option>
                    <option value="defaults__s" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "defaults__s" ) }}><?php _e( "Keyword" ) ?></option>
                    <option value="defaults__author_id" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "defaults__s" ) }}><?php _e( "Author ID", "wpadverts-custom-fields" ) ?></option>
                    <option value="defaults__author_name" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "defaults__s" ) }}><?php _e( "Author Name", "wpadverts-custom-fields" ) ?></option>
                </optgroup>
                
                <optgroup label="<?php echo esc_attr( "Dates", "wpadverts-custom-fields" ) ?>">
                    <option value="date__post_date" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "date__post_date" ) }}><?php _e( "Publish Date", "wpadverts-custom-fields" ) ?></option>
                    <option value="date__post_date_gmt" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "date__post_date_gmt" ) }}><?php _e( "Publish Date (GMT)", "wpadverts-custom-fields" ) ?></option>
                    <option value="date__post_modified" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "date__post_modified" ) }}><?php _e( "Modified Date", "wpadverts-custom-fields" ) ?></option>
                    <option value="date__post_modified_gmt" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "date__post_modified_gmt" ) }}><?php _e( "Modified Date (GMT)", "wpadverts-custom-fields" ) ?></option>
                </optgroup>
                
                <optgroup label="<?php echo esc_attr( "Taxonomies", "wpadverts-custom-fields" ) ?>">
                    <?php foreach( get_object_taxonomies( 'advert', 'objects' ) as $tax ): ?>
                    <option value="taxonomy__<?php echo esc_html($tax->name) ?>" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "taxonomy__<?php echo esc_html($tax->name) ?>" ) }}><?php echo esc_html( $tax->label ) ?></option>
                    <?php endforeach; ?>
                </optgroup>
                
                <optgroup label="<?php echo esc_attr( "Custom Fields", "wpadverts-custom-fields" ) ?>">
                    <option value="meta__adverts_person" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__adverts_person" ) }}><?php _e( "Contact Person", "wpadverts-custom-fields" ) ?></option>
                    <option value="meta__adverts_email" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__adverts_email" ) }}><?php _e( "Contact Email", "wpadverts-custom-fields" ) ?></option>
                    <option value="meta__adverts_phone" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__adverts_phone" ) }}><?php _e( "Contact Phone", "wpadverts-custom-fields" ) ?></option>
                    <option value="meta__adverts_price" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__adverts_price" ) }}><?php _e( "Price", "wpadverts-custom-fields" ) ?></option>
                    <option value="meta__adverts_location" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__adverts_location" ) }}><?php _e( "Location", "wpadverts-custom-fields" ) ?></option>
                    <?php foreach( wpadverts_custom_fields_get_unique_metas() as $meta ): ?>
                    <option value="meta__<?php echo esc_html( $meta["name"] ) ?>" {{ HTML.selected( field.getMeta( "cf_search_field" ) === "meta__<?php echo esc_html( $meta["name"] ) ?>" ) }}><?php echo esc_html( $meta["label"] ) ?></option>
                    <?php endforeach; ?>
                </optgroup>
                
                <!--
                <option value="email" {{ HTML.selected( field.getValidatorParam("string_validate_as", "type") == "email" ) }}>Email</option>
                <option value="url" {{ HTML.selected( field.getValidatorParam("string_validate_as", "type") == "url" ) }}>URL</option>
                <option value="number" {{ HTML.selected( field.getValidatorParam("string_validate_as", "type") == "number" ) }}>Number</option>
                <option value="integer" {{ HTML.selected( field.getValidatorParam("string_validate_as", "type") == "integer" ) }}>Integer</option>
                -->
            </select>
        </div>
    </div>
    
    <div class="wpacf-search-defaults">
        
        <!-- No Options For Now -->
        
    </div>
    
    <div class="wpacf-search-date">
        
        <div class="wpacf-config-field">
            Retrive Ads posted 

            <span class="wpacf-madlib-wrap">
                <span class="wpacf-madlib-text">
                    <strong>
                        <# if( ! field.getMeta("cf_search_date") ) { #>
                        <span style="color: red"><?php _e("- select -", "wpadverts-custom-fields") ?></span>
                        <# } #>
                    </strong>
                    <span class="dashicons dashicons-arrow-down"></span>
                    <input type="hidden" name="cf_search_date" class="wpacf-madlib-value" value="{{ field.getMeta("cf_search_date") }}" />
                </span>

                <ul class="wpacf-madlib-suggest">
                    <li data-value="on"><?php _e("on", "wpadverts-custom-fields") ?></li>
                    <li data-value="before"><?php _e("before", "wpadverts-custom-fields") ?></li>
                    <li data-value="after"><?php _e("after", "wpadverts-custom-fields") ?></li>

                </ul>
            </span>

            selected date.
        </div>
    </div>

    <div class="wpacf-search-taxonomy">
        
        <div class="wpacf-config-field">
            Match <strong>if</strong> &quot;<span class="wpacf-search-field-label"></span>&quot; taxonomy field
            
            <span class="wpacf-madlib-wrap">
                <span class="wpacf-madlib-text">
                    <strong>
                        <# if( ! field.getMeta("cf_search_taxonomy_field") ) { #>
                        <span style="color: red"><?php _e("- select -", "wpadverts-custom-fields") ?></span>
                        <# } #>
                    </strong>
                    <span class="dashicons dashicons-arrow-down"></span>
                    <input type="hidden" name="cf_search_taxonomy_field" class="wpacf-madlib-value" value="{{ field.getMeta("cf_search_taxonomy_field") }}" />
                </span>
                
                <ul class="wpacf-madlib-suggest">
                    <li data-value="term_id"><?php _e("term id", "wpadverts-custom-fields") ?></li>
                    <li data-value="name"><?php _e("title", "wpadverts-custom-fields") ?></li>
                    <li data-value="slug"><?php _e("term slug", "wpadverts-custom-fields") ?></li>
                    <li data-value="term_taxonomy_id"><?php _e("term taxonomy id", "wpadverts-custom-fields") ?></li>
                </ul>
            </span>
            
            <span class="wpacf-madlib-wrap">
                <span class="wpacf-madlib-text">
                    <strong>
                        <# if( ! field.getMeta("cf_search_taxonomy_operator") ) { #>
                        <span style="color: red"><?php _e("- select -", "wpadverts-custom-fields") ?></span>
                        <# } #>
                    </strong>
                    <span class="dashicons dashicons-arrow-down"></span>
                    <input type="hidden" name="cf_search_taxonomy_operator" class="wpacf-madlib-value" value="{{ field.getMeta("cf_search_taxonomy_operator") }}" />
                </span>
                
                <ul class="wpacf-madlib-suggest">
                    <li data-value="in"><?php _e("matches one or more", "wpadverts-custom-fields") ?></li>
                    <li data-value="not-in"><?php _e("matches none of", "wpadverts-custom-fields") ?></li>
                    <li data-value="and"><?php _e("matches all", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="exists"><?php _e("term taxonomy id", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="not-exists"><?php _e("term taxonomy id", "wpadverts-custom-fields") ?></li>
                </ul>
            </span>
            
            search values.
        </div>
        
        <div class="wpacf-config-field">
                <# var incc = field.getMeta("cf_search_taxonomy_include_children") #>
                <input type="checkbox" name="cf_search_taxonomy_include_children" value="1" {{ HTML.checked( incc == "1" ) }}/>
                <?php _e( "Include Ads from selected taxonomy sub-categories as well.", "wpadverts-custom-fields" ) ?>
        </div>
        
        
    </div>
    
    <div class="wpacf-search-meta">
        
        <div class="wpacf-config-field">
            Match <strong>if</strong> "<span class="wpacf-search-field-label">-</span>" 
            
            <span class="wpacf-madlib-wrap">
                <span class="wpacf-madlib-text">
                    <strong class="cf_search_meta_compare_text ">
                        <# if( ! field.getMeta("cf_search_meta_compare") ) { #>
                        <span style="color: red"><?php _e("- select -", "wpadverts-custom-fields") ?></span>
                        <# } #>
                    </strong>
                    <span class="dashicons dashicons-arrow-down"></span>
                    <input type="hidden" name="cf_search_meta_compare" class="wpacf-madlib-value" value="{{ field.getMeta("cf_search_meta_compare") }}" />
                </span>
                
                <ul class="cf_search_meta_compare_select wpacf-madlib-suggest">
                    <li data-value="equal"><?php _e("is equal to", "wpadverts-custom-fields") ?></li>
                    <li data-value="not-equal"><?php _e("is NOT equal to", "wpadverts-custom-fields") ?></li>
                    <li data-value="greater"><?php _e("is greater than", "wpadverts-custom-fields") ?></li>
                    <li data-value="greater-or-equal"><?php _e("is greater or equal to", "wpadverts-custom-fields") ?></li>
                    <li data-value="less"><?php _e("is smaller than", "wpadverts-custom-fields") ?></li>
                    <li data-value="less-or-equal"><?php _e("is smaller or equal to", "wpadverts-custom-fields") ?></li>
                    <li data-value="like"><?php _e("contains", "wpadverts-custom-fields") ?></li>
                    <li data-value="not-like"><?php _e("does NOT contain", "wpadverts-custom-fields") ?></li>
                    <li data-value="in"><?php _e("has one or more selected", "wpadverts-custom-fields") ?></li>
                    <li data-value="not-in"><?php _e("has none of selected", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="between"><?php _e("", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="not-between"><?php _e("", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="exists"><?php _e("", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="not-exists"><?php _e("", "wpadverts-custom-fields") ?></li>
                </ul>
            </span>
                
            search value.
            
        </div>
        
        <div class="wpacf-config-field">
            Compare values as 
            
            <span class="wpacf-madlib-wrap">
                <span class="wpacf-madlib-text">
                    <strong class="cf_search_meta_compare_text ">
                        <# if( ! field.getMeta("cf_search_meta_operator") ) { #>
                        <span style="color: red"><?php _e("- select -", "wpadverts-custom-fields") ?></span>
                        <# } #>
                    </strong>
                    <span class="dashicons dashicons-arrow-down"></span>
                    <input type="hidden" name="cf_search_meta_operator" class="wpacf-madlib-value" value="{{ field.getMeta("cf_search_meta_operator") }}" />
                </span>
                
                <ul class="cf_search_meta_compare_select wpacf-madlib-suggest">
                    <li data-value="numeric"><?php _e("numbers", "wpadverts-custom-fields") ?></li>
                    <li data-value="binary"><?php _e("binary data", "wpadverts-custom-fields") ?></li>
                    <li data-value="char"><?php _e("texts", "wpadverts-custom-fields") ?></li>
                    <li data-value="date"><?php _e("dates", "wpadverts-custom-fields") ?></li>
                    <li data-value="datetime"><?php _e("dates and time", "wpadverts-custom-fields") ?></li>
                    <li data-value="decimal"><?php _e("decimal numbers", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="signed"><?php _e("", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="time"><?php _e("", "wpadverts-custom-fields") ?></li>
                    <li style="display:none" data-value="unsigned"><?php _e("", "wpadverts-custom-fields") ?></li>
                </ul>
            </span>.

        </div>
        
    </div>  
    
    <# } #>
    
    <?php
}

function wpadverts_custom_fields_option_multiselect_options( $field ) {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Fill Method", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <select name="cf_options_fill_method">
                <option value=""></option>
                <option value="data" {{ HTML.selected( field.getMeta( "cf_options_fill_method" ) == "data" ) }}><?php _e( "I will enter options myself", "wpadverts-custom-fields" ) ?></option>
                <option value="callback" {{ HTML.selected( field.getMeta( "cf_options_fill_method" ) == "callback" ) }}><?php _e( "Use registered data source", "wpadverts-custom-fields" ) ?></option>
            </select>
        </div>
    </div>
    
    <div class="wpacf-multiselect-options-predefined">
        <div class="wpacf-config-field">


                <ul class="wpacf-multiselect-options-template " style="display: none">
                    <li>
                        <input type="text" name="option_value[]" class="wpadverts-multiselect-option-value" placeholder="<?php _e("value", "wpadverts-custom-fields") ?>" />
                        <input type="text" name="option_text[]" class="wpadverts-multiselect-option-text" placeholder="<?php _e("text", "wpadverts-custom-fields") ?>" />
                        
                        <span class="wpadverts-multiselect-option-drag dashicons dashicons-move"></span>
                        <span class="wpadverts-multiselect-option-trash dashicons dashicons-trash"></span>
                    </li>
                </ul>
            
                <ul class="wpacf-multiselect-options ">
                    <# 
                        if( ! data.options ) {
                            var options = [{value: "", text: ""}];
                        } else {
                            var options = data.options;
                        }
                    #>
                    
                    <# for(var o in options) { #>
                    <li>
                        <input type="text" name="option_value[]" class="wpadverts-multiselect-option-value" placeholder="<?php _e("value", "wpadverts-custom-fields") ?>" value="<# if ( field.getMeta( 'cf_use_values' ) == '1') { #>{{ options[o].value }}<# } #>" />
                        <input type="text" name="option_text[]" class="wpadverts-multiselect-option-text" placeholder="<?php _e("text", "wpadverts-custom-fields") ?>" value="{{ options[o].text }}" />
                        
                        <span class="wpadverts-multiselect-option-drag dashicons dashicons-move"></span>
                        <span class="wpadverts-multiselect-option-trash dashicons dashicons-trash"></span>
                    </li>
                    <# } #>
                </ul>

                <div class="wpacf-multiselect-options-add">
                    <input type="button" name="option_add" class="button wpacf-multiselect-options-add-action" value="<?php _e( "Add Option", "wpadverts-custom-fields") ?>" />
                    <span class="wpacf-multiselect-show-values-wrap">
                        
                        <label for="wpacf-multiselect-use-values"><?php _e( "use values", "wpadverts-custom-fields" ) ?></label>
                        <input type="checkbox" id="wpacf-multiselect-use-values" value="1" style="margin-top:2px" name="cf_use_values" {{ HTML.checked( field.getMeta( "cf_use_values" ) == "1" ) }} />
                    </span>
                </div>
            
        </div>
    </div>
    
    <div class="wpacf-multiselect-options-callback">
        
        <div class="wpacf-config-field">
            <label class="wpacf-config-label"><?php _e( "Data Source", "wpadverts-custom-fields" ) ?></label>
            <div class="wpacf-config-input">
                <select name="cf_data_source">
                    <option value=""></option>
                <?php foreach( wpadverts_custom_fields_get_data_source() as $source ): ?>
                    <option value="<?php echo esc_attr( $source["name"] ) ?>" {{ HTML.selected( field.getMeta("cf_data_source") == '<?php echo esc_attr( $source["name"] ) ?>' ) }}><?php echo esc_html( $source["title"] ) ?></option>    
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        
    </div>
    <?php
}

function wpadverts_custom_fields_option_empty_option( $field ) {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Empty Option", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="checkbox" name="empty_option" id="wpacf-empty-option" value="1" {{ HTML.checked( data.empty_option == "1" ) }} />
           <label for="wpacf-empty-option"><?php _e( "List starts with an empty option", "wpadverts-custom-fields" ) ?></label>
        </div>
    </div>
    
    <div class="wpacf-config-field wpacf-empty-option-text">
        <label class="wpacf-config-label"><?php _e( "Empty Option Text", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="text" name="empty_option_text" value="{{ data.empty_option_text }}" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_max_choices() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Max Choices", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="number" name="max_choices" value="{{ data.max_choices }}" step="1" placeholder="1" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_option_rows() {
    ?>
    <div class="wpacf-config-field">
        <label class="wpacf-config-label"><?php _e( "Rows", "wpadverts-custom-fields" ) ?></label>
        <div class="wpacf-config-input">
            <input type="number" name="rows" value="{{ data.rows }}" placeholder="<?php _e( "unlimited", "wpadverts-custom-fields") ?>" step="1" min="1" />
        </div>
    </div>
    <?php
}

function wpadverts_custom_fields_template_field_hidden($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_hidden">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual" style="display:none" data-name="{{ data.name }}"></div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_header($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_header">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual wpacf-header">
                <h2 class="hndle">
                    <span class="wpacf-header-label">{{ data.label }}</span>
                    <# if( typeof data.description !== 'undefined' && data.description.length > 0 ) { #>
                    <span class="wpacf-header-description">{{ data.description }}</span>
                    <# } #>
                </h2>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_account($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_account">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>

                <div class="wpacf-visual-input-wrap">
                <?php
                    $text = __('You are posting as <strong>%1$s</strong>. <br/>If you want to use a different account, please <a href="%2$s">logout</a>.', 'adverts');
                    printf( '<div>'.$text.'</div>', wp_get_current_user()->display_name, "#" );
                ?>
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_gallery($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_gallery">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>

                <div class="wpacf-visual-input-wrap">
                    <div class=" adverts-gallery">
                        <p><?php _e("Drop files here to add them.", "wpadverts-custom-fields") ?></p>
                        <p><a href="#" id="adverts-plupload-browse-button" class="button" style="z-index: 1;"><?php _e("browse files ...", "wpadverts-custom-fields") ?></a></p>
                    </div>
                </div>
                
                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_text($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_text">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>
                
                <div class="wpacf-visual-input-wrap">
                    <input type="text" name="{{ data.name }}" placeholder="{{ data.placeholder }}" />
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_select($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_select" data-uses-options="1">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>
                
                <div class="wpacf-visual-input-wrap">
                    <# var options = field.getOptions() #>
                    <# if(options) { #>
                       <select style="width:100%">
                            <# if( data.empty_option == 1 ) { #>
                            <option value="">{{ data.empty_option_text }}</option>
                            <# } #>

                            <# for(var i in options) { #>
                            <option value="{{ i }}">{{ options[i].text }}</option>
                            <# } #>
                        </select>
                    <# } else if(field.getMeta("cf_data_source")) { #>
                        <span class="wpacf-multiselect-options-placeholder">
                            <span class="dashicons dashicons-update adverts-spin"></span> 
                            <?php _e( "Loading Options ...", "wpadverts-custom-fields" ) ?>
                        </span>
                    <# } else { #>
                        <select style="width:100%">
                            <# if( data.empty_option == 1 ) { #>
                            <option value="">{{ data.empty_option_text }}</option>
                            <# } #>
                        </select>
                    <# } #>
                        
                    
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_checkbox($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_checkbox" data-uses-options="1">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>

                <div class="wpacf-visual-input-wrap wpacf-multiselect-rows" data-rows="{{ data.rows }}">
                    <# var options = field.getOptions() #>
                    <# if(options) { #>
                        <# for(var i in options) { #>
                        <label><input type="checkbox" value="" /> {{ options[i].text }}</label>
                        <# } #>
                    <# } else if(field.getMeta("cf_data_source")) { #>
                        <span class="wpacf-multiselect-options-placeholder">
                            <span class="dashicons dashicons-update adverts-spin"></span> 
                            <?php _e( "Loading Options ...", "wpadverts-custom-fields" ) ?>
                        </span>
                    <# } else { #>
                    <?php _e( "-- Edit This Field And Enter Some Options --", "wpadverts-custom-fields" ) ?>
                    <# } #>
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_radio($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_radio" data-uses-options="1">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label">
                    <# if( data.label.length > 0 ) { #>        
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>
                
                <div class="wpacf-visual-input-wrap wpacf-multiselect-rows" data-rows="{{ data.rows }}">
                    <# var options = field.getOptions() #>
                    <# if(options) { #>
                        <# for(var i in options) { #>
                        <label><input type="radio" value="" /> {{ options[i].text }}</label>
                        <# } #>
                    <# } else if(field.getMeta("cf_data_source")) { #>
                        <span class="wpacf-multiselect-options-placeholder">
                            <span class="dashicons dashicons-update adverts-spin"></span> 
                            <?php _e( "Loading Options ...", "wpadverts-custom-fields" ) ?>
                        </span>
                    <# } else { #>
                    <?php _e( "-- Edit This Field And Enter Some Options --", "wpadverts-custom-fields" ) ?>
                    <# } #>
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                    <?php
                        foreach($field["config"] as $config) {
                            call_user_func( $config["callback_template"], $config );
                        }
                    ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_template_field_textarea($field) {
    ?>
    <script type="text/html" id="tmpl-cf-visual-adverts_field_textarea">
        <# var field = new WPADVERTS.CF.Helper(data) #>
        <# var HTML = WPADVERTS.CF.HTML; #>
        <div class="inside wpacf-mode-visual">
            <div class="main wpacf-visual">
                <span class="wpacf-visual-label" style="display: inline-block; width: 33%">
                    <# if( data.label.length > 0 ) { #>
                        {{ data.label }}

                        <# if( field.hasValidator("is_required") ) { #>
                        <span class="wpacf-field-is-required">*</span>
                        <# } #>
                    <# } #>
                </span>

                <div class="wpacf-visual-input-wrap">
                    <# if( data.mode == 'plain-text' || ! data.mode ) { #>
                    <textarea class="wpacf-plain-text-body" name="{{ data.name }}" placeholder="{{ data.placeholder }}" /></textarea>

                    <# } else { #>
                    <div class="wpacf-tinymce-editor">
                        <div class="wpacf-tinymce-editor-header">
                            <img src='<?php echo plugins_url() . '/wpadverts-custom-fields/assets/images/tinymce-header.png' ?>' alt='' />
                        </div>
                        <textarea class="wpacf-tinymce-editor-body" name="{{ data.name }}" placeholder="{{ data.placeholder }}" /></textarea>
                    </div>
                    <# } #>
                </div>

                <div class="wpacf-visual-actions">
                    <a href="#" class="wpacf-action-edit"><span class="dashicons dashicons-edit"></span></a>
                    <a href="#" class="wpacf-action-trash"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </div>
            <div class="main wpacf-config" style="display:none">
                <form action="" method="get" class="wpacf-config-form">

                <?php
                    foreach($field["config"] as $config) {
                        call_user_func( $config["callback_template"], $config );
                    }
                ?>

                </form>
                <hr/>
                <button class="button wpacf-action-update"><?php _e("Update", "wpadverts-custom-fields") ?></button>
                <button class="button wpacf-action-cancel"><?php _e("Cancel", "wpadverts-custom-fields") ?></button>
            </div>
        </div>
    </script>
    <?php
}

function wpadverts_custom_fields_js_name( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.name = form.find("input[name=name]").val();
        return field;
    });
    _WPADVERTS_CF_VALIDATE.<?php echo $field["type"] ?>.push(function(field, form) {
        var name = form.find("input[name=name]").val();
        if(field.name !== name && WPADVERTS.CF.getInput(name) !== null) {
            return {
                name: "name",
                error: "<?php _e("This field name is already being used.", "wpadverts-custom-fields") ?>"
            };
        }
        return true;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_label( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.label = form.find("input[name=label]").val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_description( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.description = form.find("input[name=description]").val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_class( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.class = form.find("input[name=class]").val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_is_required( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        if(form.find("input[name=is_required]").is(":checked")) {
            field.validator.push({name: "is_required"});
        }
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_cf_visibility( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var visibility = form.find('input[name=cf_visibility]:checked').val();
        if(visibility.length > 0) {
            field.meta.cf_visibility = visibility;
        }

        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_placeholder( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.placeholder = form.find("input[name=placeholder]").val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_string_length( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var min = form.find("input[name=string_lenth_min]").val();
        var max = form.find("input[name=string_lenth_max]").val();
        if( min.length > 0 || max.length > 0 ) {
            
            var params = { };
            
            if(min.length > 0) {
                params.min = min;
            }
            
            if(max.length > 0) {
                params.max = max;
            }
            
            field.validator.push({
                name: "string_length",
                params: params
            });
        }
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_string_validate_as( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var validateAs = form.find("select[name=string_validate_as]").val();
        if(validateAs.length > 0) {
            field.validator.push({
                name: validateAs
            });
        }
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_textarea_mode( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.mode = form.find('input[name=mode]:checked').val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_filters( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.filter = [];
        form.find("input[name=filters]:checked").each(function(index, item) {
            field.filter.push({
                name: jQuery(item).val()
            });
        });

        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_search_type( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.meta.search_type = form.find('input[name=search_type]:checked').val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_display( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var cf_display = form.find('select[name=cf_display]');
        
        if(cf_display.length === 0) {
            return field;
        }
        
        field.meta.cf_display = cf_display.val();
        
        if(field.meta.cf_display === "anywhere") {
            field.meta.cf_display_type = form.find("input[name=cf_display_type]:checked").val();
            field.meta.cf_display_as = form.find("select[name=cf_display_as]").val();
            field.meta.cf_display_icon = form.find("input[name=cf_display_icon]").val();
            field.meta.cf_display_style = null;
            
            var style = form.find("select[name=cf_display_style]");
            if( style.length > 0 && style.is(":visible")) {
                field.meta.cf_display_style = style.val();
            }
        }
        
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_upload( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var params = null;
        
        var upload_limit_min = form.find("input[name=upload_limit_min]").val();
        var upload_limit_max = form.find("input[name=upload_limit_max]").val();
        
        if(upload_limit_min.length > 0 || upload_limit_max.length > 0) {
            params = { };
            
            if(upload_limit_min.length > 0) {
                params.min = parseInt(upload_limit_min);
            }
            if(upload_limit_max.length > 0) {
                params.max = parseInt(upload_limit_max);
            }
            
            field.validator.push({
                name: "upload_limit",
                params: params
            });
        }
        
        var upload_size_min = form.find("input[name=upload_size_min]").val();
        var upload_size_max = form.find("input[name=upload_size_max]").val();
        
        if(upload_size_min.length > 0 || upload_size_max.length > 0) {
            params = { };
            
            if(upload_size_min.length > 0) {
                params.min = upload_size_min;
            }
            if(upload_size_max.length > 0) {
                params.max = upload_size_max;
            }
            
            field.validator.push({
                name: "upload_size",
                params: params
            });
        }
        
        var upload_type_allowed = [];
        form.find("input[name=upload_type_allowed]").each(function(index, item) {
            var $this = jQuery(this);
            if($this.is(":checked")) {
                upload_type_allowed.push($this.val());
            }
        });
        
        var upload_type_extensions = form.find("input[name=upload_type_extensions]").val().replace(" ", "").split(",");
        
        if(upload_type_allowed.length > 0 || upload_type_extensions.length > 0) {
            params = { };
            
            if(upload_type_allowed.length > 0) {
                params.allowed = upload_type_allowed;
            }
            
            if(upload_type_extensions.length > 0) {
                params.extensions = upload_type_extensions;
            }
            
            field.validator.push({
                name: "upload_type",
                params: params
            });
        }
        
        if(upload_type_allowed.indexOf("image") === -1) {
            return field;
        }
        
        var upload_dimensions_strict = form.find("input[name=upload_dimensions_strict]").is(":checked");
        
        var upload_dim_min_width = parseInt(form.find("input[name=upload_dimensions_min_width]").val());
        var upload_dim_max_width = parseInt(form.find("input[name=upload_dimensions_max_width]").val());
        
        var upload_dim_min_height = parseInt(form.find("input[name=upload_dimensions_min_height]").val());
        var upload_dim_max_height = parseInt(form.find("input[name=upload_dimensions_max_height]").val());
        
        var dim_total = 0;
        
        if(isNaN(upload_dim_min_width)) {
            upload_dim_min_width = "";
        } else {
            dim_total += upload_dim_min_width;
        }
        
        if(isNaN(upload_dim_max_width)) {
            upload_dim_max_width = "";
        } else {
            dim_total += upload_dim_max_width;
        }
        
        if(isNaN(upload_dim_min_height)) {
            upload_dim_min_height = "";
        } else {
            dim_total += upload_dim_min_height;
        }
        
        if(isNaN(upload_dim_max_height)) {
            upload_dim_max_height = "";
        } else {
            dim_total += upload_dim_max_height;
        }

        if(dim_total > 0) {
            field.validator.push({
                name: "upload_dimensions",
                params: {
                    strict: upload_dimensions_strict ? 1 : 0,
                    min_width: upload_dim_min_width,
                    max_width: upload_dim_max_width,
                    min_height: upload_dim_min_height,
                    max_height: upload_dim_max_height
                }
            });
        }
        
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_cf_search_field( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        var search_field = form.find("select[name=cf_search_field]").val();
        
        if(typeof search_field === 'undefined' || search_field.length < 1) {
            return field;
        }
        
        field.meta.cf_search_field = search_field;
        
        var parts = search_field.split("__");
        
        if(parts[0] === "meta") {
            field.meta.cf_search_meta_compare = form.find("input[name=cf_search_meta_compare]").val();
            field.meta.cf_search_meta_operator = form.find("input[name=cf_search_meta_operator]").val();
        } else if(parts[0] === "taxonomy") {
            field.meta.cf_search_taxonomy_field = form.find("input[name=cf_search_taxonomy_field]").val();
            field.meta.cf_search_taxonomy_operator = form.find("input[name=cf_search_taxonomy_operator]").val();
            
            if(form.find("input[name=cf_search_taxonomy_include_children]").is(":checked")) {
                field.meta.cf_search_taxonomy_include_children = 1;
            } else {
                field.meta.cf_search_taxonomy_include_children = 0;
            }
        } else if(parts[0] === "date") {
            field.meta.cf_search_date = form.find("input[name=cf_search_date]").val()
        }
        
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_multiselect_options( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {

        field.options = [];
        field.meta.cf_options_fill_method = form.find("select[name=cf_options_fill_method]").val();
        
        if(field.meta.cf_options_fill_method === "callback") {
            field.meta.cf_data_source = form.find("select[name=cf_data_source]").val();
        } 
        
        if(field.meta.cf_options_fill_method === "data") {
            if(form.find("input[name=cf_use_values]").is(":checked")) {
                field.meta.cf_use_values = "1";
            } else {
                field.meta.cf_use_values = "0";
            }
            
            
            form.find(".wpacf-multiselect-options li").each(function(index, item) {
                var data = {
                    value: jQuery(item).find(".wpadverts-multiselect-option-text").val(),
                    text: jQuery(item).find(".wpadverts-multiselect-option-text").val()
                };
                
                if(field.meta.cf_use_values === "1") {
                    data.value = jQuery(item).find(".wpadverts-multiselect-option-value").val();
                }
                
                if(data.value.length > 0 || data.text.length > 0) {
                    field.options.push(data);
                }
            });
        }

        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_empty_option( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        if(form.find("input[name=empty_option]").is(":checked")) {
            field.empty_option = "1";
            field.empty_option_text = form.find("input[name=empty_option_text]").val();
        } else {
            field.empty_option = "0";
        }
        
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_max_choices( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.max_choices = form.find("input[name=max_choices]").val();
        return field;
    });
    </script>
    <?php
}

function wpadverts_custom_fields_js_rows( $field ) {
    ?>
    <script type="text/javascript">
    _WPADVERTS_CF_CALLBACK.<?php echo $field["type"] ?>.push(function(field, form) {
        field.rows = form.find("input[name=rows]").val();
        return field;
    });
    </script>
    <?php
}