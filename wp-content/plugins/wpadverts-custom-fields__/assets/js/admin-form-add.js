// Credit https://gist.github.com/mathewbyrne/1280286

function wpadverts_custom_fields_slugify(text) {
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

jQuery(function($){
    $("input#form_title").keyup(function() {
        var $this = $(this);
        var name = $("input#form_name");
        
        if(name.val().length === 0) {
            $this.data("blur", null);
        }
        
        if($this.data("blur") === "1") {
            return;
        }
        
        name.val( wpadverts_custom_fields_slugify( $this.val() ) );
    });
    
    $("input#form_title").blur(function() {
        var $this = $(this);
        
        $this.data("blur", "1");
    });
});