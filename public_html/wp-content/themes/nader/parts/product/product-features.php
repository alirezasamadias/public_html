<?php
defined('ABSPATH') || die();

if (ACF_ENABLED && have_rows('product-features', get_the_ID())) { ?>
    <ul class="product-information product-summary-row product-summary-two d-flex flex-column gap-1 mt-2 mb-3">
        <?php
        while (have_rows('product-features', get_the_ID())) {
            the_row();
            echo '<li>'. get_sub_field('title') . ': ' . get_sub_field('feature') .'</li>';
        }
        ?>
    </ul>
<?php }
