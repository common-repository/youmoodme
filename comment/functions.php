<?php

function loadBox() {
    global $ymmLocal;
    $src = 'https://local.b2b.youmood.me:3026';
    if($ymmLocal == FALSE ) {
        $src = 'https://katia.youmood.me';
    }

    $ymm_options = get_option('youmoodme');
    $comment_settings = get_option('comment');

    $container = 'ymm-plugin';
    $comment_container = $comment_settings['container'];
    if(isset($comment_container) && !empty($comment_container)){
        $container = $comment_container;
        // global $post; $postId = $post->ID; $options = ', wp-post-id : "'.$postId.'"';
    }

    $comment_language = 'en';
    if(get_bloginfo('language') == 'fr-FR'){
        $comment_language = 'fr';
    }

    $comment_video_player = '';
    if($comment_settings['video_player'] == 1){
        $comment_video_player = ', {name : "playerVideo", options : {language  : "'.$comment_language.'"}}';
    }


    echo '<script type="text/javascript" src="'.$src.'/loader/ymmCore.js"></script>';
    echo '<script id="ymm-script-loader">document.addEventListener("ymmCoreIsLoaded", function (e) { var ymmCore = new YmmCore({ app_id : "'.$ymm_options['appId'].'"}); ymmCore.load([{ name : "comment", options : { container : "'.$container.'", language  : "'.$comment_language.'", count : "'.$comment_settings['count'].'"} }'.$comment_video_player.']); });</script>';

}
add_action('wp_footer', 'loadBox');

function youmoodme_comments($file) {
    $file = dirname( __FILE__ ) . '/comments.php';
    return $file;
}
add_filter('comments_template', 'youmoodme_comments');

