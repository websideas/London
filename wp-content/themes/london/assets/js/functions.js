(function($){
    "use strict"; // Start of use strict
    
    
    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    
    $(window).load(function(){
        
        // Page loader
        $(".page-loader div").delay(0).fadeOut();
        $(".page-loader").delay(200).fadeOut("slow");
        
        $(window).trigger("scroll");
        $(window).trigger("resize");
        
        // Hash menu forwarding
        if (window.location.hash){
            var hash_offset = $(window.location.hash).offset().top;
            $("html, body").animate({
                scrollTop: hash_offset
            });
        }
        
        
        
    });
    
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        
        $(window).trigger("resize");
        
        init_shortcodes();
        init_carousel();
        init_backtotop();
        init_mailchimp();
        init_MainMenu();
        init_ProductQuickView();
        init_SaleCountDown();
        init_gridlistToggle();
        init_desingerCollection();
        $('form.woocommerce-ordering select').customSelect();
        
        
        
        
        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
             
        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            navigation: false,
            pagination:false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200,
        });
        
        sync2.owlCarousel({
            theme : 'woocommerce-thumbnails',
            items : 3,
            itemsCustom : [[768,3],[479,2]],
            navigation: true,
            navigationText: false,
            pagination:false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
                el.find(".owl-item").eq(0).addClass("synced");
                //el.find(".owl-wrapper").equalHeights();
            }
        });
        
        function syncPosition(el){
            var current = this.currentItem;
            $("#sync2")
                .find(".owl-item")
                .removeClass("synced")
                .eq(current)
                .addClass("synced")
            if($("#sync2").data("owlCarousel") !== undefined){
                center(current)
            }
        }
        
        $("#sync2").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });
        
        
        function center(number){
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            
            var num = number;
            var found = false;
            
            for(var i in sync2visible){
                if(num === sync2visible[i]){
                    var found = true;
                }
            }
            
            if(found===false){
                if(num>sync2visible[sync2visible.length-1]){
                    sync2.trigger("owl.goTo", num - sync2visible.length+2)
                }else{
                    if(num - 1 === -1){
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if(num === sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if(num === sync2visible[0]){
                sync2.trigger("owl.goTo", num-1)
            }
        }
        
    });
    
    $(window).resize(function(){
        /**==============================
        ***  Sticky header
        ===============================**/
        $('#header.sticky-header').ktSticky();
    });
    
    
    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes(){
        "use strict";
        
        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').tooltip();
        
        if ($.fn.fitVids) {
            // Responsive video
            $(".video, .resp-media, .post-media").fitVids();
            $(".work-full-media").fitVids();
        }
        
        $('.post-media-video video').mediaelementplayer();
        
        // Responsive audio
        $('.post-media-audio audio').mediaelementplayer();
        
        $( ".products-tabs" ).tabs();
        
    }
    /* ---------------------------------------------
     Mailchimp
     --------------------------------------------- */
    function init_mailchimp(){
        $('.mailchimp-form').submit(function(e){
            e.preventDefault();
            var mForm = $(this),
                button = mForm.find('.mailchimp-submit'),
                error = mForm.find('.mailchimp-error').fadeOut(),
                success = mForm.find('.mailchimp-success').fadeOut();
            
            var data = {
                action: 'frontend_mailchimp',
                security : ajax_frontend.security,
                email: mForm.find('input[name=email]').val(),
                list_id: mForm.find('input[name=list_id]').val(),
                opt_in: mForm.find('input[name=opt_in]').val()
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                if(response.error == '1'){
                    error.html(response.msg).fadeIn();
                }else{
                    success.fadeIn();
                }
            });
        });
    }
    /* ---------------------------------------------
     Desinger collection carousel
     --------------------------------------------- */
    function init_desingerCollection(){
        $('a.desinger-collection-link').on('click',function(e){
            e.preventDefault();
            
            var $desinger = $(this),
                $wrapper = $desinger.closest('.desinger-collection-wrapper'),
                $carousel = $wrapper.find('ul.products'),
                $carouselData = $carousel.data('owlCarousel');
            
            $desinger.addClass('loading');
            
            var data = {
                action: 'frontend_desinger_collection',
                security : ajax_frontend.security,
                desinger_id : $desinger.data('id')
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $desinger.removeClass('loading');
                for (i = $carouselData.itemsAmount-1 ; i >= 0; i--) { 
                    $carouselData.removeItem(i);
                }
                $.each( response, function( i, val ) {
                    $carouselData.addItem(val);
                });
            }, 'json');
        });
    }
    
    
    /* ---------------------------------------------
     Grid list Toggle
     --------------------------------------------- */
    function init_gridlistToggle(){
        $('ul.gridlist-toggle a').on('click', function(e){
            e.preventDefault();
            var $this = $(this),
                $gridlist = $this.closest('.gridlist-toggle'),
                $products = $this.closest('#main').find('ul.products');
                
            $gridlist.find('a').removeClass('active');
            $this.addClass('active');
            $products
                .removeClass($this.data('remove'))
                .addClass($this.data('layout'));
                
        });
    }
    
    /* ---------------------------------------------
     Product Quick View
     --------------------------------------------- */
    function init_ProductQuickView(){
        $('.product-quick-view').on('click', function(e){
            e.preventDefault();
            var objProduct = $(this);
            
            var data = {
                action: 'frontend_product_quick_view',
                security : ajax_frontend.security,
                product_id: objProduct.data('id')
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $.magnificPopup.open({
    				items: {
    					src: '<div class="themedev-product-popup">' + response + '</div>',
    					type: 'inline'
    				}
    			});
                setTimeout( function() {
                    
                    jQuery('.single-product-quickview-images').owlCarousel({
    					theme: "owl-carousel-navigation-center",
    					singleItem: true,
    					autoHeight: true,
    					navigation: true,
    					navigationText: false,
    					pagination: false
    				});
                }, 500 );
                
            });
            
            
        });
    }
    
    /* ---------------------------------------------
     MEGA MENU
    --------------------------------------------- */
    function init_MainMenu(){
        $("nav#main-nav ul.menu").superfish({
            hoverClass: 'hovered',
            popUpSelector: 'ul.sub-menu-dropdown,.kt-megamenu-wrapper',
            animation: {},
    		animationOut: {}
        });
    }
    
    /* ---------------------------------------------
     Back to top
     --------------------------------------------- */
    function init_backtotop(){
    	var backtotop = $('#backtotop').hide();
    	$(window).scroll(function() {
    		($(window).scrollTop() != 0) ? backtotop.fadeIn() : backtotop.fadeOut();  
    	});
    	backtotop.click(function(e) {
            e.preventDefault();
    		$('html, body').animate({scrollTop:0},500);
    	});
    }
    
    /* ---------------------------------------------
     Sale Count Down
     --------------------------------------------- */
    function init_SaleCountDown(){
        
        $('.woocommerce-countdown').each(function(){
            
            var $this = $(this), 
                finalDate = $(this).data('time');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime(''
                     + '<div><span>%D</span> days</div>'
                     + '<div><span>%H</span> hr</div>'
                     + '<div><span>%M</span> min</div>'
                     + '<div><span>%S</span> sec</div>'));
            });
            
        });
    }
    
    
    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){
            var objCarousel = $(this),
                    owlItems = objCarousel.data('items'),
                    owlNavigation = objCarousel.data('navigation'),
                    owlPagination = objCarousel.data('pagination'),
                    owlAutoheight = objCarousel.data('autoheight'),
                    owlAutoPlay = objCarousel.data('autoplay'),
                    owlTheme = objCarousel.data('theme'),
                    owlitemsCustom = objCarousel.data('itemscustom'),
                    owlSingleItem = true;
                
                
            if(typeof owlNavigation === "undefined"){
                owlNavigation = true;
            }
            if(typeof owlPagination === "undefined"){
                owlPagination = true;
            }
            if(typeof owlAutoheight === "undefined"){
                owlAutoheight = true;
            }
            if(typeof owlAutoPlay === "undefined"){
                owlAutoPlay = false;
            }
            if(typeof owlitemsCustom === "undefined"){
                owlitemsCustom = false;
            }else{
                owlSingleItem = false;
            }
            if(typeof owlTheme === "undefined"){
                owlTheme = 'owl-theme';
            }
            
            
            if(typeof owlItems === "undefined"){
                owlItems = 1;
            }else{
                owlItems = parseInt(owlItems, 10);
                owlSingleItem = false;
            }
            
            
            var options = {
                items: owlItems,
                slideSpeed: 350,
                singleItem: owlSingleItem,
                pagination: owlPagination,
                autoHeight: owlAutoheight,
                navigation: owlNavigation,
                navigationText: false,
                theme: owlTheme,
                autoPlay: owlAutoPlay,
                stopOnHover: true,
                itemsCustom: owlitemsCustom,
                afterUpdate: function(elem) {
                    /*if (elem.closest(".isotope-container").length > 0) {
                        elem.closest(".isotope-container").isotope("layout");
                    }*/
                }
            };
            objCarousel.owlCarousel(options);
            
        });
        
        
        // Related, Up Sells Carousel
        $('.woocommerce-carousel-wrapper').each(function(){
            var carouselWrapper = $(this),
                wooCarousel = $(this).find('ul.products'),
                wooCarouselTheme = carouselWrapper.data('theme');
            
            if(typeof wooCarouselTheme === "undefined"){
                wooCarouselTheme = 'style-navigation-top';
            }
            
            wooCarousel.owlCarousel({
    			theme: wooCarouselTheme,
    			items : 1,
                itemsCustom: carouselWrapper.data('itemscustom'),
    			autoHeight: false,
    			navigation: true,
    			navigationText: false,
    			pagination: false
    		});
            
        })
        
        
        
    }
    
})(jQuery); // End of use strict
