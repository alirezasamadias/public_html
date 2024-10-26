<?php
defined('ABSPATH') || die();

if (ACF_ENABLED) {
$copyright = get_field('copyright-text', 'options');
?>
<!-- Footer -->
<footer class="site-footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12">
                <p class="text-center">
                    <?php echo esc_html($copyright); ?>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php }

wp_footer();

?>

</body>
</html>

<?php
