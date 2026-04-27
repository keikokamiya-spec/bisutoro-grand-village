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
    jQuery('.flexslider').flexslider({
        animation   : "slide",
        directionNav: true,
        prevText    : "",
        nextText    : ""
    });
    // DropMenu
    jQuery('#menu_bars').click(function() {
        jQuery('.header_menu').slideToggle('fast');
        jQuery("#menu_bars").toggleClass("menu_bars_close");
        if($('#wpadminbar').length){
             $('.header_menu').css('top', '116px' );
        }
    });

    jQuery('#fixed_header .header_menu a').on('click', function() {
        var href = jQuery(this).attr('href');
        if (href && href !== '#' && href.indexOf('tel:') !== 0) {
            window.location.href = href;
        }
    });

    jQuery('a.gallery').magnificPopup({
        //delegate: 'a', // ポップアップを開く子要素
        type: 'image',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        }, 
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
