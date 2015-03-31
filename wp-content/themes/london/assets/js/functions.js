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
        
        
        /**==============================
        ***  Sticky header
        ===============================**/
        
        $('form.woocommerce-ordering select').customSelect();
        
        
        // Related, Up Sells Carousel
        $('.related-carousel ul, .upsells-carousel ul, .cross-sells-carousel ul').owlCarousel({
			theme: "style-opaque-box arrows-at-hover",
			items : 4,
			itemsDesktopSmall: [979, 3],
			itemsTablet: [768, 3],
			itemsMobile: [479, 1],
			autoHeight: false,
			navigation: true,
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			pagination: false
		});
        
        
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
    }
    /* ---------------------------------------------
     Mailchimp
     --------------------------------------------- */
    function init_mailchimp(){
        $('.mailchimp-form').submit(function(e){
            e.preventDefault();
            var mForm = $(this),
                button = mForm.find('.mailchimp-submit'),
                loading = mForm.find('.mailchimp-loading').fadeIn(),
                loadingIcon = loading.find('i'),
                error = mForm.find('.mailchimp-error').fadeOut(),
                success = mForm.find('.mailchimp-success').fadeOut();
            
            button.find('span').eq(0).css({ 'visibility': 'hidden'});
            button.find('.btn-loading').show();
            
            var data = {
                action: 'frontend_mailchimp',
                security : ajax_frontend.security,
                email: mForm.find('input[name=email]').val(),
                name: mForm.find('input[name=name]').val(),
                list_id: mForm.find('input[name=list_id]').val(),
                opt_in: mForm.find('input[name=opt_in]').val()
            };
            
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                
                button.find('span').eq(0).css({ 'visibility': 'visible'});
                button.find('.btn-loading').hide();
                
                var data = $.parseJSON(response);
                if(data.error == '1'){
                    error.html(data.msg).fadeIn();
                }else{
                    success.fadeIn();
                }
            });
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
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.owl-carousel-theme').each(function(){
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
                autoHeight: true,
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
    }
    
})(jQuery); // End of use strict
