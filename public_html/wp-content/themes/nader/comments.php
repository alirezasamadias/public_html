<?php
defined('ABSPATH') || die();

?>
<div id="comments" class="comments-area">
    <?php
    if (have_comments()) {
        ?>
        <div class="comment-list">
            <div class="comment-title">
                <?php echo apply_filters('nader_comments_list_title', '<h4>' . sprintf(__('%d Comments', 'nader'), get_comments_number()) . '</h4>'); ?>
            </div>

            <ul>
                <?php
                wp_list_comments([
                    'callback' => 'naderCommentsListCallback',
                    'type'     => 'comment',
                ]);
                ?>
            </ul>
        </div>
        <?php
    }

    wp_reset_postdata();

    get_template_part('parts/global/comment', 'form');

    ?>

</div>
