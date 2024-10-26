<?php

defined('ABSPATH') || die();

function naderCommentsListCallback($comment, $args, $depth)
{
    ?>
<li <?php comment_class(); ?> data-comment-id="<?php echo $comment->comment_ID; ?>">

    <div class="author-img float-start">
        <img src="<?php echo esc_url(get_avatar_url(get_comment_author_email())); ?>"
             width="40" height="40" alt="<?php comment_author(); ?>" class="rounded-circle">
    </div>
    <div class="text overflow-hidden">
        <div class="author-cm dfx aic jcsb">
            <b><?php comment_author(); ?></b>
            <div class="author-cm-controls dfx aic">
                <?php
                edit_comment_link();
                comment_reply_link(['depth' => $depth, 'max_depth' => $args['max_depth'],]);
                ?>
            </div>
        </div>

        <h6>
            <span><?php comment_date('Y/m/d'); ?></span>
            <?php esc_html_e('Time', 'nader'); ?>
            <span><?php comment_time(); ?></span>
        </h6>

        <?php
        comment_text();
        // Display comment moderation text
        if ($comment->comment_approved == '0') {
            ?>
            <em class="comment-awaiting-moderation">
                <?php esc_html_e('Your comment will be published after approval by the administrator.', 'nader'); ?>
            </em><br/>
        <?php } ?>
    </div>

    <?php
}
