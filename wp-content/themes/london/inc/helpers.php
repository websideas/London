<?php
function kt_wpml_theme_option_name( $option_name ){
    if( defined('ICL_LANGUAGE_CODE') ){
        return $option_name.'_'.ICL_LANGUAGE_CODE;
    }
    return $option_name;
}

add_filter('theme_option_name', 'kt_wpml_theme_option_name');

//$this->options = apply_filters( "redux/options/{$this->args['opt_name']}/options", $this->options );

function kt_wpml_get_options(  $values ){
    // apply_filters('theme_option_name', THEME_OPTIONS )
    // Please note: leave database arg is empty
    $option_name =  apply_filters('theme_option_name', THEME_OPTIONS );
    //die($option_name);
    $result = get_option( $option_name, array() );
    if ( empty ( $result ) ) {
        // try with default option
        $result = get_option( THEME_OPTIONS , array() );
        if ( empty ( $result ) ) {
            return $values;
        }
        return $result;
    } else {
        return $result;
    }
}

function kt_wpml_header(){
    $langs = icl_get_languages('skip_missing=0');

    ?>
    <h2 class="nav-tab-wrapper wpml-nav-tab-wrapper">
        <?php foreach($langs as $l){ ?>
        <a class="nav-tab <?php echo (ICL_LANGUAGE_CODE === $l['language_code']) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url('admin.php?page=theme_options&lang='.$l['language_code']); ?>"><img src="<?php echo esc_attr(  $l['country_flag_url']) ?>" alt=""> <?php echo $l['native_name'] ?></a>
        <?php } ?>
    </h2>
    <?php
}

if( defined('ICL_LANGUAGE_CODE') ){
    add_action('redux-page-before-form-'.apply_filters('theme_option_name', THEME_OPTIONS ), 'kt_wpml_header' );
    add_filter("redux/options/".apply_filters('theme_option_name', THEME_OPTIONS )."/options", 'kt_wpml_get_options' );
}

