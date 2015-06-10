jQuery(document).ready(  function(){

    var ds_actions =  function(){


        ///--------CHANGE SITE SKIN---------
        jQuery('.ds-chang-skin').each(function(){
            var c = jQuery(this).attr('data-bg') || '';
            if( !typeof c != undefined && c!='' ) {
                jQuery(this).css('background-color', c);
            }
        });

        jQuery('.ds-chang-skin').click(function(){
            var skin_url =  jQuery(this).attr('href');

            jQuery('.ds-chang-skin').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('#kt-theme-custom-css').remove();

            if( skin_url =='' || skin_url =='#' ){
                jQuery('link#ds-skin').remove();
            }else{
                if( jQuery('link#ds-skin').length > 0 ){
                    jQuery('link#ds-skin').attr( 'href', skin_url );
                }else{
                    jQuery('head').append("<link id='ds-skin' rel='stylesheet' href='"+skin_url+"' type='text/css' media='all' />");
                }
            }
            return false;
        });


        ///--------CHANGE SITE MOD---------
        jQuery('.ds-site-mod').click(function(){
            jQuery('.ds-site-mod').removeClass('active');
            jQuery(this).addClass('active');

            var mod = jQuery(this).attr('data-mod') || '';
            jQuery('body').removeClass('layout-boxed');
            jQuery('body').addClass(mod);
            jQuery(window).resize();
            jQuery('.ds-site-bg.active').click();
            return false;
        });
        ///------ CHANGE SITE BG------------
        jQuery('.ds-site-bg').click(function(){
            if( ! jQuery('body').hasClass('layout-boxed') ){
                jQuery('body').attr('style', '');
                return false;
            }
            jQuery('.ds-site-bg').removeClass('active');
            jQuery(this).addClass('active');
            var s = jQuery(this).attr('data-style') || '';
            jQuery('body').attr('style', s);
            jQuery(window).resize();
            return false;
        });
        ///---------DS PANEL---------
        jQuery(window).resize( function(){
            var wh = jQuery(window).height();
            var ds =  jQuery('.ds');
            var op =  ds.offset();
            var h = ds.height();
            var th=  h+op.top;
            jQuery('.ds-panel', ds).removeAttr('style');
            ds.removeAttr('style');
            if( wh -50 < th ){
                ds.css({
                   top:  '50px'
                });
                jQuery('.ds-panel', ds).css({
                    height: (wh-100)+'px',
                    overflow: 'auto'
                });
            }
        });

        ///---------TOGGLE PANEL---------
        jQuery('.ds-toggle').click(function(){
            var t = jQuery(this);
            if(t.hasClass('opened') ){
                jQuery( ".ds" ).animate({
                    right: "-260px"
                }, 1000, function() {
                    // Animation complete.
                    t.removeClass('opened');
                });
            }else{
                jQuery( ".ds" ).animate({
                    right: "0px"
                }, 1000, function() {
                    // Animation complete.
                    t.addClass('opened');
                });
            }
            return false;
        });

    }// end function ds_actions


    jQuery('head').append("<link id='demo-switcher' rel='stylesheet' href='"+demo_switcher.purl+"/demo-switcher.css' type='text/css' media='all' />");
    jQuery.ajax({
        url:  demo_switcher.purl+'/html.php',
        data: {
            url:  demo_switcher.purl,
            home_url:  demo_switcher.hom_url

        } ,
        dataType: 'html',
        success: function(  html ){
              jQuery('body').append(html);
              ds_actions();
        }

    });

} );