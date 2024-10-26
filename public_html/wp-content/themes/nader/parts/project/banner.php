<?php
/**
 * Project Banner
 */
defined('ABSPATH') || die();
$post_id = get_the_ID();

$acf_category = $acf_view = $acf_comment = true;
if (ACF_ENABLED) {
    $acf_category = get_field('nader-single-project_category', 'options');
    $acf_view     = get_field('nader-single-project_view', 'options');
    $acf_comment  = get_field('nader-single-project_comment', 'options');
}

?>
<div class="single-banner col-xl-12 mt-5 mb-3 p-4">
    <div class="row">
        <div class="post-details col-md-7">
            <div class="post-title d-flex align-items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M19 22H5a3 3 0 0 1-3-3V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12h4v4a3 3 0 0 1-3 3zm-1-5v2a1 1 0 0 0 2 0v-2h-2zm-2 3V4H4v15a1 1 0 0 0 1 1h11zM6 7h8v2H6V7zm0 4h8v2H6v-2zm0 4h5v2H6v-2z"/>
                </svg>
                <h1><?php the_title(); ?></h1>
            </div>

            <?php if ($acf_category || $acf_comment || $acf_view) { ?>
                <div class="post-infos d-flex align-items-center flex-wrap gap-4">

                <?php if ($acf_category) { ?>
                    <div class="pib category dfx aic gap-2">
                        <?php
                        $cat = RealPressHelper::getPostFirstCategory($post_id);
                        ?>
                        <span class="icon dfx aic jcc">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"/>
                                <path d="M10 8h4V6.5a3.5 3.5 0 1 1 3.5 3.5H16v4h1.5a3.5 3.5 0 1 1-3.5 3.5V16h-4v1.5A3.5 3.5 0 1 1 6.5 14H8v-4H6.5A3.5 3.5 0 1 1 10 6.5V8zM8 8V6.5A1.5 1.5 0 1 0 6.5 8H8zm0 8H6.5A1.5 1.5 0 1 0 8 17.5V16zm8-8h1.5A1.5 1.5 0 1 0 16 6.5V8zm0 8v1.5a1.5 1.5 0 1 0 1.5-1.5H16zm-6-6v4h4v-4h-4z"/>
                            </svg>
                        </span>
                        <span class="pibt">
                            <span class="bt"><?php _e('Category', 'nader'); ?></span>
                            <a href="<?php echo get_category_link($cat->term_id) ?>" title="<?php echo $cat->name; ?>"
                               class="ba"><?php echo $cat->name; ?></a>
                        </span>
                    </div>
                <?php } ?>

                <?php if ($acf_view && function_exists('the_views')) { ?>
                    <div class="pib view dfx aic gap-2">
                        <span class="icon dfx aic jcc">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"/>
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                            </svg>
                        </span>
                        <span class="pibt">
                            <span class="bt"><?php _e('Views', 'nader'); ?></span>
                            <span class="ba"><?php echo RealPressHelper::getPostViews(); ?></span>
                        </span>
                    </div>
                <?php } ?>

                <?php if ($acf_comment) { ?>
                    <div class="pib comment dfx aic gap-2">
                    <span class="icon dfx aic jcc">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M5.455 15L1 18.5V3a1 1 0 0 1 1-1h15a1 1 0 0 1 1 1v12H5.455zm-.692-2H16V4H3v10.385L4.763 13zM8 17h10.237L20 18.385V8h1a1 1 0 0 1 1 1v13.5L17.545 19H9a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                    </span>
                        <span class="pibt">
                        <span class="bt"><?php _e('Comments', 'nader'); ?></span>
                        <span class="ba"><?php comments_number(); ?></span>
                    </span>
                    </div>
                <?php } ?>

            </div>
            <?php } ?>

            <?php get_template_part('parts/project/info'); ?>

        </div>

        <?php get_template_part('parts/project/gallery') ?>

    </div>
</div>
