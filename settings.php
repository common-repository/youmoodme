<div id="ymm-settings" class="wrap">
    <?php
        global $ymmLocal;

        $ymmHost = 'https://local.business.youmood.me:3028';
        if($ymmLocal == FALSE ) {
            $ymmHost = 'https://business.youmood.me';
        }
    ?>
    <div class="page-title-wrapper">
        <img src="<?php echo plugins_url(); ?>/youmoodme/img/logo.png" alt=""/> <span class="separator">-</span><h2 class="page-title"><?php _e('Plugin settings', 'youmoodme'); ?></h2>
    </div>
    <div class="page-info-wrapper">
        <p><?php _e('Howdy!', 'youmoodme'); ?></p>
        <p>
            <?php _e('Thanks for using our plugin', 'youmoodme'); ?> <a href="http://www.youmood.me" target="_blank">youmood.me</a>.<br>
            <?php _e('This plugin allows your visitors to post enriched comments everywhere on your Wordpress site.', 'youmoodme'); ?><br>
            <?php _e('For further information, you can visit our', 'youmoodme'); ?> <a href="http://www.youmood.me" target="_blank"><?php _e('website', 'youmoodme'); ?></a>.
        </p>
    </div>
    <?php
        $ymm = get_option('youmoodme');
        if($ymm['status'] == 'authenticated' && isset($ymm['appId']) && !empty($ymm['appId']) && isset($ymm['appSecret']) && !empty($ymm['appSecret'])){
    ?>
    <ul id="ymm-settings-tabs">
        <li>
            <a href="#">
                <?php _e('Settings', 'youmoodme'); ?>
            </a>
        </li>
    </ul>
    <form method="post" action="options.php">
        <?php settings_fields('ymm-settings-group'); ?>
        <?php do_settings_sections('ymm-settings-group'); ?>
        <?php $options = get_option('feature'); ?>
        <div id="features-wrapper">
            <div id="comment-wrapper" class="main-feature <?php echo ('comment' == $options ? 'active' : '')?>">
                <p>
                    <input type="radio" id="feature-comment" class="has-options" name="feature" value="comment" <?php checked( $options, 'comment' ); ?>>
                    <label class="label-radio famos" for="feature-comment"><?php _e('Classic comment mode', 'youmoodme'); ?></label>
                </p>
                <p class="description">
                    <img src="<?php echo plugins_url(); ?>/youmoodme/img/comment2.png" class="illustration" alt=""/>
                    <?php _e('This mode replaces or add a comment system under your blog posts. Users can create a youmood.me account and post comments anywhere on your website.Comments can be enriched with links, photos or videos.', 'youmoodme'); ?>
                </p>
                <div id="comment_options" class="feature-options" style="<?php echo ('comment' == $options ? '' : 'display:none;')?>">
                    <?php $comment = get_option('comment'); ?>
                    <p>
                        <strong><?php _e('Define a container:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('This is where the plugin will be loaded. You must enter the id (#) of an HTML container', 'youmoodme'); ?></em><br>
                        <em><?php _e('If not set, the plugin will replace your default comment container.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="text" id="comment_container" name="comment[container]" placeholder="<?php _e('ex: comment-container (without #)', 'youmoodme'); ?>" value="<?php echo $comment['container']; ?>">
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Number of comments per page to display:', 'youmoodme'); ?></strong><br/>
                    </p>
                    <p>
                        <select id="comment_count" name="comment[count]">
                            <option value="5" <?php echo ($comment['count'] == "5") ? 'selected="selected"' : ''; ?>>5</option>
                            <option value="10" <?php echo ($comment['count'] == "10") ? 'selected="selected"' : ''; ?>>10</option>
                            <option value="15" <?php echo ($comment['count'] == "15") ? 'selected="selected"' : ''; ?>>15</option>
                            <option value="20" <?php echo ($comment['count'] == "20") ? 'selected="selected"' : ''; ?>>20</option>
                            <option value="25" <?php echo ($comment['count'] == "25") ? 'selected="selected"' : ''; ?>>25</option>
                            <option value="30" <?php echo ($comment['count'] == "30") ? 'selected="selected"' : ''; ?>>30</option>
                        </select>
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Synchronize youmood.me comments with wordpress comments:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('Allows you to save all new youmood.me comments into your Wordpress database. In this case, you will keep all your comments even if you uninstall the plugin.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="checkbox" id="comment_synchronize_comments" name="comment[synchronize_comments]" value="1" <?php echo (1 == $comment['synchronize_comments'] ) ? 'checked="checked"' : ''; ?>>
                        <label class="label-checkbox" for="comment_synchronize_comments"><?php _e('Enable', 'youmoodme'); ?></label>
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Video player:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('This feature replaces all YouTube/Dailymotion/Vimeo videos on your website with the youmood.me video player.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="checkbox" id="comment_video_player" name="comment[video_player]" value="1" <?php checked( '1' == $comment['video_player'] ); ?>>
                        <label class="label-checkbox" for="comment_video_player"><?php _e('Enable', 'youmoodme'); ?></label>
                    </p>
                </div>
            </div>

            <span class="vertical-line"></span>

            <div id="katia-wrapper" class="main-feature <?php echo ('katia' == $options ? 'active' : '')?>">
                <p>
                    <input type="radio" id="feature-katia" class="has-options" name="feature" value="katia" <?php checked( $options, 'katia' ); ?>>
                    <label class="label-radio famos"  for="feature-katia"><?php _e('Targeted content mode', 'youmoodme'); ?></label>
                </p>
                <p class="description">
                    <img src="<?php echo plugins_url(); ?>/youmoodme/img/katia.png" class="illustration" alt=""/>
                    <?php _e('The targeted content mode allows your users to comment specific parts of articles: sentences, paragraphs, images and videos inline.', 'youmoodme'); ?>
                </p>
                <div id="katia_options" class="feature-options" style="<?php echo ('katia' == $options ? '' : 'display:none;')?>">
                    <?php $katia = get_option('katia'); ?>
                    <p>
                        <strong><?php _e('Turn on targeted mode', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('You can define where the plugin will be loaded on your website.', 'youmoodme'); ?></em><br/>
                        <em><?php _e('Default: On all pages and posts.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="checkbox" id="katia_all" name="katia[all]" value="1" <?php checked( '1' == $katia['all'] ); ?>>
                        <label class="label-checkbox" for="katia_all"><?php _e('Everywhere', 'youmoodme'); ?></label>
                        <input type="checkbox" id="katia_posts" name="katia[posts]" value="1" <?php checked( '1' == $katia['posts'] ); ?>>
                        <label class="label-checkbox" for="katia_posts"><?php _e('Posts', 'youmoodme'); ?></label>
                        <input type="checkbox" id="katia_pages" name="katia[pages]" value="1" <?php checked( '1' == $katia['pages'] ); ?>>
                        <label class="label-checkbox" for="katia_pages"><?php _e('Pages', 'youmoodme'); ?></label>
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Define a container:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('You can load the plugin in a specific container. You must enter the id (#) of an HTML container', 'youmoodme'); ?></em><br>
                    </p>
                    <p>
                        <input type="text" id="katia_container" name="katia[container]" placeholder="<?php _e('ex: content (without #)', 'youmoodme'); ?>" value="<?php echo $katia['container']; ?>">
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Define targetable content:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('Users can only comment on these HTML element.', 'youmoodme'); ?></em><br/>
                        <em><?php _e('Default: img, p, li, h1, h2, h3, h4, h5, h6, span.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="text" id="katia_targetable" name="katia[targetable]" placeholder="ex: img, p, li, h1, h2, h3, h4, h5, h6, span" value="<?php echo $katia['targetable']; ?>">
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Set a top margin', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('Pushes the plugin down from the top of the page. Unit is pixel.', 'youmoodme'); ?></em><br/>
                    </p>
                    <p>
                        <input type="text" id="katia_offset" name="katia[offset_top]" placeholder="ex: 100 (for 100px)" value="<?php echo $katia['offset_top']; ?>">
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Synchronize youmood.me comments and wordpress comments:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('Allows you to save all new youmood.me comments into your wordpress database. In this case, you will keep all your comments even if you uninstall the plugin.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="checkbox" id="katia_synchronize_comments" name="katia[synchronize_comments]" value="1" <?php echo (1 == $katia['synchronize_comments'] ) ? 'checked="checked"' : ''; ?>>
                        <label class="label-checkbox" for="katia_synchronize_comments"><?php _e('Enable', 'youmoodme'); ?></label>
                    </p>
                    <hr>
                    <p>
                        <strong><?php _e('Video player:', 'youmoodme'); ?></strong><br/>
                        <em><?php _e('This feature replaces all YouTube/Dailymotion/Vimeo videos on your website with the youmood.me video player.', 'youmoodme'); ?></em>
                    </p>
                    <p>
                        <input type="checkbox" id="katia_video_player" name="katia[video_player]" value="1" <?php checked( '1' == $katia['video_player'] ); ?>>
                        <label class="label-checkbox" for="katia_video_player"><?php _e('Enable', 'youmoodme'); ?></label>
                    </p>
                </div>
            </div>
        </div>
        <div id="form-footer">
            <a href="http://www.youmood.me" id="footer-logo" target="_blank">
                <img src="<?php echo plugins_url(); ?>/youmoodme/img/text-logo-grey.png" alt=""/>
            </a>
            <span class="separator">-</span>
            <a href="http://www.youmood.me/en/about" target="_blank" id="about" title="About"><?php _e('About', 'youmoodme'); ?></a>
            <span class="separator">-</span>
            <a href="http://www.youmood.me/en/feedback" target="_blank" id="feedback" title="Feedback"><?php _e('Feedback', 'youmoodme'); ?></a>
            <span class="separator">-</span>
            <a href="http://blog.youmood.me" target="_blank" id="blog" title="youmood.me blog"><?php _e('Blog', 'youmoodme'); ?></a>
            <input type="hidden" name="youmoodme[status]" value="authenticated">
            <input type="hidden" id="wp-appid" name="youmoodme[appId]" value="<?php echo $ymm['appId']; ?>">
            <input type="hidden" id="wp-appsecret" name="youmoodme[appSecret]" value="<?php echo $ymm['appSecret']; ?>">
            <input type="submit" id="form-submit" value="<?php _e('Save settings', 'youmoodme'); ?>">
        </div>
    </form>

    <?php } else if($ymm['status'] == 'authorized' && isset($ymm['authorizeCode']) && !empty($ymm['authorizeCode']) && isset($ymm['appId']) && !empty($ymm['appId']) && isset($ymm['appSecret']) && !empty($ymm['appSecret']) ){ ?>

            <?php if ($ymmLocal)  { ?>
                <script type="text/javascript" charset="utf-8">
                    window.liveEventUrl = "https://local.ymm2.com:3014";
                    window.liveEventPort = 3014
                </script>
                <script src="https://local.ymm2.com:3014/socket.io/socket.io.js"></script>
            <?php } else { ?>
                <script type="text/javascript" charset="utf-8">
                    window.liveEventUrl = "https://chat.youmood.me";
                    window.liveEventPort = 443
                </script>
                <script src="https://chat.youmood.me/socket.io/socket.io.js"></script>
            <?php } ?>

            <script type="text/javascript">

                jQuery(function($) {

                    // Settings
                    $.support.cors = true;
                    $.ajaxSetup({
                        xhrFields: {
                            withCredentials: true
                        }
                    });

                    var ymmRegisterApplicationProcess = {
                        liveEvent : {
                            socketUrl    : window.liveEventUrl,
                            socketPort   : window.liveEventPort,
                            socket : null,
                            on_success : null,
                            container : null,
                            client_id : null,
                            init : function (client_id) {

                                var url = ymmRegisterApplicationProcess.liveEvent.socketUrl;

                                ymmRegisterApplicationProcess.liveEvent.client_id = client_id;

                                ymmRegisterApplicationProcess.liveEvent.socket = io.connect(url, { 'reconnect' : true , 'force new connection': true, secure: true});

                                ymmRegisterApplicationProcess.liveEvent.socket.on('connect', function () {

                                     $.ajax({
                                         url: "<?php echo $ymmHost; ?>/wp/request_endpoint?redirect_uri=<?php echo get_site_url(); ?>&authorize_code=<?php echo $ymm['authorizeCode']; ?>",
                                         type:'GET',
                                         crossDomain: true,
                                         success:function (data){
                                            console.log(data);
                                         },
                                         error:function(data){
                                             data = JSON.parse(data.responseText);
                                             if(typeof data.msg !== 'undefined'){
                                                 $('.text-error').html(data.msg).fadeIn();
                                                 //$('#wp-delete-data').fadeIn();
                                             }
                                         }
                                     });

                                    ymmRegisterApplicationProcess.liveEvent.emitter.new_application_authorize(client_id);
                                    ymmRegisterApplicationProcess.liveEvent.listenEvent();
                                });
                            },
                            emitter :  {
                                new_application_authorize : function (client_id) {
                                    ymmRegisterApplicationProcess.liveEvent.socket.emit("initApplicationAuthenticateProcess",{client_id : client_id});
                                }
                            },
                            listenEvent : function () {
                                var self = this;

                                ymmRegisterApplicationProcess.liveEvent.socket.on("messageApplicationAuthenticateProcess", function (data) {
                                    if (data.status === "success") {
                                        ymmRegisterApplicationProcess.liveEvent.socket.emit("finishApplicationAuthenticateProcess", {client_id :  ymmRegisterApplicationProcess.liveEvent.client_id});
                                        location.reload();
                                    } else {
                                        ymmRegisterApplicationProcess.liveEvent.socket.emit("finishApplicationAuthenticateProcess", {client_id :  ymmRegisterApplicationProcess.liveEvent.client_id});
                                        $('.text-error').html(data.error);
                                        $('.text-error').fadeIn();
                                        //$('#wp-delete-data').fadeIn();
                                    }
                                });
                            }
                        }
                    };

                    ymmRegisterApplicationProcess.liveEvent.init('<?php echo $ymm['appId'] ?>');

                });
            </script>

            <h2><?php _e('Your application has been authorized.', 'youmoodme'); ?></h2>
            <p>
                <?php _e('We are now waiting for youmood.me to register your website. This may take a few seconds...', 'youmoodme'); ?>
            </p>
            <p class="text-error">

            </p>

    <?php } else if($ymm['status'] == 'not_authorized' && isset($ymm['appId']) && !empty($ymm['appId']) && isset($ymm['appSecret']) && !empty($ymm['appSecret']) ){ ?>

        <script type="text/javascript">
            jQuery(function($) {

                // Settings
                $.support.cors = true;
                $.ajaxSetup({
                    xhrFields: {
                        withCredentials: true
                    }
                });

                $.ajax({
                    url: "<?php echo $ymmHost; ?>/wp/authorize?redirect_uri=<?php echo get_site_url(); ?>&response_type=code&client_id=<?php echo $ymm['appId']; ?>",
                    type:'GET',
                    crossDomain: true,
                    success:function (data){
                        console.log(data);
                        if(typeof data.authorize_code !== 'undefined'){
                            $('.ymm-forms').hide();
                            $('#wp-authorize-application').find('#wp-authorizecode').val(data.authorize_code);
                            $('#wp-authorize-application').submit();
                        }
                    },
                    error:function(data){
                        data = JSON.parse(data.responseText);
                        if(typeof data.error !== 'undefined'){
                            $('.text-error').html(data.error).fadeIn();
                            $('#wp-delete-data').fadeIn();
                        }
                    }
                });

            });
        </script>

        <h2><?php _e('Getting youmood.me authorization...', 'youmoodme'); ?></h2>
        <p class="text-error">

        </p>

        <form id="wp-authorize-application" class="hidden" method="post" action="options.php">
            <?php settings_fields('ymm-settings-group'); ?>
            <?php do_settings_sections('ymm-settings-group'); ?>
            <p>
                <input type="hidden" id="wp-appid" name="youmoodme[appId]" value="<?php echo $ymm['appId']; ?>">
                <input type="hidden" id="wp-appsecret" name="youmoodme[appSecret]" value="<?php echo $ymm['appSecret']; ?>">
                <input type="hidden" id="wp-authorizecode" name="youmoodme[authorizeCode]" value="">
                <input type="hidden" name="youmoodme[status]" value="authorized">
                <input type="submit" value="<?php _e('Save settings', 'youmoodme'); ?>">
            </p>
        </form>

    <?php } else { ?>

    <form id="ymm-auth" class="ymm-forms" method="post" action="<?php echo $ymmHost; ?>/login.json">
        <h2>
            <?php _e('Login to youmood.me', 'youmoodme'); ?><br>
        </h2>
        <p class="form-error">
            <?php _e('Sorry, an error occurred while processing your request.', 'youmoodme'); ?>
        </p>
        <p>
            <label for="user-email"><?php _e('Email', 'youmoodme'); ?></label><br>
            <input type="text" id="user-email" name="login[email]" value="">
        </p>
        <p>
            <label for="user-password"><?php _e('Password', 'youmoodme'); ?></label><br>
            <input type="password" id="user-password" name="login[password]" value="">
        </p>
        <p>
            <input type="submit" value="<?php _e('Login', 'youmoodme'); ?>">
        </p>
        <p>
            <?php _e('Not registered?', 'youmoodme'); ?> <a href="#" class="toggle-form" data-target="ymm-signup"><?php _e('Create an Account', 'youmoodme'); ?></a>.<br>
            <?php _e('Lost your password?', 'youmoodme'); ?> <a href="#" class="toggle-form" data-target="ymm-retrieve"><?php _e('Click here to recover', 'youmoodme'); ?></a>
        </p>
    </form>

    <form id="ymm-signup" class="ymm-forms hidden" method="post" action="<?php echo $ymmHost; ?>/signup">
        <h2>
            <?php _e('Sign up to youmood.me', 'youmoodme'); ?><br>
        </h2>
        <p class="form-success">

        </p>
        <p class="form-error">
            <?php _e('Sorry, an error occurred while processing your request.', 'youmoodme'); ?>
        </p>
        <p>
            <label for="user-login"><?php _e('Username', 'youmoodme'); ?></label><br>
            <input type="text" id="user-login" name="user[login]" value="">
        </p>
        <p>
            <label for="user-email"><?php _e('Email', 'youmoodme'); ?></label><br>
            <input type="text" id="user-email" name="user[email]" value="">
        </p>
        <p>
            <label for="user-password"><?php _e('Password', 'youmoodme'); ?></label><br>
            <input type="password" id="user-password" name="user[password]" value="">
        </p>
        <p>
            <input type="hidden" name="location" value="wp"/>
            <input type="submit" value="<?php _e('Register', 'youmoodme'); ?>">
        </p>
        <p>
            <?php _e('I already have an account', 'youmoodme'); ?>, <a href="#" class="toggle-form" data-target="ymm-auth"><?php _e('let me log in', 'youmoodme'); ?></a>.
        </p>
    </form>

    <form id="ymm-retrieve" class="ymm-forms hidden" method="post" action="<?php echo $ymmHost; ?>/retrieve_password">
        <h2>
            <?php _e('Retrieve your password', 'youmoodme'); ?><br>
        </h2>
        <p class="form-success">

        </p>
        <p class="form-error">
            <?php _e('Sorry, an error occurred while processing your request.', 'youmoodme'); ?>
        </p>
        <p>
            <label for="user-email"><?php _e('Email', 'youmoodme'); ?></label><br>
            <input type="text" id="user-email" name="user[email]" value="">
        </p>
        <p>
            <input type="submit" value="<?php _e('Send', 'youmoodme'); ?>">
        </p>
        <p>
            <a href="#" class="toggle-form" data-target="ymm-auth"><?php _e('Go back', 'youmoodme'); ?></a>
        </p>
    </form>

    <form id="ymm-register-application" class="ymm-forms hidden" method="post" action="<?php echo $ymmHost; ?>/wp/register/application">
        <h2>
            <?php _e('Register your application', 'youmoodme'); ?><br>
        </h2>
        <p class="form-success">

        </p>
        <p class="form-error">
            <?php _e('Sorry, an error occurred while processing your request.', 'youmoodme'); ?>
        </p>
        <p class="form-about">
            <?php _e('You need to create an application in order to install any youmood.me package on your website.', 'youmoodme'); ?><br>
            <?php _e('Please choose your application name.', 'youmoodme'); ?>
        </p>
        <p>
            <label for="app_name"><?php _e('Application name', 'youmoodme'); ?></label><br>
            <input type="text" id="app_name" name="app_name" value="">
        </p>
        <p>
            <input type="submit" value="<?php _e('Register', 'youmoodme'); ?>">
        </p>
        <p>
            <a href="#" class="toggle-form" data-target="ymm-auth"><?php _e('Go back', 'youmoodme'); ?></a>
        </p>
    </form>

    <form id="wp-register-application" class="hidden" method="post" action="options.php">
        <?php settings_fields('ymm-settings-group'); ?>
        <?php do_settings_sections('ymm-settings-group'); ?>
        <p>
            <input type="hidden" id="wp-appid" name="youmoodme[appId]" value="">
            <input type="hidden" id="wp-appsecret" name="youmoodme[appSecret]" value="">
            <input type="hidden" name="youmoodme[status]" value="not_authorized">
            <input type="submit" value="<?php _e('Save settings', 'youmoodme'); ?>">
        </p>
    </form>

    <form id="wp-auth" class="hidden" method="post" action="options.php">
        <?php settings_fields('ymm-settings-group'); ?>
        <?php do_settings_sections('ymm-settings-group'); ?>
        <p>
            <input type="hidden" name="youmoodme[status]" value="authenticated">
            <input type="submit" value="<?php _e('Save settings', 'youmoodme'); ?>">
        </p>
    </form>

    <?php } ?>

    <form id="wp-delete-data" class="hidden" method="post" action="options.php">
        <?php settings_fields('ymm-settings-group'); ?>
        <?php do_settings_sections('ymm-settings-group'); ?>
        <p>
            <input type="hidden" name="youmoodme[status]" value="unauthenticated">
            <input type="hidden" id="wp-appid" name="youmoodme[appId]" value="">
            <input type="hidden" id="wp-appsecret" name="youmoodme[appSecret]" value="">
            <input type="submit" value="<?php _e('Reset plugin data', 'youmoodme'); ?>">
        </p>
    </form>

</div>
<script type="text/javascript">
    jQuery(function($) {

        // Settings
        $.support.cors = true;
        $.ajaxSetup({
            xhrFields: {
                withCredentials: true
            }
        });

        $('#ymm-auth').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var data = self.serialize();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type:'POST',
                data: data,
                crossDomain: true,
                success:function (){
                    $('.ymm-forms').hide();
                    $('#ymm-register-application').fadeIn();
                    //$('#wp-auth').submit();
                },
                error:function(data){
                    data = JSON.parse(data.responseText);
                    if(typeof data.msg !== 'undefined'){
                        self.find('.form-success').hide();
                        if(typeof data.msg === "string") {
                            self.find('.form-error').html(data.msg).fadeIn();
                        } else {
                            self.find('.form-error').html('');
                            for(var i = 0; i<data.msg.length; i++){
                                self.find('.form-error').append(data.msg[i]+'<br>');
                            }
                            self.find('.form-error').fadeIn();
                        }
                    }
                }
            });
            return false;
        });

        $('#ymm-signup').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var data = self.serialize();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type:'POST',
                data: data,
                crossDomain: true,
                success:function (data){
                    if(typeof data.msg !== 'undefined'){
                        self.find('.form-error').hide();
                        self.find('.form-success').html(data.msg).fadeIn();
                    }
                },
                error:function(data){
                    data = JSON.parse(data.responseText);
                    if(typeof data.msg !== 'undefined'){
                        self.find('.form-success').hide();
                        if(typeof data.msg === "string") {
                            self.find('.form-error').html(data.msg).fadeIn();
                        } else {
                            self.find('.form-error').html('');
                            for(var i = 0; i<data.msg.length; i++){
                                self.find('.form-error').append(data.msg[i]+'<br>');
                            }
                            self.find('.form-error').fadeIn();
                        }
                    }
                }
            });
            return false;
        });

        $('#ymm-retrieve').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var data = self.serialize();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type:'POST',
                data: data,
                crossDomain: true,
                success:function (data){
                    if(typeof data.msg !== 'undefined'){
                        self.find('.form-error').hide();
                        self.find('.form-success').html(data.msg).fadeIn();
                    }
                },
                error:function(data){
                    data = JSON.parse(data.responseText);
                    if(typeof data.msg !== 'undefined'){
                        self.find('.form-success').hide();
                        if(typeof data.msg === "string") {
                            self.find('.form-error').html(data.msg).fadeIn();
                        } else {
                            self.find('.form-error').html('');
                            for(var i = 0; i<data.msg.length; i++){
                                self.find('.form-error').append(data.msg[i]+'<br>');
                            }
                            self.find('.form-error').fadeIn();
                        }
                    }
                }
            });
            return false;
        });

        $('#ymm-register-application').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var data = self.serialize();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type:'POST',
                data: data,
                crossDomain: true,
                success:function (data){
                    if(
                        typeof data.application !== 'undefined' &&
                        typeof data.application.credential !== 'undefined' &&
                        typeof data.application.credential.app_id !== 'undefined' &&
                        typeof data.application.credential.app_secret !== 'undefined'
                    ){
                        $('.ymm-forms').hide();
                        $('#wp-register-application').find('#wp-appid').val(data.application.credential.app_id);
                        $('#wp-register-application').find('#wp-appsecret').val(data.application.credential.app_secret);
                        $('#wp-register-application').submit();
                    }
                },
                error:function(data){
                    data = JSON.parse(data.responseText);
                    if(typeof data.error !== 'undefined'){
                        self.find('.form-success').hide();
                        self.find('.form-error').html(data.error).fadeIn();
                    }
                }
            });
            return false;
        });

        $('.toggle-form').click(function() {
            var target = $(this).attr('data-target');
            $('.ymm-forms').hide();
            $('#'+target).fadeIn(200);
        });

        $('#ymm-settings-tabs').find('a').click(function(e){
            e.preventDefault();
        });

        $('#feature-comment').click(function() {
            $('#feature-katia').change();
            $('#comment-wrapper').addClass('active');
            $('#katia-wrapper').removeClass('active');
        });

        $('#feature-katia').click(function() {
            $('#feature-comment').change();
            $('#comment-wrapper').removeClass('active');
            $('#katia-wrapper').addClass('active');
        });

        $('.has-options').change(function(){
            if(this.checked) {
                $(this).closest('.main-feature').children('.feature-options').slideDown(100);
            } else {
                $(this).closest('.main-feature') .children('.feature-options').slideUp(100);
            }
        });
    });
</script>