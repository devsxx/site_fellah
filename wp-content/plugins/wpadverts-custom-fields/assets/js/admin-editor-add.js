WPADVERTS.CF.Field.prototype.visual = function() {
    var template = wp.template( this.template );
    var $ = jQuery;
    
    var visual = $(template(this.field));

    this.display = new WPADVERTS.CF.Display(visual);
    
    return visual;
};

WPADVERTS.CF.Display = function(visual) {
    this.field = visual;
    
    this.button = { };
    this.button.icon = this.field.find(".wpacf-action-select-icon");
    
    this.input = { };
    this.input.display = this.field.find("select[name=cf_display]");
    this.input.type = this.field.find("input[name=cf_display_type]");
    
    if(this.button.icon.length > 0) {
        this.button.icon.click( jQuery.proxy(this.icon, this) );
    }
    
    if(this.input.display.length > 0) {
        this.input.display.change( jQuery.proxy(this.changeDisplay, this) );
        this.changeDisplay();
    }
    
    if(this.input.type.length > 0) {
        this.input.type.click( jQuery.proxy(this.changeType, this) );
        this.changeType();
    }
};

WPADVERTS.CF.Display.prototype.icon = function(e) {
    e.preventDefault();
    
    WPADVERTS.CF.IconPicker.reset();
    WPADVERTS.CF.IconPicker.setSelected(this.field.find("input[name=cf_display_icon]").val());
    

    jQuery( "#wpadverts-cf-dialog-select-icon" ).dialog({
        resizable: false,
        height: 400,
        width: 800,
        modal: true,
        buttons: [
            {
                text: wpadverts_custom_fields_editor.ok,
                click: jQuery.proxy(this.iconSelect, this),
            }, 
            {
                text: wpadverts_custom_fields_editor.cancel,
                click: function() {
                    jQuery( this ).dialog( "close" );
                }
            }
        ]
    });
    
    var scrollTo = WPADVERTS.CF.IconPicker.picker.find("a.button-primary");
    var scrollWrap = jQuery("#wpadverts-cf-dialog-select-icon");

    scrollWrap.scrollTop(scrollTo.offset().top - scrollWrap.offset().top + scrollWrap.scrollTop() - 20);
    
};

WPADVERTS.CF.Display.prototype.iconSelect = function(e) {
    e.preventDefault();
    
    var selected = WPADVERTS.CF.IconPicker.getSelected();
    
    this.field.find("input[name=cf_display_icon]").val(selected);
    this.field.find(".wpacf-action-select-icon").html("");
    
    if(selected.length > 0) {
        this.field.find(".wpacf-action-select-icon").html('<span class="adverts-icon-'+selected+'"></span>');
    } else {
        this.field.find(".wpacf-action-select-icon").html(wpadverts_custom_fields_editor.select_icon);
    }
    
    jQuery( "#wpadverts-cf-dialog-select-icon" ).dialog("close");
};

WPADVERTS.CF.Display.prototype.changeDisplay = function() {
    if(this.input.display.val() !== "anywhere") {
        this.field.find(".wpacf-field-display-type").hide();
        this.field.find(".wpacf-field-display-as").hide();
        this.field.find(".wpacf-field-display-style").hide();
        this.field.find(".wpacf-field-display-icon").hide();
    } else {
        this.field.find(".wpacf-field-display-type").show();
        this.field.find(".wpacf-field-display-as").show();
        this.field.find(".wpacf-field-display-style").show();
        this.field.find(".wpacf-field-display-icon").show();
    }
};

WPADVERTS.CF.Display.prototype.changeType = function() {
    var checked = null;
    jQuery.each(this.input.type, function(index, item) {
        if(jQuery(item).is(":checked")) {
            checked = jQuery(item).val();
            return false;
        }
    });
    
    if(checked == "table-row") {
        this.field.find(".wpacf-field-display-icon").show();
    } else {
        this.field.find(".wpacf-field-display-icon").hide();
    }
    
};

WPADVERTS.CF.IconPicker = {
    
    picker: null,
    
    input: null,
    
    init: function() {
       WPADVERTS.CF.IconPicker.picker = jQuery(".wpadverts-custom-fields-icon-picker");
       WPADVERTS.CF.IconPicker.picker.find("a").click( WPADVERTS.CF.IconPicker.select );
       
       WPADVERTS.CF.IconPicker.input = jQuery("#wpadverts-custom-fields-icon-filter");
       WPADVERTS.CF.IconPicker.input.keyup( WPADVERTS.CF.IconPicker.filter );
       WPADVERTS.CF.IconPicker.input.change( WPADVERTS.CF.IconPicker.filter );
       
    },
    
    select: function(e) {
        e.preventDefault();
        WPADVERTS.CF.IconPicker.setSelected(jQuery(this).data("name"));
    },
    
    filter: function(e) {
        var $this = jQuery(this).val();
        
        jQuery.each(WPADVERTS.CF.IconPicker.picker.find("li"), function(index, item) {
            if(jQuery(item).find("a").data("name").indexOf($this) === -1 ) {
                jQuery(item).hide();
            } else {
                jQuery(item).show();
            }
        });
    },
    
    reset: function() {
        
        WPADVERTS.CF.IconPicker.input.val("");
        
        jQuery.each(WPADVERTS.CF.IconPicker.picker.find("li"), function(index, item) {
            jQuery(item).show();
        });
    },
    
    getSelected: function() {
        var selected = WPADVERTS.CF.IconPicker.picker.find(".button-primary");
        
        if(selected.length > 0) {
            return selected.data("name");
        } else {
            return "";
        }
    },
    
    setSelected: function(name) {
        WPADVERTS.CF.IconPicker.picker.find("a").addClass("button-secondary").removeClass("button-primary");
        
        
        var selected = WPADVERTS.CF.IconPicker.picker.find("a[data-name='" + name + "']");
        var response = "";
        
        if(selected.length > 0) {
            selected.addClass("button-primary");
            response = name;
        } 
        
        return response;
    }
};

jQuery(function($) {
    WPADVERTS.CF.IconPicker.init();
});