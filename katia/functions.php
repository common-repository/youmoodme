<?php

function loadKatia() {
    global $ymmLocal;

    $src = 'https://local.b2b.youmood.me:3026';
    if($ymmLocal == FALSE ) {
        $src = 'https://katia.youmood.me';
    }

    global $post;
    $postId = $post->ID;

    $ymm_options = get_option('youmoodme');
    $katia_settings = get_option('katia');

    $katia_targetable = '';
    if(isset($katia_settings['targetable']) && !empty($katia_settings['targetable'])){
        $katia_targetable = ', targetable : "'.str_replace(' ', '', $katia_settings['targetable']).'"';
    }

    $katia_language = 'en';
    if(get_bloginfo('language') == 'fr-FR'){
        $katia_language = 'fr';
    }

    $katia_video_player = '';
    if($katia_settings['video_player'] == 1){
        $katia_video_player = ', {name : "playerVideo", options : {language  : "'.$katia_language.'"}}';
    }

    $katia_offset = '';
    if(isset($katia_settings['offset_top']) && !empty($katia_settings['offset_top'])){
        $katia_offset = ', offsetTop : "'.$katia_settings['offset_top'].'"';
    }

    $katia_container = '';
    if(isset($katia_settings['container']) && !empty($katia_settings['container'])){
        $katia_container = ', container : "'.$katia_settings['container'].'"';
    }

    echo '<script type="text/javascript" src="'.$src.'/loader/ymmCore.js"></script>';
    echo '<script id="ymm-script-loader">document.addEventListener("ymmCoreIsLoaded", function (e) { var ymmCore = new YmmCore({ app_id : "'.$ymm_options['appId'].'"}); ymmCore.load([{ name : "katia", options : { language  : "'.$katia_language.'" '.$katia_targetable.$katia_offset.$katia_container.'} }'.$katia_video_player.']); });</script>';


}

add_action('wp_enqueue_scripts','check_params');

function check_params() {
    $load_katia = FALSE;
    $katia_settings = get_option('katia');

    if($katia_settings['all'] == 1) {
        $load_katia = TRUE;
    }

    if($katia_settings['pages'] == 1 && is_page()) {
        $load_katia = TRUE;
    }

    if($katia_settings['posts'] == 1 && is_single()) {
        $load_katia = TRUE;
    }

    if($load_katia){
        add_action('wp_footer', 'loadKatia');
    }

}









