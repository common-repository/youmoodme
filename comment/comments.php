<?php

    $comment_settings = get_option('comment');
    $comment_container = $comment_settings['container'];
    if(empty($comment_container)){
        global $post;
        $postId = $post->ID;
        echo '<div id="ymm-plugin" data-layout="comment" data-display="all" data-wp-post-id="'.$postId.'"></div>';
    }

    if ( have_comments() ) :

        $activitiesToSend = array();
        foreach( $comments as $comment ) :

            $user = get_userdata($comment->user_id);
            $activity = array(
                'wp_user' => array(
                    'name' => $user->user_login,
                    'description' => $user->user_description
                ),
                'wp_comment' => array(
                    'comment' => $comment->comment_content,
                    'date' => $comment->comment_date
                )
            );
            array_push($activitiesToSend, $activity);
        endforeach;
        $activitiesToSend = json_encode(array_reverse($activitiesToSend));
?>
    <script type="text/javascript">

        var wpActivities = <?php echo $activitiesToSend ?>;

        document.addEventListener("toolbarReady", function (data) {

              ymm2.wordpressComments = wpActivities;

        });

    </script>
<?
     endif;

?>



