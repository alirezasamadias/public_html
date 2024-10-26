<?php
defined('ABSPATH') || die();

$form_id = true;
$content_tab_title = __('About Project', 'nader');
$order_form_tab_title = __('Project Order', 'nader');
if (ACF_ENABLED) {
    $form_id = get_field('nader-single-project_order-form', 'options');

    $tt1 = get_field('nader-single-project_content-tab-title', 'options');
    if (!empty($tt1)) {
        $content_tab_title = $tt1;
    }

    $tt2 = get_field('nader-single-project_order-form-tab-title', 'options');
    if (!empty($tt2)) {
        $order_form_tab_title = $tt2;
    }
}
?>
<ul class="project-tabs-switcher d-inline-flex align-items-center">
    <li class="cursor-pointer disable-select d-flex align-items-center justify-content-center gap-2 active"
        data-target=".project-content, .post-next-previous">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="none" d="M0 0h24v24H0z"/>
            <path d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z"/>
        </svg>
        <?php echo esc_html($content_tab_title); ?>
    </li>

    <?php if (!empty($form_id)) { ?>
        <li class="cursor-pointer disable-select d-flex align-items-center justify-content-center gap-2"
            data-target=".project-form">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"/>
            </svg>
            <?php echo esc_html($order_form_tab_title); ?>
        </li>
    <?php } ?>

    <?php if (comments_open()) { ?>
        <li class="cursor-pointer disable-select d-flex align-items-center justify-content-center gap-2"
            data-target=".project-comments">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z"/>
                <path d="M5.455 15L1 18.5V3a1 1 0 0 1 1-1h15a1 1 0 0 1 1 1v12H5.455zm-.692-2H16V4H3v10.385L4.763 13zM8 17h10.237L20 18.385V8h1a1 1 0 0 1 1 1v13.5L17.545 19H9a1 1 0 0 1-1-1v-1z"/>
            </svg>
            <?php _e('Comments', 'nader'); ?>
        </li>
    <?php } ?>
</ul>

