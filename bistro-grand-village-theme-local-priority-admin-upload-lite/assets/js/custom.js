// Fade images
jQuery(function($) {
  $(".mouseonfade img").hover(function() {
    $(this).stop().animate({
      opacity: "0.6"
    }, "5000");
  }, function() {
    $(this).stop().animate({
      opacity: "1.0"
    }, "100");
  });

  if ($("#top_cover .flexslider").length) {
    $("#top_cover .flexslider").flexslider({
      animation: "fade",
      slideshow: true,
      slideshowSpeed: 5000,
      animationSpeed: 800,
      pauseOnHover: true,
      controlNav: false,
      directionNav: false
    });
  }

  $(".flexslider").not("#top_cover .flexslider, .gallery-carousel").flexslider({
    animation: "slide",
    directionNav: true,
    prevText: "",
    nextText: ""
  });

  var $galleryCarousel = $(".gallery-carousel");
  if ($galleryCarousel.length) {
    var $galleryStatus = $(".home-gallery-status span");
    var updateGalleryStatus = function(slider, currentIndex) {
      if (!$galleryStatus.length) {
        return;
      }

      var total = slider && slider.count ? slider.count : $galleryCarousel.find(".slides > li:not(.clone)").length;
      var current = typeof currentIndex === "number"
        ? currentIndex
        : (slider && typeof slider.currentSlide === "number" ? slider.currentSlide + 1 : 1);

      $galleryStatus.text(current + " / " + total);
    };

    updateGalleryStatus(null, 1);
    $galleryCarousel.flexslider({
      animation: "fade",
      slideshow: true,
      slideshowSpeed: 3600,
      animationSpeed: 900,
      animationLoop: true,
      smoothHeight: true,
      controlNav: false,
      directionNav: false,
      pauseOnHover: false,
      prevText: "",
      nextText: "",
      before: function(slider) {
        updateGalleryStatus(slider, slider.animatingTo + 1);
      },
      start: function(slider) {
        updateGalleryStatus(slider);
      },
      after: function(slider) {
        updateGalleryStatus(slider);
      }
    });
  }

  $("#menu_bars").on("click", function() {
    var $menu = $(".header_menu");
    var $nav = $("#fixed_header nav");
    var isOpen = $menu.hasClass("open");

    $menu.toggleClass("open", !isOpen);
    $nav.toggleClass("open", !isOpen);
    $("body").toggleClass("menu-open", !isOpen);
    $(this).attr("aria-expanded", !isOpen);
    $(this).toggleClass("menu_bars_close", !isOpen);
  });

  $("#fixed_header .header_menu a").on("click", function() {
    $(".header_menu").removeClass("open");
    $("#fixed_header nav").removeClass("open");
    $("body").removeClass("menu-open");
    $("#menu_bars").attr("aria-expanded", "false").removeClass("menu_bars_close");
  });

  $("#fixed_header nav").on("click", function(e) {
    if ($(e.target).closest(".header_menu").length) {
      return;
    }
    $(".header_menu").removeClass("open");
    $("#fixed_header nav").removeClass("open");
    $("body").removeClass("menu-open");
    $("#menu_bars").attr("aria-expanded", "false").removeClass("menu_bars_close");
  });

  $(".gallery-carousel .slides, .gallery-stack-grid, .single-page.pg-gal > ul").magnificPopup({
    delegate: "li:not(.clone) > a.gallery",
    type: "image",
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1],
      tCounter: "%curr% / %total%"
    }
  });

  $(".single-page .menu, .linked-food-items").magnificPopup({
    delegate: "dt > a.gallery",
    type: "image",
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1],
      tCounter: "%curr% / %total%"
    }
  });

  $(".photos-slider").each(function() {
    var $track = $(this);
    var $slides = $track.children("li, figure");
    var $status = $('<div class="gallery-slider-status" aria-hidden="true"><span>1 / ' + $slides.length + "</span></div>");
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
        var $slide = $(this);
        var slideCenter = $slide.offset().left + ($slide.outerWidth() / 2);
        var distance = Math.abs(trackCenter - slideCenter);

        if (distance < closestDistance) {
          closestDistance = distance;
          activeIndex = index;
        }
      });

      $status.find("span").text((activeIndex + 1) + " / " + $slides.length);
      ticking = false;
    }

    $track.on("scroll", function() {
      if (!ticking) {
        window.requestAnimationFrame(updateStatus);
        ticking = true;
      }
    });

    $(window).on("resize", updateStatus);
    updateStatus();
  });

  var ambienceCarousel = document.querySelector(".home-ambience-carousel");
  var ambiencePrev = document.querySelector(".home-ambience-carousel__arrow--prev");
  var ambienceNext = document.querySelector(".home-ambience-carousel__arrow--next");
  var ambienceCount = document.querySelector(".home-ambience-carousel__count span");
  var ambienceTrack = document.querySelector(".home-ambience-carousel__track");
  var ambienceSlides = ambienceTrack ? ambienceTrack.children : [];

  function updateAmbienceCarouselState() {
    if (!ambienceCarousel || !ambienceSlides.length) {
      return;
    }

    var slideWidth = ambienceCarousel.clientWidth;
    if (!slideWidth) {
      return;
    }

    var currentIndex = Math.round(ambienceCarousel.scrollLeft / slideWidth) + 1;
    currentIndex = Math.max(1, Math.min(currentIndex, ambienceSlides.length));

    if (ambienceCount) {
      ambienceCount.textContent = currentIndex + " / " + ambienceSlides.length;
    }
    if (ambiencePrev) {
      ambiencePrev.disabled = currentIndex <= 1;
    }
    if (ambienceNext) {
      ambienceNext.disabled = currentIndex >= ambienceSlides.length;
    }
  }

  function moveAmbienceCarousel(direction) {
    if (!ambienceCarousel || !ambienceSlides.length) {
      return;
    }

    var slideWidth = ambienceCarousel.clientWidth;
    if (!slideWidth) {
      return;
    }

    var currentIndex = Math.round(ambienceCarousel.scrollLeft / slideWidth);
    var nextIndex = Math.max(0, Math.min(currentIndex + direction, ambienceSlides.length - 1));

    ambienceCarousel.scrollTo({
      left: nextIndex * slideWidth,
      behavior: "smooth"
    });
  }

  if (ambienceCarousel) {
    updateAmbienceCarouselState();

    if (ambiencePrev) {
      ambiencePrev.addEventListener("click", function() {
        moveAmbienceCarousel(-1);
      });
    }
    if (ambienceNext) {
      ambienceNext.addEventListener("click", function() {
        moveAmbienceCarousel(1);
      });
    }

    ambienceCarousel.addEventListener("scroll", function() {
      window.requestAnimationFrame(updateAmbienceCarouselState);
    });

    window.addEventListener("resize", function() {
      window.requestAnimationFrame(updateAmbienceCarouselState);
    });
  }

  $(window).on("scroll", function() {
    if ($(this).scrollTop() > 10) {
      $("#fixed_header").addClass("scrolled");
    } else {
      $("#fixed_header").removeClass("scrolled");
    }
  });

  function checkLazy() {
    $(".lazy").each(function() {
      if ($(window).scrollTop() + $(window).height() > $(this).offset().top + 60) {
        $(this).addClass("on");
      }
    });
  }

  $(window).on("load scroll resize", checkLazy);
  checkLazy();

  var instagramWidget = document.querySelector("#home_instagram behold-widget");
  var instagramFeedShell = document.querySelector("#home_instagram .instagram-feed-shell");
  var instagramMobileCarousel = document.querySelector("#home_instagram .instagram-mobile-carousel");
  var instagramMobileTrack = document.querySelector("#home_instagram .instagram-mobile-carousel__track");
  var instagramMobilePrev = document.querySelector("#home_instagram .instagram-mobile-carousel__arrow--prev");
  var instagramMobileNext = document.querySelector("#home_instagram .instagram-mobile-carousel__arrow--next");
  var instagramMobileCount = document.querySelector("#home_instagram .instagram-mobile-carousel__count span");
  var instagramFeedId = instagramWidget ? instagramWidget.getAttribute("feed-id") : null;
  var instagramMobileLoaded = false;
  var instagramMobilePostCount = 0;

  function isMobileInstagramCarousel() {
    return window.matchMedia("(max-width: 767px)").matches;
  }

  function setInstagramMobileState(enabled) {
    if (!instagramFeedShell) {
      return;
    }
    instagramFeedShell.classList.toggle("instagram-mobile-carousel-ready", enabled);
  }

  function updateInstagramMobileCount(current, total) {
    if (!instagramMobileCount) {
      return;
    }
    instagramMobileCount.textContent = current + " / " + total;
  }

  function updateInstagramMobileArrows(current, total) {
    if (!instagramMobilePrev || !instagramMobileNext) {
      return;
    }
    instagramMobilePrev.disabled = current <= 1;
    instagramMobileNext.disabled = current >= total;
  }

  function renderInstagramMobileSlides(posts) {
    if (!instagramMobileTrack) {
      return;
    }

    instagramMobileTrack.innerHTML = "";
    instagramMobilePostCount = posts.length;

    posts.forEach(function(post, index) {
      var imageUrl = post.sizes && post.sizes.large ? post.sizes.large.mediaUrl : post.mediaUrl;
      var slide = document.createElement("div");
      var link = document.createElement("a");
      var image = document.createElement("img");

      slide.className = "instagram-mobile-carousel__item";
      link.href = post.permalink;
      link.target = "_blank";
      link.rel = "noopener";
      link.setAttribute("aria-label", "Instagram投稿" + (index + 1) + "を見る");

      image.src = imageUrl;
      image.alt = "Instagram投稿 " + (index + 1);
      image.loading = index === 0 ? "eager" : "lazy";

      link.appendChild(image);
      slide.appendChild(link);
      instagramMobileTrack.appendChild(slide);
    });

    updateInstagramMobileCount(1, instagramMobilePostCount);
    updateInstagramMobileArrows(1, instagramMobilePostCount);
  }

  function syncInstagramMobileCountFromScroll() {
    if (!instagramMobileCarousel || !instagramMobilePostCount) {
      return;
    }

    var slideWidth = instagramMobileCarousel.clientWidth;
    if (!slideWidth) {
      return;
    }

    var currentIndex = Math.round(instagramMobileCarousel.scrollLeft / slideWidth) + 1;
    currentIndex = Math.max(1, Math.min(currentIndex, instagramMobilePostCount));
    updateInstagramMobileCount(currentIndex, instagramMobilePostCount);
    updateInstagramMobileArrows(currentIndex, instagramMobilePostCount);
  }

  function moveInstagramMobileCarousel(direction) {
    if (!instagramMobileCarousel || !instagramMobilePostCount) {
      return;
    }

    var slideWidth = instagramMobileCarousel.clientWidth;
    if (!slideWidth) {
      return;
    }

    var currentIndex = Math.round(instagramMobileCarousel.scrollLeft / slideWidth);
    var nextIndex = Math.max(0, Math.min(currentIndex + direction, instagramMobilePostCount - 1));

    instagramMobileCarousel.scrollTo({
      left: nextIndex * slideWidth,
      behavior: "smooth"
    });
  }

  async function ensureInstagramMobileCarousel() {
    if (!instagramFeedId || !instagramMobileCarousel) {
      return;
    }

    if (!isMobileInstagramCarousel()) {
      setInstagramMobileState(false);
      return;
    }

    if (instagramMobileLoaded) {
      setInstagramMobileState(true);
      return;
    }

    try {
      var response = await fetch("https://feeds.behold.so/" + instagramFeedId, { mode: "cors" });
      if (!response.ok) {
        throw new Error("Instagram feed request failed");
      }

      var feed = await response.json();
      var posts = (feed.posts || []).slice(0, 10);

      if (!posts.length) {
        setInstagramMobileState(false);
        return;
      }

      renderInstagramMobileSlides(posts);
      instagramMobileLoaded = true;
      setInstagramMobileState(true);
    } catch (error) {
      setInstagramMobileState(false);
    }
  }

  if (instagramWidget && instagramMobileCarousel) {
    ensureInstagramMobileCarousel();
    if (instagramMobilePrev) {
      instagramMobilePrev.addEventListener("click", function() {
        moveInstagramMobileCarousel(-1);
      });
    }
    if (instagramMobileNext) {
      instagramMobileNext.addEventListener("click", function() {
        moveInstagramMobileCarousel(1);
      });
    }
    instagramMobileCarousel.addEventListener("scroll", function() {
      window.requestAnimationFrame(syncInstagramMobileCountFromScroll);
    });
    window.addEventListener("resize", function() {
      window.requestAnimationFrame(function() {
        ensureInstagramMobileCarousel();
        syncInstagramMobileCountFromScroll();
      });
    });
  }
});

jQuery(window).on("load", function() {
  jQuery(".js-masonry").masonry({
    itemSelector: ".item"
  });
});
