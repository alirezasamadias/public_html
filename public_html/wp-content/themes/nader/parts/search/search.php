<?php
defined('ABSPATH') || die();
?>

<div class="search-box popup-box">

    <div class="popup-box-header d-flex align-items-center justify-content-between">
        <b class="title"><?php _e('Search', 'nader'); ?></b>
        <span class="popup-box-closer d-flex align-items-center justify-content-center cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path opacity=".4"
                      d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"></path>
                <path d="m13.06 12 2.3-2.3c.29-.29.29-.77 0-1.06a.754.754 0 0 0-1.06 0l-2.3 2.3-2.3-2.3a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l2.3 2.3-2.3 2.3c-.29.29-.29.77 0 1.06.15.15.34.22.53.22s.38-.07.53-.22l2.3-2.3 2.3 2.3c.15.15.34.22.53.22s.38-.07.53-.22c.29-.29.29-.77 0-1.06l-2.3-2.3Z"></path>
            </svg>
        </span>
    </div>
    <!--/.search-header-->

    <div class="search-form-wrapper popup-box-inner-wrapper">
        <form>
            <div class="search-row">
                <input type="text" class="search-field" name="s" placeholder="<?php _e('Search...', 'nader'); ?>">

                <button type="submit" class="search-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path opacity=".4" d="M11.01 20.02a9.01 9.01 0 1 0 0-18.02 9.01 9.01 0 0 0 0 18.02Z" ></path>
                        <path d="M21.99 18.95c-.33-.61-1.03-.95-1.97-.95-.71 0-1.32.29-1.68.79-.36.5-.44 1.17-.22 1.84.43 1.3 1.18 1.59 1.59 1.64.06.01.12.01.19.01.44 0 1.12-.19 1.78-1.18.53-.77.63-1.54.31-2.15Z" ></path>
                    </svg>
                </button>

                <span class="loading">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"/>
                        <path d="M12 2a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1zm0 15a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0v-3a1 1 0 0 1 1-1zm8.66-10a1 1 0 0 1-.366 1.366l-2.598 1.5a1 1 0 1 1-1-1.732l2.598-1.5A1 1 0 0 1 20.66 7zM7.67 14.5a1 1 0 0 1-.366 1.366l-2.598 1.5a1 1 0 1 1-1-1.732l2.598-1.5a1 1 0 0 1 1.366.366zM20.66 17a1 1 0 0 1-1.366.366l-2.598-1.5a1 1 0 0 1 1-1.732l2.598 1.5A1 1 0 0 1 20.66 17zM7.67 9.5a1 1 0 0 1-1.366.366l-2.598-1.5a1 1 0 1 1 1-1.732l2.598 1.5A1 1 0 0 1 7.67 9.5z"/>
                    </svg>
                </span>

                <span class="advanced-settings-btn cursor-pointer d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path opacity=".4"
                              d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81v8.37C2 19.83 4.17 22 7.81 22h8.37c3.64 0 5.81-2.17 5.81-5.81V7.81C22 4.17 19.83 2 16.19 2Z"
                              ></path>
                        <path d="M15.58 19.252c-.41 0-.75-.34-.75-.75v-3.9c0-.41.34-.75.75-.75s.75.34.75.75v3.9c0 .41-.34.75-.75.75ZM15.58 8.2c-.41 0-.75-.34-.75-.75V5.5c0-.41.34-.75.75-.75s.75.34.75.75v1.95c0 .41-.34.75-.75.75ZM8.42 19.25c-.41 0-.75-.34-.75-.75v-1.95c0-.41.34-.75.75-.75s.75.34.75.75v1.95c0 .41-.33.75-.75.75ZM8.42 10.15c-.41 0-.75-.34-.75-.75V5.5c0-.41.34-.75.75-.75s.75.34.75.75v3.9c0 .41-.33.75-.75.75Z"
                              ></path>
                        <path d="M15.58 7.328c-1.5 0-2.73 1.22-2.73 2.72 0 1.5 1.22 2.73 2.73 2.73 1.5 0 2.72-1.22 2.72-2.73s-1.22-2.72-2.72-2.72ZM8.42 11.23c-1.5 0-2.72 1.22-2.72 2.73s1.22 2.72 2.72 2.72c1.5 0 2.73-1.22 2.73-2.72 0-1.5-1.22-2.73-2.73-2.73Z"
                              ></path>
                    </svg>
                </span>

            </div>
            <!--/.search-row-->

            <div class="search-advanced-settings-row align-items-center flex-wrap">
                <input type="radio" name="post_type" value="all" id="post-type-all" class="post_type" checked>
                <label for="post-type-all"><?php _e('All', 'nader'); ?></label>

                <input type="radio" name="post_type" value="post" id="post-type-post" class="post_type">
                <label for="post-type-post"><?php _e('Posts', 'nader'); ?></label>

                <input type="radio" name="post_type" value="project" id="post-type-project" class="post_type">
                <label for="post-type-project"><?php _e('Projects', 'nader'); ?></label>

                <input type="radio" name="post_type" value="team" id="post-type-team" class="post_type">
                <label for="post-type-team"><?php _e('Team', 'nader'); ?></label>

                <?php if (RealPressHelper::isActiveWC()) { ?>
                    <input type="radio" name="post_type" value="product" id="post-type-product" class="post_type">
                    <label for="post-type-product"><?php _e('Products', 'nader'); ?></label>
                <?php } ?>
            </div>
            <!--/.search-advanced-settings-row-->

            <?php
            if (RealPressHelper::isActiveAcfPro()) {
                if (have_rows('nader-search-keywords', 'options')) {
                    ?>
                    <ul class="searched-keywords-row d-flex flex-wrap mt-3">
                        <li class="title"><b><?php _e('Most liked keywords:', 'nader'); ?></b></li>
                        <?php
                        while (have_rows('nader-search-keywords', 'options')) {
                            the_row();
                            echo '<li><span class="cursor-pointer">' . get_sub_field('keyword') . '</span></li>';
                        }
                        ?>
                    </ul>
                    <?php
                }
            }
            ?>
        </form>
    </div>

    <div class="search-result"></div>
</div>
