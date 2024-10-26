<?php
/**
 * Team Banner
 */
defined('ABSPATH') || die();

$post_id = get_the_ID();

$excerpt ='';
if (ACF_ENABLED) {
    $excerpt = get_field('excerpt', $post_id);
}

?>
<div class="single-banner col-xl-12 mt-5 mb-3 p-4">
    <div class="row">
        <div class="post-details col-md-7">

            <div class="post-title d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
                </svg>
                <h1><?php the_title(); ?></h1>
            </div>

            <?php if (!empty($excerpt)) { ?>
                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            <?php } ?>
            <?php
            get_template_part('parts/team/member-info');
            echo '<div class="spacer-20"></div>';
            get_template_part('parts/team/social-pages');
            ?>
        </div>

        <div class="post-thumbnail col-md-5">
            <a href="<?php the_post_thumbnail_url('full'); ?>"
               data-elementor-lightbox-slideshow="nader-single-thumbnail">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    </div>
</div>
