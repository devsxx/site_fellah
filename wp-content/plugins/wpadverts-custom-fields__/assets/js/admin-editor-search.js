WPADVERTS.CF.Field.prototype.visual = function() {
    var template = wp.template( this.template );
    var $ = jQuery;
    
    if(typeof this.field.meta.search_type === 'undefined') {
        this.field.meta.search_type = "half";
    }
    
    var visual = $(template(this.field));

    this.search = new WPADVERTS.CF.Search(visual);
    
    if(this.field.meta.search_type === "half") {
        visual.addClass("wpacf-visual-half");
        visual.removeClass("wpacf-visual-full");
    } else {
        visual.addClass("wpacf-visual-full");
        visual.removeClass("wpacf-visual-half");
    }
    
    return visual;
};

WPADVERTS.CF.Search = function(visual) {
    this.field = visual;
    
    this.defaults = visual.find(".wpacf-search-defaults");
    this.date = visual.find(".wpacf-search-date");
    this.taxonomy = visual.find(".wpacf-search-taxonomy");
    this.meta = visual.find(".wpacf-search-meta");
    
    this.defaults.hide();
    this.date.hide();
    this.taxonomy.hide();
    this.meta.hide();
    
    this.field.find(".wpacf-madlib-text").on("click", function(e) {
        e.preventDefault();
        var $this = jQuery(this).closest(".wpacf-madlib-wrap");
        
        $this.find(".wpacf-madlib-suggest").show();
    });
    this.field.find(".wpacf-madlib-suggest > li").on("click", function(e) {
        e.preventDefault();
        var $this = jQuery(this).closest(".wpacf-madlib-wrap");
        
        $this.find(".wpacf-madlib-suggest").hide();
        $this.find(".wpacf-madlib-text > strong").text(jQuery(this).text());
        $this.find(".wpacf-madlib-value").val(jQuery(this).data("value"));
    });
    
    this.field.find(".wpacf-madlib-value").each(function(index, item) {
        var $this = jQuery(item);
        
        if($this.val() !== "") {
            var wrap = $this.closest(".wpacf-madlib-wrap");
            var label = wrap.find(".wpacf-madlib-suggest > li[data-value="+$this.val()+"]").text();
            wrap.find(".wpacf-madlib-text > strong").text(label);
        }
        
    });
    
    var f = this.field.find("select[name=cf_search_field]");
    f.on("change", jQuery.proxy( this.searchField, this ) );
    f.change();
};

WPADVERTS.CF.Search.prototype.searchField = function() {
    var sf = this.field.find("select[name=cf_search_field]").val();
    var split = sf.split("__");
    
    this.defaults.hide();
    this.date.hide();
    this.taxonomy.hide();
    this.meta.hide();
    
    if( sf.length > 0 ) {
        this[split[0]].show();
        this.field.find(".wpacf-search-field-label").text(this.field.find("select[name=cf_search_field] option:selected").text());
    }
    
};

WPADVERTS.CF.Save.collect = function(index, item) {
    var data = item.field;
    
    data.meta.cf_saved = 1;
    
    var sep = parseInt(jQuery(".wpacf-visual-search-separator").index()) * 1;
    
    if(item.trashed) {
        this.trash.push(data);
    } else {
        data.order = parseInt(item.inside.index()) * 1;
        
        if(sep > data.order) {
            data.meta.search_group = "visible";
        } else {
            data.meta.search_group = "hidden";
        }
        
        this.field.push(data);
    }
};


jQuery(function($) {
    var template = wp.template("cf-visual-search-separator");
    var visual = $(template({}));
    
    var inserted = false;
    var j = null;
    var order = null;
    
    $.each(WPADVERTS.CF.input, function(index, item) {
        if(item.field.meta.search_group == "hidden" && !item.trashed) {
            if(order === null || item.field.order < order) {
                order = item.field.order;
                j = index;
            }
        }
    });
    
    if(j === null) {
        $("#wpadverts-custom-fields-editor").append(visual);
    } else {
        WPADVERTS.CF.input[j].inside.before(visual);
    }
    

});