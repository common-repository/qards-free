(function ($) {
    $(function () {
        $('a[href*="#"]:not([href="#"]):not(.link-to)').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var _target = this.hash,
                    target = $(_target),
                    topNavbar = $('.menu.sticky'),
                    topNavbarHeight = topNavbar.length ? topNavbar.outerHeight(true) : 0;
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length && target.is(':visible')) {
                    var offset = target.offset().top - topNavbarHeight;
                    if(offset<0) offset=0;
                    $('html,body').stop().animate({
                        scrollTop: offset
                    }, 1000, 'swing',function () {
                        window.location.hash=_target;
                    });
                    return false;
                }
            }
        });
    });
})(jQuery);