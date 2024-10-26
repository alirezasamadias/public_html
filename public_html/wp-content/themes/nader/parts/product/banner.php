<?php
/**
 * Product Banner
 */
defined('ABSPATH') || die();
$post_id = get_the_ID();

?>
<div class="single-banner col-xl-12 mb-3 p-4">
    <div class="row">
        <div class="post-details col-md-7">
            <?php do_action( 'woocommerce_single_product_summary' ); ?>
        </div>

        <?php get_template_part('parts/product/gallery') ?>
    </div>
</div>
