<?php
/**
 * Project Info
 */
defined('ABSPATH') || die();

if (!ACF_ENABLED) {
    return;
}
$post_id = get_the_ID();

$position = get_field('position', $post_id);
$expertise = get_field('expertise', $post_id);
$work_experience = get_field('work_experience', $post_id);
$email = get_field('email', $post_id);
$contact_number = get_field('contact_number', $post_id);

if (empty([$position, $expertise,$work_experience,$email,$contact_number])) {
    return;
}

?>
<div class="member-info post-infos d-grid">

    <?php if (!empty($position)) { ?>
        <div class="position pib d-flex align-items-center">
            <span class="icon d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 3C5.79086 3 4 4.79086 4 7V9.12602C2.27477 9.57006 1 11.1362 1 13C1 14.4817 1.8052 15.7734 3 16.4646V19V21H5V20H19V21H21V19V16.4646C22.1948 15.7734 23 14.4817 23 13C23 11.1362 21.7252 9.57006 20 9.12602V7C20 4.79086 18.2091 3 16 3H8ZM18 9.12602C16.2748 9.57006 15 11.1362 15 13H9C9 11.1362 7.72523 9.57006 6 9.12602V7C6 5.89543 6.89543 5 8 5H16C17.1046 5 18 5.89543 18 7V9.12602ZM9 15H15V16H17V13C17 11.8954 17.8954 11 19 11C20.1046 11 21 11.8954 21 13C21 13.8693 20.4449 14.6114 19.6668 14.8865C19.2672 15.0277 19 15.4055 19 15.8293V18H5V15.8293C5 15.4055 4.73284 15.0277 4.33325 14.8865C3.5551 14.6114 3 13.8693 3 13C3 11.8954 3.89543 11 5 11C6.10457 11 7 11.8954 7 13V16H9V15Z"></path>
                </svg>
            </span>
            <span class="pibt">
                <span class="bt"><?php _e('position', 'nader'); ?></span>
                <span class="ba"><?php echo esc_html($position); ?></span>
            </span>
        </div>
    <?php } ?>
    <?php if (!empty($expertise)) { ?>
        <div class="expertise pib d-flex align-items-center">
            <span class="icon d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5.32943 3.27152C6.56252 2.83314 7.9923 3.10743 8.97927 4.0944C10.1002 5.21531 10.3019 6.90735 9.5843 8.23378L20.293 18.9436L18.8788 20.3579L8.16982 9.64869C6.84325 10.3668 5.15069 10.1653 4.02952 9.04415C3.04227 8.0569 2.7681 6.62659 3.20701 5.39326L5.44373 7.62994C6.02952 8.21572 6.97927 8.21572 7.56505 7.62994C8.15084 7.04415 8.15084 6.0944 7.56505 5.50862L5.32943 3.27152ZM15.6968 5.15506L18.8788 3.38729L20.293 4.80151L18.5252 7.98349L16.7574 8.33704L14.6361 10.4584L13.2219 9.04415L15.3432 6.92283L15.6968 5.15506ZM8.97927 13.2868L10.3935 14.701L5.09018 20.0043C4.69966 20.3948 4.06649 20.3948 3.67597 20.0043C3.31334 19.6417 3.28744 19.0698 3.59826 18.6773L3.67597 18.5901L8.97927 13.2868Z"></path>
                </svg>
            </span>
            <span class="pibt">
                <span class="bt"><?php _e('expertise', 'nader'); ?></span>
                <span class="ba"><?php echo esc_html($expertise); ?></span>
            </span>
        </div>
    <?php } ?>
    <?php if (!empty($work_experience)) { ?>
        <div class="work_experience pib d-flex align-items-center">
            <span class="icon d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 2H20V6.45994L13.5366 12L20 17.5401V22H4V17.5401L10.4634 12L4 6.45994V2ZM12 10.6829L18 5.54007V4H6V5.54007L12 10.6829ZM12 13.3171L6 18.4599V20H18V18.4599L12 13.3171Z"></path>
                </svg>
            </span>
            <span class="pibt">
                <span class="bt"><?php _e('experience', 'nader'); ?></span>
                <span class="ba"><?php echo esc_html($work_experience); ?></span>
            </span>
        </div>
    <?php } ?>
    <?php if (!empty($email)) { ?>
        <div class="email pib d-flex align-items-center">
            <span class="icon d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 3C21.5523 3 22 3.44772 22 4V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V19H20V7.3L12 14.5L2 5.5V4C2 3.44772 2.44772 3 3 3H21ZM8 15V17H0V15H8ZM5 10V12H0V10H5ZM19.5659 5H4.43414L12 11.8093L19.5659 5Z"></path>
                </svg>
            </span>
            <span class="pibt">
                <span class="bt"><?php _e('email', 'nader'); ?></span>
                <span class="ba"><?php echo esc_html($email); ?></span>
            </span>
        </div>
    <?php } ?>
    <?php if (!empty($contact_number)) { ?>
        <div class="contact_number pib d-flex align-items-center">
            <span class="icon d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"></path>
                </svg>
            </span>
            <span class="pibt">
                <span class="bt"><?php _e('contact number', 'nader'); ?></span>
                <span class="ba"><?php echo esc_html($contact_number); ?></span>
            </span>
        </div>
    <?php } ?>

</div>
