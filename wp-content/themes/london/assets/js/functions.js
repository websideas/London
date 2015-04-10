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
            if($(window.location.hash).length){
                var hash_offset = $(window.location.hash).offset().top;
                $("html, body").animate({
                    scrollTop: hash_offset
                });
            }
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
        
        init_carouselwoo();
        init_productcarouselwoo();
        init_woocategories_products();
        
        $('form.woocommerce-ordering select').customSelect();
        
        
        
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
        
        $( ".category-products-tab-wrapper" ).tabs();
        
        $( ".categories-top-sellers-wrapper" ).tabs();
        
    }
    /* ---------------------------------------------
     Mailchimp
     --------------------------------------------- */
    function init_mailchimp(){
        $('.mailchimp-form').submit(function(e){
            e.preventDefault();
            var $mForm = $(this),
                $button = $mForm.find('.mailchimp-submit'),
                $error = $mForm.find('.mailchimp-error').fadeOut(),
                $success = $mForm.find('.mailchimp-success').fadeOut();
            
            $button.addClass('loading').html($button.data('loading'));
            
            var data = {
                action: 'frontend_mailchimp',
                security : ajax_frontend.security,
                email: $mForm.find('input[name=email]').val(),
                list_id: $mForm.find('input[name=list_id]').val(),
                opt_in: $mForm.find('input[name=opt_in]').val()
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $button.removeClass('loading').html($button.data('text'));
                
                if(response.error == '1'){
                    $error.html(response.msg).fadeIn();
                }else{
                    $success.fadeIn();
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
                for (var i = $carouselData.itemsAmount-1 ; i >= 0; i--) { 
                    $carouselData.removeItem(i);
                }
                $.each( response, function( i, val ) {
                    $carouselData.addItem(val);
                });
            }, 'json');
        });
    }
    
    function init_woocategories_products(){
        $('.categories-products-lists > ul li a').on('click',function(e){
            e.preventDefault();
        	var obj = $(this),
                objul = obj.closest('ul'),
                $wrapper = obj.closest('.categories-products-wrapper'),
                $carousel = $wrapper.find('ul.products'),
                $carouselData = $carousel.data('owlCarousel');
        	
            obj.addClass('loading');
        	objul.find('li').removeClass('active');
        	obj.closest('li').addClass('active');
        	
        	var data = {
        		action: 'fronted_woocategories_products',
        		security : ajax_frontend.security,
        		cat_id: obj.data('id'),
                per_page : objul.data('per_page'),
        		orderby: objul.data('orderby'),
        		order: objul.data('order')
        	};
        	
        	$.post(ajax_frontend.ajaxurl, data, function(response) {
        		obj.removeClass('loading');
                for (var i = $carouselData.itemsAmount-1 ; i >= 0; i--) { 
                    $carouselData.removeItem(i);
                }
                $.each( response, function( i, val ) {
                    $carouselData.addItem(val);
                });
        	}, 'json');
        	
        	return false;
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
        $('body').on('click', '.product-quick-view', function(e){
            e.preventDefault();
            var objProduct = $(this);
            objProduct.addClass('loading');
            var data = {
                action: 'frontend_product_quick_view',
                security : ajax_frontend.security,
                product_id: objProduct.data('id')
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                objProduct.removeClass('loading');
                $.magnificPopup.open({
    				items: {
    					src: '<div class="themedev-product-popup woocommerce">' + response + '</div>',
    					type: 'inline'
    				},
                    callbacks: {
    	        		open: function() {
    	        		     $('.single-product-quickview-images').owlCarousel({
            					theme: "style-navigation-center",
            					singleItem: true,
            					autoHeight: true,
            					navigation: true,
            					navigationText: false,
            					pagination: false
            				});
    	        			$('.themedev-product-popup form').wc_variation_form();
    	        		},
    	        		change: function() {	        			
    	        			$('.themedev-product-popup form').wc_variation_form();
    	        		}
    	        	},
    			});
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
     Owl carousel woo
     --------------------------------------------- */
    function init_carouselwoo(){
        
        $('.woocommerce-carousel-wrapper').each(function(){
            var carouselWrapper = $(this),
                wooCarousel = $(this).find('ul.products'),
                wooCarouselTheme = carouselWrapper.data('theme'),
                wooAutoPlay = carouselWrapper.data('autoplay'),
                wooitemsCustom = carouselWrapper.data('itemscustom'),
                wooSlideSpeed = carouselWrapper.data('slidespeed'),
                wooNavigation = carouselWrapper.data('navigation'),
                wooPagination = carouselWrapper.data('pagination');
            
            if(typeof wooCarouselTheme === "undefined"){
                wooCarouselTheme = 'style-navigation-center';
            }
            if(typeof wooAutoPlay === "undefined"){
                wooAutoPlay = false;
            }
            if(typeof wooSlideSpeed === "undefined"){
                wooSlideSpeed = '200';
            }
            if(typeof wooPagination === "undefined"){
                wooPagination = true;
            }
            if(typeof wooNavigation === "undefined"){
                wooNavigation = true;
            }
            
            wooCarousel.owlCarousel({
    			theme: wooCarouselTheme,
    			items : 1,
                autoPlay: wooAutoPlay,
                itemsCustom: wooitemsCustom,
    			autoHeight: false,
    			navigation: true,
    			navigationText: false,
                slideSpeed: wooSlideSpeed,
    			pagination: wooPagination,
                afterInit : function(elem){ 
                    if(wooCarouselTheme == 'style-navigation-top'){
                        var that = this;
                        that.owlControls.addClass('carousel-heading-top').prependTo(elem.closest('.carousel-wrapper-top'))
                    }
                }
    		});
        });
    }
    function init_productcarouselwoo(){
        
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
        
        $("#sync2").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

    }
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
    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){
            var objCarousel = $(this),
                    owlItems = objCarousel.data('items'),
                    owlPagination = objCarousel.data('pagination'),
                    owlAutoheight = objCarousel.data('autoheight'),
                    owlNavigation = objCarousel.data('navigation'),
                    owlAutoPlay = objCarousel.data('autoplay'),
                    owlTheme = objCarousel.data('theme'),
                    owlitemsCustom = objCarousel.data('itemscustom'),
                    owlSlideSpeed = objCarousel.data('slidespeed'),
                    owlSingleItem = true;
                
                
            if(typeof owlNavigation === "undefined"){
                owlNavigation = true;
            }
            if(typeof owlAutoheight === "undefined"){
                owlAutoheight = true;
            }
            if(typeof owlPagination === "undefined"){
                owlPagination = true;
            }
            if(typeof owlAutoPlay === "undefined"){
                owlAutoPlay = false;
            }
            if(typeof owlSlideSpeed === "undefined"){
                owlSlideSpeed = '200';
            }
            if(typeof owlitemsCustom === "undefined"){
                owlitemsCustom = false;
            }else{
                owlSingleItem = false;
            }
            if(typeof owlTheme === "undefined"){
                owlTheme = 'style-navigation-center';
            }
            
            
            if(typeof owlItems === "undefined"){
                owlItems = 1;
            }else{
                owlItems = parseInt(owlItems, 10);
                owlSingleItem = false;
            }
            
            var options = {
                items: owlItems,
                slideSpeed: owlSlideSpeed,
                singleItem: owlSingleItem,
                pagination: owlPagination,
                autoHeight: owlAutoheight,
                navigation: owlNavigation,
                navigationText: false,
                theme: owlTheme,
                autoPlay: owlAutoPlay,
                stopOnHover: true,
                itemsCustom: owlitemsCustom,
                afterInit : function(elem){ 
                    if(owlTheme == 'style-navigation-top'){
                        var that = this;
                        that.owlControls.addClass('carousel-heading-top').prependTo(elem.closest('.carousel-wrapper-top'))
                    }
                },
                afterUpdate: function(elem) {
                    /*if (elem.closest(".isotope-container").length > 0) {
                        elem.closest(".isotope-container").isotope("layout");
                    }*/
                }
            };
            objCarousel.owlCarousel(options);
            
        });
    }
    
})(jQuery); // End of use strict
