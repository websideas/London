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
        
    });
    
    
    $(window).resize(function(){
        $('#header.sticky-header').ktSticky();
    });
    
    
})(jQuery); // End of use strict
