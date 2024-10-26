<?php
defined('ABSPATH') || die("Access denied.");

class AeVariationSwatches{

    protected static $instance = null;

    private string $assets_uri = '';

    private array $attribute_types = [
        'select' => 'انتخاب',
        'button' => 'دکمه',
        'color'  => 'رنگ',
        'image'  => 'تصویر',
    ];

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->assets_uri = get_template_directory_uri() . '/parts/variation-swatches/assets/';
        $this->enqueue_assets();
        $this->enqueue_wp_media();
        $this->register_attributes_type();
        $this->setup_attribute_hooks();
        $this->display_variations();
    }

    /**
     * Implement wp color picker for attribute add and edit page
     */
    private function enqueue_assets()
    {
        add_action('admin_enqueue_scripts', function($hook_suffix) {
            if (in_array($hook_suffix, ['edit-tags.php', 'term.php'])) {
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_style('ae-variation-swatches-admin', $this->assets_uri . 'ae-variation-swatches-admin.min.css');
                wp_enqueue_script('ae-variation-swatches-admin', $this->assets_uri . 'ae-variation-watches-admin.js', ['wp-color-picker'], false, true);
            }
        });

        add_action('wp_enqueue_scripts', function($hook_suffix) {
            wp_enqueue_style('ae-variation-swatches-frontend', $this->assets_uri . 'ae-variation-swatches-frontend.min.css');
            wp_enqueue_script('ae-variation-swatches-frontend', $this->assets_uri . 'ae-variation-watches-frontend.js', ['jquery'], false, true);
        });
    }

    /**
     * Implement wp media for attribute add and edit page
     */
    private function enqueue_wp_media()
    {
        if (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'product' && isset($_GET['taxonomy'])) {
            wp_enqueue_media();
        }
        // Localize Scripts.
        add_action('admin_enqueue_scripts', function($hook_suffix) {
            if (in_array($hook_suffix, ['edit-tags.php', 'term.php'])) {
                wp_localize_script('ae-variation-swatches-js', 'AeVariationSwatchesObj', array(
                    'placeholder_img' => $this->assets_uri . 'placeholder.png',
                ));
            }
        });
    }

    /**
     * add attributes types to page=product_attributes
     */
    private function register_attributes_type()
    {
        add_filter('product_attributes_type_selector', function($fields) {
            if (!function_exists('get_current_screen')) {
                return $fields;
            }

            $current_screen = get_current_screen();

            if (isset($current_screen->base) && 'product_page_product_attributes' === $current_screen->base) {
                $fields = wp_parse_args($fields, $this->attribute_types);
            }
            return $fields;
        });
    }


    private function get_attr_tax_by_name($taxonomy_name)
    {
        global $wpdb;
        $taxonomy_name = preg_replace('/^pa_/i', '', $taxonomy_name);
        $attribute_taxonomy = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s", $taxonomy_name));

        return $attribute_taxonomy;
    }


    /**
     * Fire hooks in order to display fields
     */
    private function setup_attribute_hooks()
    {
        if (empty(wc_get_attribute_taxonomies())) {
            return;
        }

        foreach (wc_get_attribute_taxonomies() as $attribute_taxonomy) {

            $attribute_taxonomy_name = wc_attribute_taxonomy_name($attribute_taxonomy->attribute_name);

            add_action($attribute_taxonomy_name . '_add_form_fields', array($this, 'add_attribute_fields'));
            add_action($attribute_taxonomy_name . '_edit_form_fields', array($this, 'edit_attribute_fields'), 10, 2);

            add_filter('manage_edit-' . $attribute_taxonomy_name . '_columns', array($this, 'add_attribute_columns'));
            add_filter('manage_' . $attribute_taxonomy_name . '_custom_column', array(
                $this,
                'add_attribute_column_content',
            ), 10, 3);

        }

        add_action('created_term', array($this, 'save_term_meta'));
        add_action('edit_term', array($this, 'save_term_meta'));

    }


    private function get_attribute_label($attribute_taxonomy)
    {

        switch ($attribute_taxonomy->attribute_type) {
            case 'color':
                echo 'رنگ';
                break;
            case 'image':
                echo 'تصویر';
                break;
        }
    }

    private function get_attribute_field($attribute_taxonomy, $value = '')
    {
        switch ($attribute_taxonomy->attribute_type) {
            case 'color':
                ?>
                <input type="text" id="term-<?php echo $attribute_taxonomy->attribute_type; ?>"
                       name="<?php echo $attribute_taxonomy->attribute_type; ?>"
                       value="<?php echo esc_attr($value); ?>">
                <?php
                break;
            case 'image':
                $image = $value ? wp_get_attachment_image_src($value) : '';
                $image = $image ? $image[0] : $this->assets_uri . 'placeholder.png';
                ?>
                <img class="ae-variation-swatches-image-preview" src="<?php echo esc_url($image); ?>"/>
                <div class="variation-swatches-button-container">
                    <input type="hidden" class="variation-swatches-term-image" name="image"
                           value="<?php echo esc_attr($value); ?>"/>
                    <button type="button" class="variation-swatches-upload-image-btn button"
                            style="margin-left: 10px;">انتخاب تصویر
                    </button>
                    <button type="button"
                            class="variation-swatches-remove-image-btn button button-link-delete <?php echo $value ? '' : 'hidden'; ?>">
                        حذف تصویر
                    </button>
                </div>
                <?php
                break;
        }
    }

    /**
     * Render html select field to be able to choose attribute type by user
     *
     * @param $taxonomy
     * @return void
     */
    public function add_attribute_fields($taxonomy)
    {
        $attribute_tax = $this->get_attr_tax_by_name($taxonomy);
        if (in_array($attribute_tax->attribute_type, array('select', 'text'), true)) {
            return;
        }
        ?>
        <div class="form-field term-slug-wrap">
            <label for="term-<?php echo $attribute_tax->attribute_type; ?>"><?php $this->get_attribute_label($attribute_tax); ?></label>
            <?php $this->get_attribute_field($attribute_tax); ?>
        </div>
        <?php
    }

    public function edit_attribute_fields($term, $taxonomy)
    {
        $attribute_tax = $this->get_attr_tax_by_name($taxonomy);

        // Return if this is a default attribute type.
        if (in_array($attribute_tax->attribute_type, array('select', 'text'), true)) {
            return;
        }

        $value = get_term_meta($term->term_id, $attribute_tax->attribute_type, true);
        ?>

        <tr class="form-field term-slug-wrap">
            <th scope="row">
                <label for="term-<?php echo $attribute_tax->attribute_type; ?>"> <?php echo esc_html($this->get_attribute_label($attribute_tax)); ?> </label>
            </th>
            <td>
                <?php $this->get_attribute_field($attribute_tax, $value); ?>
            </td>
        </tr>

        <?php
    }


    /**
     * Save attribute term meta
     *
     * @param int $term_id Term ID.
     *
     * @return void
     * @since 1.0.0
     */
    public function save_term_meta($term_id)
    {

        foreach ($this->attribute_types as $swatches_type => $label) {
            if (!empty($_REQUEST[$swatches_type])) {
                update_term_meta($term_id, $swatches_type, sanitize_text_field(wp_unslash($_REQUEST[$swatches_type])));
            }
        }

        // Save image type attribute terms images.
        if (isset($_REQUEST['image'])) {
            update_term_meta($term_id, 'image', intval($_REQUEST['image']));
        }
    }


    /**
     * Add extra custom column on attribute term screen list
     *
     * @param array $columns Columns Array.
     *
     * @return array
     * @since 1.0.0
     */
    public function add_attribute_columns($columns)
    {
        $new_columns = array();
        $new_columns['cb'] = !empty($columns['cb']) ? $columns['cb'] : '';
        $new_columns['thumb'] = 'تصویر';
        unset($columns['cb']);
        return array_merge($new_columns, $columns);
    }


    /**
     * Render thumbnail HTML for attributes terms depend on attribute type
     *
     * @param $columns
     * @param $column
     * @param $term_id
     * @return void
     */
    public function add_attribute_column_content($columns, $column, $term_id)
    {
        $taxonomy = '';
        if (!empty($_REQUEST['taxonomy'])) {
            $taxonomy = esc_attr(wp_unslash($_REQUEST['taxonomy']));
        }
        if (empty($taxonomy)) {
            return;
        }

        $attribute_tax = $this->get_attr_tax_by_name($taxonomy);
        $value = get_term_meta($term_id, $attribute_tax->attribute_type, true);

        switch ($attribute_tax->attribute_type) {

            case 'color':
                printf('<div class="variation-swatches-preview swatches-type-color" style="background-color:%s;"></div>', esc_attr($value));
                break;

            case 'image':
            case 'select':
            case 'button':
                $image = !empty($value) ? wp_get_attachment_image_src($value) : '';
                $image = $image ? $image[0] : $this->assets_uri . 'placeholder.png';

                printf('<img class="variation-swatches-preview swatches-type-image" src="%s" width="44px" height="44px">', esc_url($image));
                break;
        }
    }


    private function display_variations()
    {
        add_filter('woocommerce_dropdown_variation_attribute_options_html', array(
            $this,
            'variation_attribute_options_html'
        ), 199, 2);
    }


    public function variation_attribute_options_html($html, $args)
    {
        $term_html = '';
        $attr_id = wc_attribute_taxonomy_id_by_name($args['attribute']);

        $options = $args['options'];
        $product = $args['product'];
        $attribute = $args['attribute'];

        if ($attr_id) {
            $attr_info = wc_get_attribute($attr_id);
            $curr['type'] = isset($attr_info->type) ? $attr_info->type : '';

            if (in_array($curr['type'], ['color', 'image', 'select', 'button', 'radio'])) {
                $term_html .= '<div class="ae-variation-swatches-terms ae-variation-swatches-type-' . esc_attr($curr['type']) . ' ' . esc_attr($args['attribute']) . '" data-attribute="' . esc_attr($args['attribute']) . '">';

                if ($product && taxonomy_exists($attribute)) {
                    $terms = wc_get_product_terms($product->get_id(), $attribute, array(
                        'fields' => 'all',
                    ));

                    foreach ($terms as $term) {
                        if (in_array($term->slug, $options, true)) {
                            $val = get_term_meta($term->term_id, $curr['type'], true) ?: '';
                            switch ($curr['type']) {
                                case 'color':
                                    $style = !empty($val) ? ' style="background-color:' . esc_attr($val) . '"' : '';
                                    $term_html .= '<span class="variation-term" data-term="' . esc_attr($term->slug) . '"' . $style . '><span class="variation-tooltip">' . esc_html($term->name) . '</span></span>';
                                    break;
                                case 'image':
                                    $img = $val ? wp_get_attachment_image_url($val) : $this->assets_uri . 'placeholder.png';
                                    $term_html .= '<span class="variation-term" data-term="' . esc_attr($term->slug) . '"><img src="' . esc_url($img) . '" alt="' . esc_attr($term->name) . '"/>';
                                    $term_html .= '<span class="variation-tooltip"><img src="' . esc_url($img) . '" alt="' . esc_attr($term->name) . '"/></span>';
                                    $term_html .= '</span>';
                                    break;
                                case 'select':
                                case 'button':
                                case 'radio':
                                    $term_html .= '<span class="variation-term" data-term="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</span>';
                                    break;
                            }

                        }
                    }
                }

                $term_html .= '</div>';
            }
        }
        return $term_html . $html;
    }


}

if (function_exists('WC')) {
    $ae_variation_swatches = new AeVariationSwatches();
}
