var gl_path = '';
function include(scriptUrl) {
    if (gl_path.length == 0) {
        gl_path = jQuery('#gl_path').html()
    }
    document.write('<script src="' + gl_path + scriptUrl + '"></script>');
}

/* Easing library
 ========================================================*/
include('js/jquery.easing.1.3.min.js');

/* ToTop
 ========================================================*/
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop')) {
        include('js/jquery.ui.totop.js');

        $(document).ready(function () {
            $().UItoTop({easingType: 'easeOutQuart'});
        });
    }
})(jQuery);


/* SMOOTH SCROLLING
 ========================================================*/

/* Removed because it creates awful scrolling!
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop')) {
        include('js/jquery.mousewheel.min.js');
        include('js/jquery.simplr.smoothscroll.min.js');
        $(document).ready(function () {
            $.srSmoothscroll({
                step: 120,
                speed: 800
            });
        });
    }
})(jQuery);
*/

/* Stick up menus
 ========================================================*/
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop')) {
        include('js/tmstickup.js');

        $(window).load(function () {
            $('.menu-wrap').TMStickUp({})
        });
    }
})(jQuery);

/* Unveil
 ========================================================*/
(function ($) {
    var o = $('.lazy img');

    if (o.length > 0) {
        include('js/jquery.unveil.js');

        $(document).ready(function () {
            $(o).unveil(0, function () {
                $(this).load(function () {
                    $(this).parent().addClass("lazy-loaded");
                })
            });
        });

        $(window).load(function () {
            $(window).trigger('lookup.unveil');
        });

    }
})(jQuery);

/* Elevate zoom
 ========================================================*/
(function ($) {
    var o = $('#gallery_zoom');
    if (o.length > 0) {
        include('js/elavatezoom/jquery.elevatezoom.js');
        $(document).ready(function () {
            o.bind("click", function (e) {
                var ez = o.data('elevateZoom');
                $.fancybox(ez.getGalleryList());
                return false;
            });

            o.elevateZoom({
                gallery: 'image-additional',
                cursor: 'pointer',
                zoomType: 'inner',
                galleryActiveClass: 'active',
                imageCrossfade: true
            });
        });
    }
})(jQuery);

/* Bx Slider
 ========================================================*/
(function ($) {
    var o = $('#image-additional');
    var o2 = $('#gallery');
    if (o.length || o2.length) {
        include('js/jquery.bxslider/jquery.bxslider.js');
    }

    if (o.length) {
        $(document).ready(function () {
            $('#image-additional').bxSlider({
			pager:false,
			controls:true,
			slideMargin:10,
			minSlides: 3,
			maxSlides: 3,
			slideWidth:70,
			infiniteLoop:false,
			moveSlides:1
			});
        });
    }

    if (o2.length) {
        include('js/photo-swipe/klass.min.js');
        include('js/photo-swipe/code.photoswipe.jquery-3.0.5.js');
        include('js/photo-swipe/code.photoswipe-3.0.5.min.js');
        $(document).ready(function () {
            $('#gallery').bxSlider({
                pager: false,
                controls: true,
                minSlides: 1,
                maxSlides: 1,
                infiniteLoop: false,
                moveSlides: 1
            });
        });
    }

})(jQuery);

/* FancyBox
 ========================================================*/
(function ($) {
    var o = $('.quickview');
    var o2 = $('#default_gallery');
    if (o.length > 0 || o2.length > 0) {
        include('js/fancybox/jquery.fancybox.pack.js');
    }

    if (o.length) {
        $(document).ready(function () {
            o.fancybox({
                maxWidth: 800,
                maxHeight: 600,
                fitToView: false,
                width: '70%',
                height: '70%',
                autoSize: false,
                closeClick: false,
                openEffect: 'elastic',
                closeEffect: 'elastic'
            });
        });
    }

})(jQuery);

/* Superfish menus
 ========================================================*/
(function ($) {
    include('js/superfish.min.js');
    $(window).load(function () {
        $('#tm_menu .menu').superfish();
    });
})(jQuery);


/* Google Map
 ========================================================*/
(function ($) {
    var o = document.getElementById("google-map");
    if (o) {
        document.write('<script src="//maps.google.com/maps/api/js?sensor=false"></script>');
        include('js/jquery.rd-google-map.js');

        $(document).ready(function () {
            var o = $('#google-map');
            if (o.length > 0) {
                o.googleMap({
                    marker: {
                        basic: gl_path + 'image/gmap_marker.png',
                        active: gl_path + 'image/gmap_marker_active.png'
                    },
                    styles: [
                        {
                            "featureType": "landscape",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 65
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 51
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 30
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 40
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative.province",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -100
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "hue": "#ffff00"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -97
                                }
                            ]
                        }
                    ]
                });
            }
        });
    }
})
(jQuery);

/* Owl Carousel
 ========================================================*/
(function ($) {
    var o = $('.related-slider');
    if (o.length > 0) {
        include('js/owl.carousel.min.js');
        $(document).ready(function () {
            o.owlCarousel({
                smartSpeed: 450,
                dots: false,
                nav: true,
                loop: true,
                margin: 30,
                navClass: ['owl-prev fa fa-angle-left', 'owl-next fa fa-angle-right'],
                responsive: {
                    0: {items: 2},
                    768: {items: 4},
                    992: {items: 4},
                    1199: {items: 5}
                }
            });
        });
    }
})(jQuery);

/* GREEN SOCKS
 ========================================================*/
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop') && o.find('body').hasClass('common-home')) {
        include('js/greensock/jquery.gsap.min.js');
        include('js/greensock/TimelineMax.min.js');
        include('js/greensock/TweenMax.min.js');
        include('js/greensock/jquery.scrollmagic.min.js');
    }
})(jQuery);

/* Swipe Menu
 ========================================================*/
(function ($) {
    $(document).ready(function () {
        $('#page').click(function () {
            if ($(this).parents('body').hasClass('ind')) {
                $(this).parents('body').removeClass('ind');
                return false
            }
        });

        $('.swipe-control').click(function () {
            if ($(this).parents('body').hasClass('ind')) {
                $(this).parents('body').removeClass('ind');
                $(this).removeClass('active');
                return false
            }
            else {
                $(this).parents('body').addClass('ind');
                $(this).addClass('active');
                return false
            }
        })
    });

})(jQuery);

/* EqualHeights
 ========================================================*/
(function ($) {
    var o = $('[data-equal-group]');
    if (o.length > 0) {
        include('js/jquery.equalheights.js');
    }
})(jQuery);

   $(document).ready(function() {

        // Dock the header to the top of the window when scrolled past the banner.
        // This is the default behavior.

        $('#tm_menu').scrollToFixed();

       // Dock the footer to the bottom of the page, but scroll up to reveal more
        // content if the page is scrolled far enough.
        // Dock each summary as it arrives just below the docked header, pushing the
        // previous summary up the page.

        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];

            summary.scrollToFixed({
                marginTop: $('#tm_menu').outerHeight(true) + 10,
                limit: function() {
                    var limit = 0;
                    if (next) {
                        limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                    } 
                    return limit;
                },
                zIndex: 999
            });
        });

       var win = $(window),
           affixed = false;

       if (win.width() >= 768) {
           affixProductPriceBox();
           affixed = true;
       }

       win.resize(function() {
           if (win.width() < 768) {
               win.off('.affix');
               $(".product-page-right")
                   .removeClass("affix affix-top affix-bottom")
                   .removeData("bs.affix");
               affixed = false;
           } else {
               affixProductPriceBox();
               affixed = true;
           }
       });


    });

function affixProductPriceBox() {
    // Let the pricing, options and purchase box on product page follow the content
    $('.product_page-right').affix({
        offset: {
            top: function() {
                var top = $('.product_page-left').offset().top - 60;
                return top;
            },
            bottom: function() {
                var bottom = $('body').outerHeight(true) - $('#tab-specification').offset().top +60;
                return bottom;
            }
        }
    });
}

$(document).ready(function () {
    /***********CATEGORY DROP DOWN****************/
    $("#menu-icon").on("click", function () {
        $("#menu-gadget .menu").slideToggle();
        $(this).toggleClass("active");
    });

    $('#menu-gadget .menu').find('li>ul').before('<i class="fa fa-angle-down"></i>');
    $('#menu-gadget .menu li i').on("click", function () {
        if ($(this).hasClass('fa-angle-up')) {
            $(this).removeClass('fa-angle-up').parent('li').find('> ul').slideToggle();
        }
        else {
            $(this).addClass('fa-angle-up').parent('li').find('> ul').slideToggle();
        }
    });
    if ($('.breadcrumb').length) {
        var o = $('.breadcrumb li:last-child');
        var str = o.find('a').html();
        o.find('a').css('display', 'none');
        o.append('<span>' + str + '</span>');
    }

});

var flag = true;

function respResize() {
    var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

    if ($('aside').length) {
        var leftColumn = $('aside');
    } else {
        return false;
    }


    if (width > 767) {
        if (!flag) {
            flag = true;
            leftColumn.insertBefore('#content');
            $('.col-sm-3 .box-heading').unbind("click");

            $('.col-sm-3 .box-content').each(function () {
                if ($(this).is(":hidden")) {
                    $(this).slideToggle();
                }
            })
        }
    } else {
        if (flag) {
            flag = false;
            leftColumn.insertAfter('#content');

            $('.col-sm-3 .box-content').each(function () {
                if (!$(this).is(":hidden")) {
                    $(this).parent().find('.box-heading').addClass('active');
                }
            });

            $('.col-sm-3 .box-heading').bind("click", function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active').parent().find('.box-content').slideToggle();
                }
                else {
                    $(this).addClass('active');
                    $(this).parent().find('.box-content').slideToggle();
                }
            })
        }
    }
}

$(window).resize(function () {
    clearTimeout(this.id);
    this.id = setTimeout(respResize, 500);
});

$(window).load(function () {
    var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var o = $('.featured');
    if (o.length) {
        if (width > 1199) {
            $('.featured .product-thumb').hover(function () {
                $(this).height($(this).height() + 45);
            }, function () {
                $(this).height($(this).height() - 45);
            });
        }
    }
});

var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);

/***********************************/
if (!isMobile) {
    /***********************Green Sock*******************************/

    $(document).ready(function () {
        var stickMenu = false;
        var docWidth = $('body').find('.container').width();
        // init controller
        //controller = new ScrollMagic();
    });


    function listBlocksAnimate(block, element, row, offset, difEffect) {
        if ($(block).length) {
            var i = 0;
            var j = row;
            var k = 1;
            var effect = -1;

            $(element).each(function () {
                i++;

                if (i > j) {
                    j += row;
                    k = i;
                    effect = effect * (-1);
                }

                if (effect == -1 && difEffect == true) {
                    ef = TweenMax.from(element + ':nth-child(' + i + ')', 0.5, {
                        left: -1 * 200 - i * 300 + "px",
                        alpha: 0,
                        ease: Power1.easeOut
                    })

                } else {
                    ef = TweenMax.from(element + ':nth-child(' + i + ')', 0.5, {
                        right: -1 * 200 - i * 300 + "px",
                        alpha: 0,
                        ease: Power1.easeOut
                    })
                }

                var scene_new = new ScrollScene({
                    triggerElement: element + ':nth-child(' + k + ')',
                    offset: offset,
                }).setTween(ef)
                    .addTo(controller)
                    .reverse(false);
            });
        }
    }

    function listTabsAnimate(element) {
        if ($(element).length) {
            TweenMax.staggerFromTo(element, 0.3, {alpha: 0, rotationY: -90, ease: Power1.easeOut}, {
                alpha: 1,
                rotationY: 0,
                ease: Power1.easeOut
            }, 0.1);
        }
    }

    $(window).load(function () {
        //if ($(".fluid_container").length) {
        //    var welcome = new TimelineMax();
        //
        //    welcome.from(".fluid_container h2", 0.5, {top: -300, autoAlpha: 0})
        //        .from(".fluid_container h4", 0.5, {bottom: -300, autoAlpha: 0});
        //
        //    var scene_welcome = new ScrollScene({
        //        triggerElement: ".fluid_container",
        //        offset: -100
        //    }).setTween(welcome).addTo(controller).reverse(false);
        //}
    });
}

$(window).load(function () {
    //if ($('.icon-box').length) {
    //    $('.icon-box h3').equalHeights();
    //}
    //if ($(".product-thumb .name").length && !$('body').hasClass('common-home')) {
    //    $(".product-thumb .name").equalHeights();
    //}
});

