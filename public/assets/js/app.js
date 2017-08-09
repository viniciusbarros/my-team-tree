jQuery(document).ready(function () {
    jQuery(document).foundation();
});


 jQuery(window).bind("load", function () {
    var footer = jQuery("#footer");
    var pos = footer.position();
    var height = jQuery(window).height();
    height = height - pos.top;
    height = height - footer.height();
    if (height > 0) {
        footer.css({
            'margin-top': height + 'px'
        });
    }
});