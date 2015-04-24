jQuery( function( $ ) {

    // woocommerce_price_slider_params is required to continue, ensure the object exists
    if ( typeof woocommerce_price_slider_params === 'undefined' ) {
        return false;
    }

    // Get markup ready for slider
    $( '.woof input.min_price, .woof input.max_price' ).hide();
    $( '.woof .price_slider, .woof .price_label' ).show();

    // Price slider uses jquery ui
    var min_price = $( '.woof .price_slider_amount .min_price' ).data( 'min' ),
        max_price = $( '.woof .price_slider_amount .max_price' ).data( 'max' );

    current_min_price = parseInt( min_price, 10 );
    current_max_price = parseInt( max_price, 10 );

    if ( woocommerce_price_slider_params.min_price !=='') current_min_price = parseInt( woocommerce_price_slider_params.min_price, 10 );
    if ( woocommerce_price_slider_params.max_price !=='' ) current_max_price = parseInt( woocommerce_price_slider_params.max_price, 10 );

    $( 'body' ).bind( 'price_slider_create price_slider_slide', function( event, min, max ) {
        if ( woocommerce_price_slider_params.currency_pos === 'left' ) {

            $( '.woof .price_slider_amount span.from' ).html( woocommerce_price_slider_params.currency_symbol + min );
            $( '.woof .price_slider_amount span.to' ).html( woocommerce_price_slider_params.currency_symbol + max );

        } else if ( woocommerce_price_slider_params.currency_pos === 'left_space' ) {

            $( '.woof .price_slider_amount span.from' ).html( woocommerce_price_slider_params.currency_symbol + " " + min );
            $( '.woof .price_slider_amount span.to' ).html( woocommerce_price_slider_params.currency_symbol + " " + max );

        } else if ( woocommerce_price_slider_params.currency_pos === 'right' ) {

            $( '.woof .price_slider_amount span.from' ).html( min + woocommerce_price_slider_params.currency_symbol );
            $( '.woof .price_slider_amount span.to' ).html( max + woocommerce_price_slider_params.currency_symbol );

        } else if ( woocommerce_price_slider_params.currency_pos === 'right_space' ) {

            $( '.woof .price_slider_amount span.from' ).html( min + " " + woocommerce_price_slider_params.currency_symbol );
            $( '.woof .price_slider_amount span.to' ).html( max + " " + woocommerce_price_slider_params.currency_symbol );

        }

        $( 'body' ).trigger( 'price_slider_updated', min, max );
    });

    $( '.price_slider' ).slider({
        range: true,
        animate: true,
        min: min_price,
        max: max_price,
        values: [ current_min_price, current_max_price ],
        create : function( event, ui ) {

            $( '.woof .price_slider_amount .min_price' ).val( current_min_price );
            $( '.woof .price_slider_amount .max_price' ).val( current_max_price );

            $( 'body' ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
        },
        slide: function( event, ui ) {

            $( '.woof input.min_price' ).val( ui.values[0] );
            $( '.woof input.max_price' ).val( ui.values[1] );

            $( 'body' ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
        },
        change: function( event, ui ) {

            $( 'body' ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );

        },
    });


});

/// -----------------------



jQuery(function () {
    var containers = jQuery('.woof_container');

    try {
        jQuery.each(containers, function (index, value) {

            var remove = false;

            if (jQuery(value).find('ul.woof_list_radio').size() === 1) {
                remove = true;
            }

            if (jQuery(value).find('ul.woof_list_checkbox').size() === 1) {
                remove = true;
            }

            if (remove) {
                if (jQuery(value).find('ul.woof_list li').size() === 0) {
                    jQuery(value).remove();
                }
            }

        });
    } catch (e) {

    }
    // Submit by manual
    jQuery('.woo_submit_search_form').click(function () {
        // console.debug( woof_get_submit_link() );
        window.location = woof_get_submit_link();
        return false;
    });

    // auto submit
    var ajax_request;
    jQuery( 'body' ).on( 'woof_changed price_slider_change' , function(){
        var products_selector =  '.woof-products';
        var  container =  jQuery( products_selector );
        var  p = container.closest('div');
        p.addClass('woof-products-wrap relative');
        var link =  woof_get_submit_link();

        if(ajax_request && ajax_request.readystate != 4){
            ajax_request.abort();
        }

       // jQuery('.fa fa-spinner fa-spin');
        p.append('<div class="woof-loading loading "><i class="fa fa-spinner fa-spin"></i></div>');

        ajax_request = jQuery.ajax({
            type: 'POST',
            url: link,
            dataType: 'html',
            beforeSend: function(){

            },
            complete: function(){
                jQuery('.woof-loading',p).remove();
            },
            success: function( response ) {
                var response=  jQuery( response );
                var products =  jQuery( products_selector , response).html();
                jQuery( products_selector).html(  products );
                // woocommerce-pagination
                var pagination =  jQuery('.woocommerce-pagination', response).html();
                if( pagination === undefined ){
                    pagination ='';
                }
                jQuery('.woocommerce-pagination').html(pagination);

                var count =  jQuery('.woocommerce-result-count', response).html();
                jQuery('.woocommerce-result-count').html(count);

                var order = jQuery('.woocommerce-ordering input:hidden', response );
                jQuery('.woocommerce-ordering input:hidden').remove();
                jQuery('.woocommerce-ordering').append( order );

                jQuery( 'body' ).trigger( 'woof_products_added' );

            }
        });


    });




    jQuery('.woof  .iw  label  input:checkbox, .woof  li  label  input:radio').each(function(){
        var p = jQuery(this).parents('.iw');
        p.addClass('js-check');
        if(  jQuery('.woof-tax-thumb', p ).length > 0  ){

        }else{
            jQuery(this).parents('label').prepend('<span class="woof-tax-thumb-auto"></span>');
        }

        if( jQuery(this).is(':checked') ){
            jQuery(this).parents('.iw').addClass('js-checked');
        }else{
            jQuery(this).parents('.iw').removeClass('js-checked');
        }

    });


    jQuery('.woof  .iw  label  input:checkbox').click(function(){
        if( jQuery(this).is(':checked') ){
            jQuery(this).parents('.iw').addClass('js-checked');
        }else{
            jQuery(this).parents('.iw').removeClass('js-checked');
        }
        jQuery( 'body' ).trigger( 'woof_changed' );
    });

    jQuery('.woof  .iw  label  input:radio').click(function(){
        var name = jQuery(this).attr('name');
        jQuery('.iw  label  input[name='+name+']').parents('.iw').removeClass('js-checked');
        if( jQuery(this).is(':checked') ){
            jQuery(this).parents('.iw').addClass('js-checked');
        }else{
            jQuery(this).parents('.iw').removeClass('js-checked');
        }
        jQuery( 'body' ).trigger( 'woof_changed' );
    });

    jQuery('.woof  .iw  .woof_radio_term_reset').click(function(){
        var name = jQuery(this).data('name');
        jQuery('.iw  label  input[name='+name+']').parents('.iw').removeClass('js-checked');
        jQuery('.iw  label  input[name='+name+']').removeAttr('checked');
        jQuery( 'body' ).trigger( 'woof_changed' );
        return false;
    });

    jQuery('.woof_container h3').click( function(){
        var p  =  jQuery(this).parents('.woof_container');
        if( jQuery(this).hasClass('closed')){
            jQuery(this).toggleClass('closed');
            jQuery('.woof_ci',p).slideDown(200);
        }else{
            jQuery(this).toggleClass('closed');
            jQuery('.woof_ci',p).slideUp(200);
        }

        return false;

    });


    //***
    jQuery('ul.woof_childs_list').parent('li').addClass('woof_childs_list_li');
    //***

    jQuery('.woof_checkbox_instock').on('change', function (event) {
        jQuery( 'body' ).trigger( 'woof_changed' );
    });


    // max-height-toggle
    jQuery('.is-max-h').each(function(){
        var p = jQuery( this );
        jQuery('.view-full-h', p).click(  function(){
            var a = jQuery(this);
            var h = jQuery('.woof_ci', p).height();
            var mh= a.data('max-height');
            if(a.hasClass('closed') ){
                a.removeClass('closed');
                jQuery( ".wmhw", p ).animate({
                    maxHeight: h
                }, 500, function() {
                    // Animation complete.
                });

            }else{
                a.addClass('closed');
                jQuery( ".wmhw", p ).animate({
                    maxHeight: mh
                }, 500, function() {
                    // Animation complete.
                });
            }
            return false;
        } );
    });

});

function woof_get_submit_link() {

    // re update filter data
    woof_current_values = {};

    if( jQuery('.woof .min_price').length ){
        woof_current_values.min_price = jQuery('.woof .min_price').val();
    }

    if( jQuery('.woof .max_price').length ){
        woof_current_values.max_price = jQuery('.woof .max_price').val();
    }

    jQuery('.woof_checkbox_instock').each(function () {
        //jQuery(this).attr("checked", true);
        var is_check =  jQuery(this).is(':checked');
        if( is_check ){
            woof_current_values.stock = 'instock';
        }
    });

    jQuery('.woof input.woof_checkbox_term').each(  function() {
        var is_check =  jQuery(this).is(':checked');
        if( is_check ){
            var tax = jQuery(this).data('tax');
            var name = jQuery(this).attr('name');

            if (tax in woof_current_values) {
                woof_current_values[tax] = woof_current_values[tax] + ',' + name;

            } else {
                woof_current_values[tax] = name;
            }
        }

    });

    jQuery('.woof input.woof_radio_term').each( function(){
        var is_check =  jQuery(this).is(':checked');
        if( is_check ){
            var slug = jQuery(this).data('slug');
            var name = jQuery(this).attr('name');
            woof_current_values[name] = slug;
        }
    } );

    jQuery('.woof select.woof_select').each( function(){
        if( jQuery('option:selected', jQuery(this)).length > 0){
            var slug = jQuery(this).val();
            var name = jQuery(this).attr('name');
            woof_current_values[name] = slug;
        }
    } );

    jQuery('.woof_mselect').each(function () {
        var slug = jQuery(this).val();
        var name = jQuery(this).attr('name');

        //mode with Filter button
        var values = [];
        jQuery('option:selected', jQuery(this) ).each(function (i, v) {
            values.push(jQuery(this).val());
        });
        values = values.join(',');
        if (values.length) {
            woof_current_values[name] = values;
        }

    });


    //--------------------

    //filter woof_current_values values
    if (Object.keys(woof_current_values).length > 0) {
        jQuery.each(woof_current_values, function (index, value) {
            if (index == 'swoof') {
                delete woof_current_values[index];
            }
            if (index == 's') {
                delete woof_current_values[index];
            }
        });
    }
    //***
    if (Object.keys(woof_current_values).length === 2) {
        if (('min_price' in woof_current_values) && ('max_price' in woof_current_values)) {
            return woof_current_page_link + '?min_price=' + woof_current_values.min_price + '&max_price=' + woof_current_values.max_price;
        }
    }


    if (Object.keys(woof_current_values).length === 1) {
        if ('stock' in woof_current_values) {
            //return woof_current_page_link;
        }
    }

    if (Object.keys(woof_current_values).length === 0) {
        return woof_current_page_link;
    }
    //+++
    var link = woof_current_page_link + "?swoof=1";
    if (Object.keys(woof_current_values).length > 0) {
        jQuery.each(woof_current_values, function (index, value) {
            link = link + "&" + index + "=" + value;
        });
    }

    return link;
}

