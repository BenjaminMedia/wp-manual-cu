(function( $ ) {
    $(function() {
        var defaultBannerPosition = 2200;
        var defaultOffset = 0;

        $.stickybanners = function(elements) {
            defaultOffset = elements.offset().top;
            $(document).on('scroll', function() {
                elements.each(function() {
                    var el = $(this);
                    if($(window).scrollTop() > defaultOffset && el.hasClass('static')) {
                        el.css({ 'top': 0 }).removeClass('static');
                    }

                    if($(window).scrollTop() < defaultOffset && !el.hasClass('static')) {
                        el.addClass('static');
                    }
                });
            });
        };

        var el = $('[data-listen="sticky-banner"]');
        if(el.children().length && $(document).height() > defaultBannerPosition) {
            $.stickybanners(el);
        } else {
            el.hide();
        }
    });
})(jQuery);