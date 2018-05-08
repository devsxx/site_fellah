// Init global namespace
var WPADVERTS = WPADVERTS || {};
WPADVERTS.CF = WPADVERTS.CF || {};

WPADVERTS.CF.PostTypeScheme = function( sectionSelector ) {
    
    this.selected = null;
    this.selector = sectionSelector;
    
    var wrap = jQuery(this.selector);
    
    this.button = {
        edit: wrap.find(".edit-form-scheme-id"),
        ok: wrap.find(".save-form-scheme-id"),
        cancel: wrap.find(".cancel-form-scheme-id")
    };
    
    this.select = wrap.find("#form-scheme-id-select");
    this.input = wrap.find("#wpacf_form_scheme_id");
    this.display = wrap.find("#wpacf-form-scheme-id-display");
    
    this.hidden = {
        id: wrap.find("#_form_scheme_id"),
        name: wrap.find("#_form_scheme")
    };
    
    this.button.edit.click( jQuery.proxy( this.edit, this) );
    this.button.ok.click( jQuery.proxy( this.ok, this) );
    this.button.cancel.click( jQuery.proxy( this.cancel, this) );
};

WPADVERTS.CF.PostTypeScheme.prototype.edit = function(e) {
    e.preventDefault();
    
    this.button.edit.hide();
    this.select.show();
    
    this.selected = this.input.val();
};

WPADVERTS.CF.PostTypeScheme.prototype.cancel = function(e) {
    e.preventDefault();
    
    this.button.edit.show();
    this.select.hide();
    
    this.input.val(this.selected);
    
    this.selected = null;
};

WPADVERTS.CF.PostTypeScheme.prototype.ok = function(e) {
    if(typeof e !== 'undefined') {
        e.preventDefault();
    }
    
    this.button.edit.show();
    this.select.hide();
    
    this.selected = null;
    
    this.display.text(this.input.find(":selected").data("title"));
    
    this.hidden.id.val(this.input.find(":selected").val());
    this.hidden.name.val(this.display.text());
};

jQuery(function($) {
    
    new WPADVERTS.CF.PostTypeScheme(".wpacf-form-scheme-wrap").ok();
   
});