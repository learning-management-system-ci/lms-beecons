$('textarea').keypress(function (e) {
    if (e.which == 13) {
        var control = e.target;
        var controlHeight = $(control).height();
        //add some height to existing height of control, I chose 17 as my line-height was 17 for the control    
        $(control).height(controlHeight + 17);
    }
});

$('textarea').blur(function (e) {
    var textLines = $(this).val().trim().split(/\r*\n/).length;
    $(this).val($(this).val().trim()).height(textLines * 17);
});

(function ($) {

    // jQuery plugin definition
    $.fn.TextAreaExpander = function (minHeight, maxHeight) {

        // var hCheck = !($.browser.msie || $.browser.opera);

        // resize a textarea
        function ResizeTextarea(e) {

            // event or initialize element?
            e = e.target || e;

            // find content length and box width
            var vlen = e.value.length, ewidth = e.offsetWidth;
            if (vlen != e.valLength || ewidth != e.boxWidth) {

                if ((vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "0px";
                var h = Math.max(e.expandMin, Math.min(e.scrollHeight, e.expandMax));

                e.style.overflow = (e.scrollHeight > h ? "auto" : "hidden");
                e.style.height = h + "px";

                e.valLength = vlen;
                e.boxWidth = ewidth;
            }

            return true;
        };

        // initialize
        this.each(function () {

            // is a textarea?
            if (this.nodeName.toLowerCase() != "textarea") return;

            // set height restrictions
            var p = this.className.match(/expand(\d+)\-*(\d+)*/i);
            this.expandMin = minHeight || (p ? parseInt('0' + p[1], 10) : 0);
            this.expandMax = maxHeight || (p ? parseInt('0' + p[2], 10) : 99999);

            // initial resize
            ResizeTextarea(this);

            // zero vertical padding and add events
            if (!this.Initialized) {
                this.Initialized = true;
                $(this).css("padding-top", 0).css("padding-bottom", 0);
                $(this).bind("keyup", ResizeTextarea).bind("focus", ResizeTextarea);
            }
        });

        return this;
    };

})(jQuery);

jQuery(document).ready(function () {
    jQuery("textarea[class*=expand]").TextAreaExpander();
});