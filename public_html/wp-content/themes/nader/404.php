<?php

defined( 'ABSPATH' ) || die();

get_header();

?>

    <div class="main">
        <div class="page404">
            <div class="content text-center">
                <h1>404</h1>
                <h2>صفحه یافت نشد.</h2>
                <p>صفحه مورد نظر شما پیدا نشد.</p>
                <a href="<?php echo site_url( '/' ); ?>"
                   title="بازگشت به صفحه اصلی" class="theme-btn">بازگشت به صفحه
                    اصلی</a>
            </div>
        </div>
    </div>

<?php

get_footer();

