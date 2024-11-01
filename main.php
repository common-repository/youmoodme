<?php
/*
Plugin Name: Youmood.me plugin
Plugin URI: http://wordpress.org/plugins/youmoodme
Description: This plugin allows you to have youmood.me on your Wordpress website.
Version: 1.0
Author: Youmood.me
Author URI: https://youmood.me/
License: GPL2
*/

$ymmLocal = FALSE;

function youmoodme_activate(){
    // Activation du plugin
}

function youmoodme_deactivate(){
    // Désactivation du plugin
}

function youmoodme_uninstall() {
    // Supression du plugin
}


register_activation_hook(__FILE__, 'youmoodme_activate');
register_deactivation_hook(__FILE__, 'youmoodme_deactivate');
register_uninstall_hook(__FILE__, 'youmoodme_uninstall');

// Plugin translation
function ymm_translation()
{
    load_plugin_textdomain('youmoodme', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action('init', 'ymm_translation');

// Load admin menu
if (is_admin()){
    add_action('admin_menu', 'ymm_create_menu');
}

function ymm_create_menu() {
    add_menu_page('youmood.me plugin settings', 'youmood.me', 'administrator', __FILE__, 'ymm_settings_page', '');
    add_action( 'admin_init', 'register_my_settings' );
}

function register_my_settings() {
    register_setting('ymm-settings-group', 'youmoodme');
    register_setting('ymm-settings-group', 'feature');
    register_setting('ymm-settings-group', 'comment');
    register_setting('ymm-settings-group', 'katia');
}

function ymm_settings_page() {
    include(plugin_dir_path( __FILE__ ).'settings.php');
}

add_action('admin_head', 'load_stylesheet');
function load_stylesheet() {
    echo '<link rel="stylesheet" href="'.plugins_url().'/youmoodme/css/styles.css" type="text/css" media="all" />';
}

function authenticate_plugin($appId, $appSecret, $authorizeCode){
    global $ymmLocal;

    $ymmHost = 'https://local.business.youmood.me:3028';

    if($ymmLocal == FALSE ) {
        $ymmHost = 'https://business.youmood.me';
    }

    $authorizeCode = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $authorizeCode);

    $response = wp_remote_post( $ymmHost.'/wp/authenticate', array(
            'sslverify' => false,
            'body' => array(
                'client_id' => $appId,
                'code' => $authorizeCode,
                'redirect_uri' => get_site_url(),
                'client_secret' => $appSecret
            )
        )
    );

    if($response["response"]["code"] == 200){
        $newValues = array(
            'status' => 'authenticated',
            'appId' => $appId,
            'appSecret' => $appSecret
        );
        update_option('youmoodme', $newValues);
    }

}

// Load features
$current_settings = get_option('feature');
if($current_settings == 'comment') {
    include(plugin_dir_path( __FILE__ ).'comment/functions.php');
} else if($current_settings == 'katia') {
    include(plugin_dir_path( __FILE__ ).'katia/functions.php');
}

// Youmood.me endpoints
function makeplugins_endpoints_add_endpoint() {
    add_rewrite_endpoint( 'ymm', EP_ALL);
    add_rewrite_endpoint( 'ymm-authorize', EP_ALL);
}
add_action( 'init', 'makeplugins_endpoints_add_endpoint' );

function makeplugins_endpoints_template_redirect() {
    global $wp_query;

    $ymm_options = get_option('youmoodme');
    if (isset( $wp_query->query_vars['ymm'] )) {
        makeplugins_endpoints_save_comments();
    } else if (isset( $wp_query->query_vars['ymm-authorize']) && $ymm_options['status'] == 'authorized' && isset($ymm_options['appId']) && !empty($ymm_options['appId']) && isset($ymm_options['appSecret']) && !empty($ymm_options['appSecret'])){
        makeplugins_endpoints_get_authorize_code($ymm_options['appId'], $ymm_options['appSecret']);
    }
}
add_action( 'template_redirect', 'makeplugins_endpoints_template_redirect' );

function makeplugins_endpoints_get_authorize_code($appId, $appSecret) {

    if(isset($_GET['authorize_code']) && !empty($_GET['authorize_code'])){

        function hextobin($hexstr){
            $n = strlen($hexstr);
            $sbin="";
            $i=0;
            while($i<$n)
            {
                $a =substr($hexstr,$i,2);
                $c = pack("H*",$a);
                if ($i==0){$sbin=$c;}
                else {$sbin.=$c;}
                $i+=2;
            }
            return $sbin;
        }

        $code = urldecode($_GET['authorize_code']);
        $code = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $appSecret, hextobin($code), MCRYPT_MODE_CBC, '0123456789123456');
        var_dump($code);
        authenticate_plugin($appId, $appSecret, $code);

    }

}

function makeplugins_endpoints_save_comments() {
    global $ymmLocal;

    $enabled = FALSE;
    $debug = FALSE;

    $current_settings = get_option('feature');
    if($current_settings == 'katia') {
        $katia = get_option('katia');
        if($katia['synchronize_comments'] == "1") {
            $enabled = TRUE;
        }
    } else if($current_settings == 'comment') {
        $comment = get_option('comment');
        if($comment['synchronize_comments'] == "1") {
            $enabled = TRUE;
        }
    }

    $ymmIp = '127.0.0.1';
    if($ymmLocal == FALSE ) {
        $ymmIp = '176.31.22.187'; //gethostbyname('www.youmood.me');
    }
    $remoteIP = $_SERVER['REMOTE_ADDR'];
    $allowedIPs = array($ymmIp);

    if($debug){
        $file = dirname( __FILE__ )."/log.txt";
        $current = " - Current settings: ".$current_settings;
        if($current_settings == 'katia') {
            $current .= "- Katia synchronize: ".$katia['synchronize_comments'];
        } else if($current_settings == 'comment') {
            $current .= "- Comment synchronize: ".$comment['synchronize_comments'];
        }
        $current .= " - Enabled: ".($enabled ? 'TRUE' : 'FALSE');
        $current .= " - Remote IP: ".$ymmIp;
        $current .= " - Allowed IP: ".$_SERVER['REMOTE_ADDR'];
        file_put_contents($file, $current);
    }

    if($enabled && in_array($remoteIP, $allowedIPs)){

        $req = file_get_contents('php://input');
        $req = json_decode($req, TRUE);
        $data = (array) $req;

        $printable = print_r ($data, TRUE);
        if($debug) {
            syslog(LOG_WARNING, "data:" . $printable . ' --- ' . date(DATE_RFC822));
            $file = dirname( __FILE__ )."/log.txt";
            $current .= " - Data: ".$req;
            file_put_contents($file, $current);
        }

        if(isset($data) && !empty($data)){

            $authorId = $data['author']['id'];
            $authorName = $data['author']['name'];
            $authorPicture = $data['author']['picture'];

            $postId = $data['comment']['postId'];
            $comment = $data['comment']['description'];


            // On vérifie si l'user existe
            $wpUserName = $authorName; // . '___' . $authorId;
            $userId = username_exists( $wpUserName );

            // Si il n'existe pas, on le genere
            if ( !$userId ) {
                $randomPass = wp_generate_password( $length=12, $include_standard_special_chars=false );
                $newUser = array(
                    'user_login'   => $wpUserName,
                    'user_pass'    => $randomPass,
                    'display_name' => $authorName,
                    'yim'          => $authorId,
                    'description' => 'youmood.me'
                );
                $userId = wp_insert_user( $newUser );
            }

            // On genere le post
            $myComment = array(
                'user_id'   => $userId,
                'comment_post_ID'  => $postId,
                'comment_content' => $comment,
                'comment_approved' => 1
            );

            // On recupere son id
            $commentId = wp_insert_comment($myComment);

            // Si on a l'id, on ajoute les champs personnalisés et on retourne le resultat en JSON
            if(isset($commentId) && !empty($commentId)){

                header('HTTP/1.1 201 Created');

                $res = array(
                    'status'  => 'OK',
                    'wp_comment' => array(
                        'id'  =>  $commentId
                    ),
                    'wp_user' => array(
                        'id'  =>  $userId,
                        'name' =>  $wpUserName
                    )
                );

                header( 'Content-Type: application/json' );
                echo json_encode($res);

            } else {
                header('HTTP/1.1 503 Service Unavailable');
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
        }

    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo '-Remote IP:'.$remoteIP;
        echo '-Allowed IP:'.var_dump($allowedIPs);
        echo '-Enabled:'.var_dump($enabled);
        echo '-Authorized:'.var_dump($enabled && in_array($remoteIP, $allowedIPs));
    }

}

function makeplugins_endpoints_activate() {
    // ensure our endpoint is added before flushing rewrite rules
    makeplugins_endpoints_add_endpoint();
    // flush rewrite rules - only do this on activation as anything more frequent is bad!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'makeplugins_endpoints_activate' );

function makeplugins_endpoints_deactivate() {
    // flush rules on deactivate as well so they're not left hanging around uselessly
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'makeplugins_endpoints_deactivate' );