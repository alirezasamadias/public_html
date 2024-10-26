<?php
defined('ABSPATH') || die();
$disable_page_title = get_post_meta(get_the_ID(), 'disable-page-title', true);
?>
<?php if ($disable_page_title == false) { ?>
    <div class="page-title d-flex align-items-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="none" d="M0 0h24v24H0z"></path>
            <path d="M19 22H5a3 3 0 0 1-3-3V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12h4v4a3 3 0 0 1-3 3zm-1-5v2a1 1 0 0 0 2 0v-2h-2zm-2 3V4H4v15a1 1 0 0 0 1 1h11zM6 7h8v2H6V7zm0 4h8v2H6v-2zm0 4h5v2H6v-2z"></path>
        </svg>
        <h1><?php the_title(); ?></h1>
    </div>
<?php }
