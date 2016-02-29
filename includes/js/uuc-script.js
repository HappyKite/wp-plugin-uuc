(function ($) {
    "use strict";

    var default_color = 'bfbfbf';

    function pickColor(color) {
        $('#background-color').val(color);
    }
    function toggle_text() {
        var background_color = $('#background-color');
        if(background_color.val() == undefined || '' === background_color.val().replace('#', '')) {
            background_color.val(default_color);
            pickColor(default_color);
        } else {
            pickColor(background_color.val());
        }
    }

    $(document).ready(function () {
        var background_color = $('#background-color');
        background_color.wpColorPicker({
            change: function (event, ui) {
                pickColor(background_color.wpColorPicker('color'));
            },
            clear: function () {
                pickColor('');
            }
        });
        $('#background-color').click(toggle_text);

        toggle_text();

    });

}(jQuery));

(function($) {
    
    $(document).on( 'click', '.nav-tab-wrapper a', function() {
        $('section').hide();
        $('section').eq($(this).index()).show();
        return false;
    })

    jQuery('.uuc_tolltip').tooltip({ 
        track: true, 
        delay: 0, 
        showURL: false, 
        showBody: " - ", 
        fade: 250 
    });
    
})( jQuery );