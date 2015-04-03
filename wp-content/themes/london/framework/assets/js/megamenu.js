/*
*
*	Admin $ Mega menu
*	------------------------------------------------
*
*/

(function($){
    "use strict";
    
    $(document).ready(function() {
        
        $(document).on('click', "input[name^='menu-item-megamenu-enable']:checkbox", function(){
    		reloadItems();
            console.log('checkbox');
        });
        
        reloadItems();
        
        function reloadItems(){
            var activeMega = false;
            $('li.menu-item').each( function(){
                var objMenuItem = $(this),
                    currentMega = objMenuItem.find(".edit-menu-item-enable"),
                    currentWidth = objMenuItem.find(".edit-menu-item-width"),
                    objPosition = objMenuItem.find('p.description-position'),
                    objId = currentMega.data('id');
                    
                if(objMenuItem.hasClass('menu-item-depth-0') ) {
                    if(currentMega.prop('checked')){ 
                        activeMega = true;
                        $('#content-megamenu-'+objId).show();
                    }else{
                        activeMega = false;
                        $('#content-megamenu-'+objId).hide();
                    } 
                    if(currentWidth.val() == 'full'){
                        objPosition.hide();
                    }else{
                        objPosition.show();
                    }
                }
                
                if(activeMega && objMenuItem.hasClass('menu-item-depth-1')){
                    objMenuItem.find('.megamenu-layout').show();
                }
                if(activeMega){
                    objMenuItem.addClass('megamenu');
                }else{
                    objMenuItem.removeClass('megamenu');
                }
            });
        }
        $(document).on('change', "select[name^='menu-item-megamenu-width']", function(){
            var $objPosition = $(this).closest('.megamenu-layout').find('p.description-position');
    		($(this).val() == 'full') ? $objPosition.hide() : $objPosition.show();
        });
        
        $( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
    		if( ! $( event.target ).is( 'a' )) {
    			setTimeout( reloadItems, 300 );
                console.log('mouseup');
    		}
    	});
        
        
        
    });
        
})(jQuery);