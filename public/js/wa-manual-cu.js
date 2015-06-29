(function( $ ) {
    $(function() {
        var defaultOffsets = [];
        var maxScrolls = [];

        $.stickybanners = function(elements) {
            $.each(elements, function() {
                var container = $($(this).data('container'));
                var offset = $(this).offset().top;

                defaultOffsets.push(offset);

                var max = 0;
                var container = $(this).data('container');
                if(container != '') {
                    container = $(container);
                    if(container.length > 0) {
                        max = (container.offset().top + container.outerHeight()) - $(this).outerHeight();
                    }
                }

                maxScrolls.push(max);
            });

            var checkBanner = function() {
                elements.each(function(i) {
                    var el = $(this);
                    var defaultOffset = defaultOffsets[i];
                    var maxScroll = maxScrolls[i];

                    if(maxScroll > 0) {
                        if($(window).scrollTop() > maxScroll && !el.hasClass('max')) {
                            el.removeClass('fixed').addClass('max');
                        }

                        if($(window).scrollTop() < maxScroll && el.hasClass('max')) {
                            el.removeClass('max');
                        }
                    }

                    if($(window).scrollTop() < defaultOffset && el.hasClass('fixed')) {
                        el.removeClass('fixed');
                    }

                    if($(window).scrollTop() > defaultOffset && !el.hasClass('fixed') && !el.hasClass('max')) {
                        el.addClass('fixed');
                    }
                });
            };

            $(document).off('scroll.stickybanners').on('scroll.stickybanners', function() {
                checkBanner();
            });

            // Initialize so it displays banners when offset < scroll
            checkBanner();
        };

        $.stickybanners($('[data-listen="sticky-banner"]'));

        $(window).off('resize.stickybanners').on('resize.stickybanners', function() {
            $.stickybanners($('[data-listen="sticky-banner"]'));
        });
    });
})(jQuery);