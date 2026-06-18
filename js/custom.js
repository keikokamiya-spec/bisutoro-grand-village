//Fade images
jQuery(function() {
    jQuery(".mouseonfade img").hover(function() {
        jQuery(this).stop().animate({
            opacity: "0.6"
        }, '5000');
    },
    function() {
        jQuery(this).stop().animate({
            opacity: "1.0"
        }, '100');
    });
    // FlexSlider
    jQuery('.flexslider').not('.gallery-carousel').flexslider({
        animation   : "slide",
        directionNav: true,
        prevText    : "",
        nextText    : ""
    });
    // DropMenu
    jQuery('#menu_bars').on('click', function() {
        var $menu = jQuery('.header_menu');
        var $nav = jQuery('#fixed_header nav');
        var isOpen = $menu.hasClass('open');

        $menu.toggleClass('open', !isOpen);
        $nav.toggleClass('open', !isOpen);
        jQuery('body').toggleClass('menu-open', !isOpen);
        jQuery(this).attr('aria-expanded', !isOpen);

        if (isOpen) {
            jQuery(this).removeClass('menu_bars_close');
        } else {
            jQuery(this).addClass('menu_bars_close');
        }
    });

    jQuery('#fixed_header .header_menu a').on('click', function() {
        jQuery('.header_menu').removeClass('open');
        jQuery('#fixed_header nav').removeClass('open');
        jQuery('body').removeClass('menu-open');
        jQuery('#menu_bars').attr('aria-expanded', 'false').removeClass('menu_bars_close');
    });

    jQuery('#fixed_header nav').on('click', function(e) {
        if (jQuery(e.target).closest('.header_menu').length) {
            return;
        }
        jQuery('.header_menu').removeClass('open');
        jQuery('#fixed_header nav').removeClass('open');
        jQuery('body').removeClass('menu-open');
        jQuery('#menu_bars').attr('aria-expanded', 'false').removeClass('menu_bars_close');
    });

    jQuery('.gallery-carousel .slides').magnificPopup({
        delegate: 'li:not(.clone) > a.gallery',
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1],
            tCounter: '%curr% / %total%'
        }
    });

    jQuery('.photos-slider').each(function() {
        var $track = jQuery(this);
        var $slides = $track.children('li, figure');
        var $status = jQuery('<div class="gallery-slider-status" aria-hidden="true"><span>1 / ' + $slides.length + '</span></div>');
        var ticking = false;

        if (!$slides.length) {
            return;
        }

        $track.after($status);

        function updateStatus() {
            var trackLeft = $track.offset().left;
            var trackCenter = trackLeft + ($track.outerWidth() / 2);
            var activeIndex = 0;
            var closestDistance = Infinity;

            $slides.each(function(index) {
                var $slide = jQuery(this);
                var slideCenter = $slide.offset().left + ($slide.outerWidth() / 2);
                var distance = Math.abs(trackCenter - slideCenter);

                if (distance < closestDistance) {
                    closestDistance = distance;
                    activeIndex = index;
                }
            });

            $status.find('span').text((activeIndex + 1) + ' / ' + $slides.length);
            ticking = false;
        }

        $track.on('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateStatus);
                ticking = true;
            }
        });

        jQuery(window).on('resize', updateStatus);
        updateStatus();
    });
});

// ロード時とスクロール時
jQuery(window).on('load scroll',function(){
    // 要素が画面内に来た時にonクラスを付与
    jQuery('.lazy').each(function(){
        var elemPos = jQuery(this).offset().top;
        var scroll = jQuery(window).scrollTop();
        var windowHeight = jQuery(window).height();
        if (scroll > elemPos - windowHeight){
            jQuery(this).addClass('on');
        }
    });
});

//Masonryはページロード後にする
jQuery(window).on('load',function(){
    jQuery('.js-masonry').masonry({
      // options
      itemSelector: '.item',
    });
});
