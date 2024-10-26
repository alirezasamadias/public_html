<?php
defined('ABSPATH') or exit('No direct script access allowed');

$wishlist = AeWishlist::get_instance();

$posts = $wishlist->fetch_posts();

if (empty($posts)) {
    ?>

    <p class="ae-wishlist-empty-msg text-center">
        <?php _e('Wishlist is empty.','nader'); ?>
    </p>

    <?php
    return;
}

?>

<ul class="woocommerce-account-ae-wishlist d-grid gap-2">
    <?php foreach ($posts as $post) {
        $post_id = $post->post_id;
        $post = get_post($post->post_id);
        ?>
        <li>
            <div class="post-wrapper dfx gap-3">
                <div class="img-wrapper">
                    <img src="<?php echo get_the_post_thumbnail_url($post_id); ?>">
                </div>
                <div class="texts d-grid">
                    <a href="<?php the_permalink($post_id); ?>">
                        <?php echo esc_html($post->post_title); ?>
                    </a>
                    <?php ae_wishlist_btn($post_id); ?>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>