<?php
defined('ABSPATH') || die();

?>

<div class="page-actions d-flex align-items-center justify-content-between pb-3 mb-4">
    <div class="box-1 d-flex align-items-center gap-1">
        <div class="font-size-changer d-flex align-items-center gap-2" data-font-size-changer-target=".single-content-section .post-content" data-default-font-size="16px">

            <span class="font-size-ch-btn fz-reset dfx aic jcc cursor-pointer disable-select">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M10 6v15H8V6H2V4h14v2h-6zm8 8v7h-2v-7h-3v-2h8v2h-3z"/>
                </svg>
            </span>

            <div class="btn-actions d-flex align-items-center gap-1">
                <span class="font-size-ch-btn fz-increase dfx aic jcc cursor-pointer disable-select">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/>
                    </svg>
                </span>
                <span class="font-size-ch-btn fz-decrease dfx aic jcc cursor-pointer disable-select">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M5 11h14v2H5z"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div class="box-2 d-flex align-items-center justify-content-end">
        <?php get_template_part('parts/global/share'); ?>
    </div>
</div>
