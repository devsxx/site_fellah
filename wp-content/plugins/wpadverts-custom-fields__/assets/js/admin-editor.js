// Init global namespace
var WPADVERTS = WPADVERTS || {};

// Init local namespace
WPADVERTS.CF = {
    
    addAction: function(field, callback){
        if(typeof WPADVERTS.CF.callback[field] == 'undefined') {
            WPADVERTS.CF.callback[field] = [];
        }
        
        WPADVERTS.CF.callback[field].push(callback);
    },
    
    input: [
        
    ],
    
    DataStore: {
        
    },
    
    getInput: function(name) {
        var $ = jQuery;
        var input = null;
        
        jQuery.each(WPADVERTS.CF.input, function(index, item) {
            if(item.field.name == name) {
                input = item;
                return false;
            }
        });
        
        return input;
    },
    
    getField: function(type) {
        var $ = jQuery;
        var field = null;
        
        $.each(_WPADVERTS_CF_FIELDS, function(index, item) {
            if(item.type == type) {
                field = item;
                return false;
            }
        });
        
        return field;
    },
    
    uniqueName: function(prefix) {
        var i = WPADVERTS.CF.input.length;

        while(WPADVERTS.CF.getInput(prefix + i.toString()) !== null) {
            i++;
        }
        
        return prefix + i.toString();
    },
    
    HTML: {
        checked: function(cond) {
            if(cond) {
                return ' checked="checked" ';
            }
        },
        selected: function(cond) {
            if(cond) {
                return ' selected="selected" ';
            }
        },
    },
    
    Delete: {
        dialog: function(e) {
            e.preventDefault();
            
            jQuery("#wpadverts-cf-dialog-delete").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: [
                    {
                        text: wpadverts_custom_fields_editor.delete,
                        click: jQuery.proxy(WPADVERTS.CF.Delete.delete, this),
                    }, 
                    {
                        text: wpadverts_custom_fields_editor.cancel,
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]
            });
        },
        
        delete: function() {
            window.location = jQuery(".wpadverts-cf-from-delete").attr("href");
        }
    },
    
    Save: {
        click: function(e) {
            e.preventDefault(); 
            
            if(jQuery("#wpadverts-custom-fields-editor .wpacf-mode-config").length > 0) {
                
                jQuery("#wpadverts-cf-dialog-pre-save").dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: [
                        {
                            text: wpadverts_custom_fields_editor.ok,
                            click: function() {
                                jQuery( this ).dialog( "close" );
                            }
                        }
                    ]
                });
                
                return;
            }
            
            jQuery(".wpadverts-cf-save-error").hide();
            jQuery(".wpadverts-cf-save-error span").text("");
            jQuery(".wpadverts-custom-fields-save-spinner").css("visibility", "visible");

            var data = {
                action: "wpadverts-custom-fields-save",
                form_id: jQuery(this).data("form-id"),
                form: null,
                is_string: 0,
                nonce: _WPADVERTS_CF_NONCE
            };

            var form = {
                layout: null,
                field: [],
                trash: []
            };
            
            if(jQuery(".wpadverts-cf-uses-from-layout").length > 0) {
                form.layout = jQuery("input[name=form_layout]:checked").val();
            }

            jQuery.each(WPADVERTS.CF.input, jQuery.proxy(WPADVERTS.CF.Save.collect, form));

            data.form = form;
            data.is_default = +jQuery("#wpadverts-cf-is-default").is(":checked");

            if(typeof JSON.stringify == "function") {
                data.form = JSON.stringify(data.form);
                data.is_string = 1;
            } else {
                data.form = form;
            }
             
            jQuery.ajax({
                url: ajaxurl,
                type: "post",
                data: data,
                dataType: "json",
                success: WPADVERTS.CF.Save.success,
                error: WPADVERTS.CF.Save.error
            });
        },

        collect: function(index, item) {
            var data = item.field;
            
            data.meta.cf_saved = 1;
            
            if(item.trashed) {
                this.trash.push(data);
            } else {
                data.order = parseInt(item.inside.index()) * 1;
                this.field.push(data);
            }
        },

        success: function(response) {
            jQuery(".wpadverts-custom-fields-save-spinner").css("visibility", "");
            
            if(response.result == "1") {
                jQuery.each(WPADVERTS.CF.input, function(index) {
                    WPADVERTS.CF.input[index].field.cf_saved = 1;
                    if(!WPADVERTS.CF.input[index].trashed) {
                        WPADVERTS.CF.input[index].reload();
                    }
                });
                
                jQuery(".wpadverts-custom-fields-save-ok").show().delay(1000).fadeOut("slow");
            } else {
                jQuery(".wpadverts-cf-save-error").show();
                jQuery(".wpadverts-cf-save-error span").text( response.error );
            }
        },
        
        error: function(response) {
            jQuery(".wpadverts-custom-fields-save-spinner").css("visibility", "");
            
            var error = response.responseText;
            
            if(error.length === 0) {
                error = response.statusText;
            }
            
            jQuery(".wpadverts-cf-save-error").show();
            jQuery(".wpadverts-cf-save-error span").text( error );
        }
    },
    
    SetLayout: function(e) {
        if(typeof e !== "undefined") {
            e.preventDefault();
        }
        
        var layout = jQuery("input[name=form_layout]:checked").val();
        
        jQuery("#wpadverts-custom-fields-editor").removeClass("adverts-form-stacked");
        jQuery("#wpadverts-custom-fields-editor").removeClass("adverts-form-aligned");
        jQuery("#wpadverts-custom-fields-editor").addClass("adverts-form-"+layout);
    }
    
};

WPADVERTS.CF.Form = function(form) {
    this.form = form;
};

WPADVERTS.CF.Form.prototype.addError = function(name, error) {
    var field = this.form.find("[name='"+name+"']").first().closest(".wpacf-config-field");
    var input = field.find(".wpacf-config-input");
    
    field.addClass("wpacf-config-field-error");
    input.append('<div class="wpacf-config-field-error-msg">' + error + '</div>');
};

WPADVERTS.CF.Form.prototype.clearErrors = function() {
    this.form.find(".wpacf-config-field-error").removeClass("wpacf-config-field-error");
    this.form.find(".wpacf-config-field-error-msg").remove();
    
}

WPADVERTS.CF.Helper = function( field ) {
    this.field = field;
    this.conf = WPADVERTS.CF.getField(field.type);
};

WPADVERTS.CF.Helper.prototype.uses = function(option) {
    if(jQuery.inArray(option, this.conf.options) >= 0) {
        return true;
    } else {
        return false;
    }
};

WPADVERTS.CF.Helper.prototype.getMeta = function(name) {
    if( typeof this.field.meta === 'undefined' ) {
        return "";
    }
    
    if( typeof this.field.meta[name] === 'undefined' ) {
        return "";
    }
    
    return this.field.meta[name];
}

WPADVERTS.CF.Helper.prototype.getValidator = function(validator) {
    var $ = jQuery;
    var result = null;

    if(typeof this.field.validator === "undefined" ) {
        return result;
    }

    $.each(this.field.validator, function(index, item) {
        if(item.name === validator) {
            result = item;
        }
    });
    return result;
};

WPADVERTS.CF.Helper.prototype.hasValidator = function(validator) {
    if( this.getValidator(validator) === null ) {
        return false;
    } else {
        return true;
    }
};

WPADVERTS.CF.Helper.prototype.getValidatorParam = function(validator, param) {
    var v = this.getValidator(validator);
    
    if(v === null) {
        return "";
    }
    
    return v.params[param];
};

WPADVERTS.CF.Helper.prototype.getFilter = function(filter) {
    var $ = jQuery;
    var result = null;

    if(typeof this.field.filter === "undefined" ) {
        return result;
    }


    $.each(this.field.filter, function(index, item) {
        if(item.name === filter) {
            result = item;
        }
    });
    return result;
};

WPADVERTS.CF.Helper.prototype.hasFilter = function(filter) {
    if( this.getFilter(filter) === null ) {
        return false;
    } else {
        return true;
    }
};

WPADVERTS.CF.Helper.prototype.getFilterParam = function(filter, param) {
    var v = this.getFilter(filter);
    
    if(v === null) {
        return "";
    }
    
    return v.params[param];
};

WPADVERTS.CF.Helper.prototype.getOptions = function() {
    if(this.field.options && this.field.options.length > 0) {
        return this.field.options;
    } else if(WPADVERTS.CF.DataStore[this.getMeta("cf_data_source")]) {
        return WPADVERTS.CF.DataStore[this.getMeta("cf_data_source")];
    } else {
        return false;
    }
};

// Default fields definitions

WPADVERTS.CF.Field = function(attach, field) {

    var defaults = {
        type: 'adverts_field_unknown',
        name: WPADVERTS.CF.uniqueName("custom_field_"),
        label: WPADVERTS.CF.uniqueName("Custom Field "),
        meta: {
            cf_builtin: false,
            cf_saved: false
        }
    };
    
    this.options = null;
    this.template =  WPADVERTS.CF.getField(field.type).template_id;
    
    this.button = { };
    this.view = { };
    this.inside = null;
    
    this.attach = attach;
    this.field = jQuery.extend(defaults, field);
    this.trashed = false;
};

WPADVERTS.CF.Field.prototype.visual = function() {
    var template = wp.template( this.template );
    var $ = jQuery;
    
    return $(template(this.field));
};

WPADVERTS.CF.Field.prototype.render = function() {
    var template = wp.template( this.template );
    var $ = jQuery;
    
    var visual = this.visual();
    
    var scheme = WPADVERTS.CF.getField(this.field.type);
    
    if(typeof scheme.uses_options !== 'undefined' && scheme.uses_options) {
        
        this.options = new WPADVERTS.CF.Options(visual);
        
        var data_source = this.field.meta.cf_data_source;
        
        if(typeof data_source !== 'undefined' && data_source !== null) {

            if(typeof WPADVERTS.CF.DataStore[data_source] === "undefined") {

                var data = {
                    action: "wpadverts-custom-fields-data-store",
                    data_source: data_source,
                    nonce: _WPADVERTS_CF_NONCE
                };

                jQuery.ajax({
                    url: ajaxurl,
                    data: data,
                    type: "post",
                    dataType: "json",
                    success: jQuery.proxy(this.dataStoreSuccess, this),
                    error: jQuery.proxy(this.dataStoreError, this),

                });
            }
        } else {
            
        }
    } else {
        this.options = null;
    }
    
    this.button.edit = visual.find(".wpacf-action-edit");
    this.button.edit.on("click", $.proxy(this.edit, this));
    
    this.button.trash = visual.find(".wpacf-action-trash");
    this.button.trash.on("click", $.proxy(this.trash, this));
    
    this.button.update = visual.find(".wpacf-action-update");
    this.button.update.on("click", $.proxy(this.update, this));
    
    this.button.cancel = visual.find(".wpacf-action-cancel");
    this.button.cancel.on("click", $.proxy(this.cancel, this));
    
    this.view.visual = visual.find(".wpacf-visual");
    this.view.config = visual.find(".wpacf-config");
    
    this.form = visual.find("form");
    this.inside = visual;
    
    return visual;
};

WPADVERTS.CF.Field.prototype.reload = function() {
    this.inside.replaceWith(this.render());
};

WPADVERTS.CF.Field.prototype.edit = function(e) {
    e.preventDefault();
    
    this.inside.removeClass("wpacf-mode-visual");
    this.inside.addClass("wpacf-mode-config");
    
    this.view.visual.hide();
    this.view.config.fadeIn("fast");
    
    //jQuery( "#wpadverts-custom-fields-editor" ).sortable( "option", "disabled", true );
};

WPADVERTS.CF.Field.prototype.update = function(e) {
    e.preventDefault();
    
    var field = this.field;
    var form = this.form;
    
    var valid = true;
    var f = new WPADVERTS.CF.Form(this.form);
    f.clearErrors();
    
    jQuery.each(_WPADVERTS_CF_VALIDATE[this.field.type], function(index, callback) {
        var result = callback(field, form);
        
        if(result !== true) {
            f.addError(result.name, result.error);
            valid = false;
        }
    });
    
    if(valid === false) {
        return;
    }
    
    if(typeof this.field.meta === 'undefined') {
        this.field.meta = { 
            modified: 1
        };
    }
    
    // Reset Validators
    this.field.validator = [];
    

    
    jQuery.each(_WPADVERTS_CF_CALLBACK[this.field.type], function(index, callback) {
        field = callback(field, form);
    });
    
    this.field = field;
    
    this.reload();
};

WPADVERTS.CF.Field.prototype.cancel = function(e) {
    e.preventDefault();
    
    this.inside.removeClass("wpacf-mode-config");
    this.inside.addClass("wpacf-mode-visual");
    
    this.reload();
};

WPADVERTS.CF.Field.prototype.trash = function(e) {
    e.preventDefault();
    
    var $ = jQuery;
    
    this.trashed = true;
    this.inside.remove();
    
    this.button = { };
    this.view = { };
    this.inside = null;
    
    var template = wp.template( "cf-field-icon" );
    var $ = jQuery;
    var data = null;

    var field_type = this.field.type;

    $.each(_WPADVERTS_CF_FIELDS, function(index, item) {
        if(item.type == field_type) {
            data = item;
        }
    });
    
    data.name = this.field.name;
    data.builtin = this.field.meta.cf_builtin;
    
    var visual = $(template(data));
    
    visual.find(".wpadverts-cf-field-delete").click($.proxy(this.dialog, this));
    visual.draggable({
        connectToSortable: "#wpadverts-custom-fields-editor",
    });
    
    this.inside = visual;
    
    $("#wpadverts-custom-fields-trash").append(visual);
    
};

WPADVERTS.CF.Field.prototype.dialog = function(e) {
    e.preventDefault();
 
    jQuery( "#wpadverts-cf-dialog-delete-field strong" ).text(this.field.name);
 
    jQuery( "#wpadverts-cf-dialog-delete-field" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: [
            {
                text: wpadverts_custom_fields_editor.delete,
                click: jQuery.proxy(this.delete, this)
            }, 
            {
                text: wpadverts_custom_fields_editor.cancel,
                click: function() {
                    jQuery( this ).dialog( "close" );
                }
            }
        ]
    });



};

WPADVERTS.CF.Field.prototype.delete = function(e) {
    
    jQuery( "#wpadverts-cf-dialog-delete-field" ).dialog( "close" );
    
    var input = this;
    var i = null;
    
    jQuery.each(WPADVERTS.CF.input, function(index, item) {
        if(item === input) {
            i = index;
        }
    });
    
    if(i !== null ) {
        WPADVERTS.CF.input.splice(i, 1);
        this.inside.fadeOut("fast");
    }
};

WPADVERTS.CF.Options = function(field, data) {
    this.field = field;
    this.data = data;
    this.button = {
        
    };
    
    this.button.fillMethod = field.find("select[name=cf_options_fill_method]");
    this.button.addOption = field.find(".wpacf-multiselect-options-add-action");
    this.button.useValues = field.find("#wpacf-multiselect-use-values");
    this.button.emptyOption = field.find("#wpacf-empty-option");
    
    this.button.fillMethod.on("change", jQuery.proxy(this.fillMethod, this));
    this.button.fillMethod.change();
    
    this.button.addOption.on("click", jQuery.proxy(this.addOption, this));
    
    this.button.useValues.on("change", jQuery.proxy(this.useValues, this));
    this.button.useValues.change();
    
    this.field.find( ".wpacf-multiselect-options" ).sortable({
      handle: ".wpadverts-multiselect-option-drag"
    });
    this.field.find(".wpadverts-multiselect-option-trash").on("click", function(e) {
        e.preventDefault();
        jQuery(this).closest("li").remove();
    });
    
    if(this.button.emptyOption) {
        this.button.emptyOption.on("change", jQuery.proxy(this.emptyOption, this));
        this.button.emptyOption.change();
    }
    

};

WPADVERTS.CF.Field.prototype.dataStoreSuccess = function(response) {
    WPADVERTS.CF.DataStore[this.field.meta.cf_data_source] = response.data;
    if(this.trashed === false) {
        this.reload();
    }
};

WPADVERTS.CF.Options.prototype.dataStoreError = function(response) {
    
};

WPADVERTS.CF.Options.prototype.fillMethod = function() {
    var value = this.button.fillMethod.val();
    
    this.field.find(".wpacf-multiselect-options-predefined").hide();
    this.field.find(".wpacf-multiselect-options-callback").hide();
    
    if(value === "data") {
        this.field.find(".wpacf-multiselect-options-predefined").show();
        this.field.find(".wpacf-multiselect-options-callback").hide();
    } 
    
    if(value === "callback" ) {
        this.field.find(".wpacf-multiselect-options-predefined").hide();
        this.field.find(".wpacf-multiselect-options-callback").show();
    }
};

WPADVERTS.CF.Options.prototype.addOption = function(e) {
    e.preventDefault();
    
    var template = this.field.find(".wpacf-multiselect-options-template > li").clone();
    
    template.sortable({
        handle: ".wpadverts-multiselect-option-drag"
    });
    template.find(".wpadverts-multiselect-option-trash").on("click", function(e) {
        e.preventDefault();
        jQuery(this).closest("li").remove();
    });
    
    var options = this.field.find(".wpacf-multiselect-options");
            
    options.append(template);
    
    if(options.hasClass("wpacf-multiselect-uses-values")) {
        template.find(".wpadverts-multiselect-option-value").focus();
    } else {
        template.find(".wpadverts-multiselect-option-text").focus();
    }
    
    options.scrollTop(options.prop("scrollHeight"));
    
};

WPADVERTS.CF.Options.prototype.useValues = function() {
    if(this.button.useValues.is(":checked")) {
        this.field.find(".wpacf-multiselect-options").addClass("wpacf-multiselect-uses-values");
    } else {
        this.field.find(".wpacf-multiselect-options").removeClass("wpacf-multiselect-uses-values");
    }
};

WPADVERTS.CF.Options.prototype.emptyOption = function() {
    if(this.button.emptyOption.is(":checked")) {
        this.field.find(".wpacf-empty-option-text").show();
    } else {
        this.field.find(".wpacf-empty-option-text").hide();
    }
};

jQuery(function($) {
    
    // Load Input Types
    $.each(_WPADVERTS_CF_FIELDS, function(index, item) {
        
        if(typeof item.is_replicable !== 'undefined' && !item.is_replicable) {
            return true;
        }
        
        var template = wp.template( "cf-field-icon" );
        var $ = jQuery;

        var visual = $(template(item));
        
        
        $("#wpadverts-custom-fields-basic-fields").append(visual);
    });
    
    $("#wpadverts-custom-fields-editor" ).droppable();
    $("#wpadverts-custom-fields-editor").sortable({
        revert: true,
        stop: function(e, ui) {
            
            if(!ui.item.hasClass("wpadverts-custom-fields-input-template")) {
                return;
            }
            
            var input = null;
            
            if(ui.item.data("name")) {
                // restore from trash
                input = WPADVERTS.CF.getInput(ui.item.data("name"));
                input.trashed = false;
            } else {
                // create new
                var field = ui.item.data("field");
                input = new WPADVERTS.CF.Field("#wpadverts-custom-fields-editor", {
                    type: ui.item.data("field")
                });
                WPADVERTS.CF.input.push(input);
            }
            
            ui.item.replaceWith(input.render());
        }
    });
    
    $( "#wpadverts-custom-fields-basic-fields > li" ).draggable({
        connectToSortable: "#wpadverts-custom-fields-editor",
        helper: "clone",
        revert: "invalid"
    });
    
    $( "#wpadverts-custom-fields-trash > li" ).draggable({
        connectToSortable: "#wpadverts-custom-fields-editor",
        helper: "clone",
        revert: "invalid"
    });
    
    var sorter = [];
    
    $.each(_WPADVERTS_CF_FORM.field, function(index, item) {
        
        if( typeof item.meta === 'undefined' ) {
            item.meta = {};
        }
        
        if( typeof item.meta.cf_saved === 'undefined' ) {
            item.meta.cf_saved = true;
        }
        
        if( typeof item.meta.cf_builtin === 'undefined' ) {
            item.meta.cf_builtin = true;
        }
        
        var input = new WPADVERTS.CF.Field("#wpadverts-custom-fields-editor", item);
       
        WPADVERTS.CF.input.push(input);

        sorter.push({
            index: index,
            order: parseInt(input.field.order)
        });


    });
   
    sorter.sort(function(a, b) {
        return a.order - b.order;
    });
    
    $.each(sorter, function(index, item) {
        var input = WPADVERTS.CF.input[item.index];
        input.render();
        $("#wpadverts-custom-fields-editor").append(input.inside);
    });
    
    if(typeof _WPADVERTS_CF_FORM.trash !== "undefined") {
        $.each(_WPADVERTS_CF_FORM.trash, function(index, item) {
            var input = new WPADVERTS.CF.Field("#wpadverts-custom-fields-editor", item);

            WPADVERTS.CF.input.push(input);

            input.render();
            input.button.trash.click();
        });
    }
    
    $("#wpadverts-custom-fields-save").on("click", WPADVERTS.CF.Save.click);
    $(".wpadverts-cf-from-delete").on("click", WPADVERTS.CF.Delete.dialog);
    

    if(jQuery(".wpadverts-cf-uses-from-layout").length > 0) {
        $("#wpadverts-cf-form-layout-aligned").on("change", WPADVERTS.CF.SetLayout);
        $("#wpadverts-cf-form-layout-stacked").on("change", WPADVERTS.CF.SetLayout);
        WPADVERTS.CF.SetLayout();
    }
    
});


