<?php
defined('ABSPATH') or exit('No direct script access allowed');

$wishlist = AeWishlist::get_instance();

$posts = $wishlist->fetch_posts();

if (empty($posts)) {
    return;
}

?>

<h2><?php esc_html_e('Favorite posts', 'nader'); ?></h2>
<ul>
    <?php foreach ($posts as $post) {
        $post = get_post($post->post_id);
        ?>
        <li>
            <a href="<?php echo esc_url(get_permalink($post->ID)) ?>"><?php echo esc_html($post->post_title); ?></a>
            | <?php ae_wishlist_btn($post->ID); ?>
        </li>
    <?php } ?>
</ul>