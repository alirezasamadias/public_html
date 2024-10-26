<?php

defined('ABSPATH') || exit;

/**
 * add upgrade.php to access $wpdb
 */
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

/**
 * add pluggable.php to access nonce functionality
 */
require_once ABSPATH . 'wp-includes/pluggable.php';

final class AeWishlist{


    private $uri = '';
    public static $instance = null;
    private string $table_name = 'ae_wishlist';
    private int $user_id = 0;
    private int $post_id = 0;
    private string $post_type = '';

    public function __construct()
    {
        $this->uri = trailingslashit(get_stylesheet_directory_uri()) . 'parts/wishlist/assets/';
        add_action('after_switch_theme', [$this, 'create_wp_table']);
        $this->enqueue_assets();
        $this->ajax_setup();
        $this->set_user_id();
        $this->attach_menu_to_account();
        if (is_admin()) {
            $this->attach_wishlist_to_user_profile_in_admin_panel();
            $this->create_table_manually();
        }
    }


    /**
     * Returns an instance of AeWishlist class, makes instance if not exists
     */
    public static function get_instance()
    {
        if (self::$instance == null) {
            self::$instance = new AeWishlist();
        }

        return self::$instance;
    }

    /**
     * Load plugin assets
     */
    private function enqueue_assets()
    {
        add_action('wp_enqueue_scripts', function() {
            wp_enqueue_style('ae-wishlist-style', $this->uri . 'style.min.css');
            wp_enqueue_script('ae-wishlist-script', $this->uri . 'script.js', array('jquery'), null, true);
        });
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style('ae-wishlist-style', $this->uri . 'style.min.css');
            wp_enqueue_script('ae-wishlist-script', $this->uri . 'script.js', array('jquery'), null, true);
        });
    }

    public function ajax_setup()
    {
        foreach (['wp_enqueue_scripts', 'admin_enqueue_scripts'] as $item) {
            add_action($item, function() {
                wp_localize_script('ae-wishlist-script', 'AE_WISHLIST_AJAX_OBJ', [
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce'    => wp_create_nonce('ae-wishlist-nonce'),
                    'msg'      => [
                        'processing' => __('Processing data...', 'nader'),
                        'error'      => __('A problem has arisen', 'nader'),
                        'must_login' => __('You must be logged in to be able add this to your account!', 'nader'),
                    ]
                ]);
            });
        }

        add_action('wp_ajax_ae_wishlist_process', [$this, 'process_ajax']);
    }

    private function set_user_id(int $user_id = 0)
    {
        if ($user_id === 0) {
            if (is_admin()) {
                if (!empty($_GET['user_id'])) {
                    $this->user_id = (int)$_GET['user_id'];
                } else {
                    $this->user_id = get_current_user_id();
                }
            } else {
                $this->user_id = get_current_user_id();
            }
        } else {
            $this->user_id = $user_id;
        }
    }

    /**
     * Create database table to store data if table not exist
     */
    public function create_wp_table()
    {
        global $wpdb;
        $db_table_name = $wpdb->prefix . $this->table_name;

        $db_create_table_query = "
        CREATE TABLE $db_table_name (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            post_id BIGINT UNSIGNED NOT NULL,
            post_type VARCHAR(50) NOT NULL
        )
        ";

        maybe_create_table($db_table_name, $db_create_table_query);
    }

    /**
     * Add menu to my account menu and display the posts
     */
    private function attach_menu_to_account()
    {
        add_filter('woocommerce_account_menu_items', function($menu_links) {
            $menu_links = array_slice($menu_links, 0, 5, true) + array('ae-wishlist' => __('Wishlist', 'nader')) + array_slice($menu_links, 5, NULL, true);
            return $menu_links;
        }, 40);

        add_action('init', function() {
            add_rewrite_endpoint('ae-wishlist', EP_PAGES);
        });

        add_action('woocommerce_account_ae-wishlist_endpoint', function() {
            require_once trailingslashit(plugin_dir_path(__FILE__)) . 'view/woocommerce.php';
        });
    }

    private function attach_wishlist_to_user_profile_in_admin_panel()
    {
        add_action('show_user_profile', function() {
            require plugin_dir_path(__FILE__) . 'view/user-profile.php';
        });
        add_action('edit_user_profile', function() {
            require plugin_dir_path(__FILE__) . 'view/user-profile.php';
        });
    }

    private function create_table_manually()
    {
        global $wpdb;
        $db_table_name = $wpdb->prefix . $this->table_name;
        $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($db_table_name));
        if (!$wpdb->get_var($query) == $this->table_name) {
            $this->create_wp_table();
        }
    }

    /**
     * determine if post added to user account
     */
    public function is_post_already_added(int $post_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;
        $QUERY = "SELECT * FROM $table_name WHERE post_id = $post_id AND user_id = $this->user_id";
        $wpdb->get_results($QUERY);
        if ($wpdb->num_rows) {
            return true;
        }

        return false;
    }

    private function increase_sum()
    {
        $prev_val = get_post_meta($this->post_id, '_ae-wishlist', true);
        if (empty($prev_val)) {
            $prev_val = 0;
        } else {
            $prev_val += 1;
        }
        update_post_meta($this->post_id, '_ae-wishlist', $prev_val);
    }

    private function decrease_sum()
    {
        $prev_val = get_post_meta($this->post_id, '_ae-wishlist', true);
        if ($prev_val > 0) {
            $prev_val -= 1;
        }
        update_post_meta($this->post_id, '_ae-wishlist', $prev_val);
    }

    /**
     * Add post to table
     */
    private function add()
    {
        global $wpdb;
        $data = [
            'post_id'   => $this->post_id,
            'user_id'   => $this->user_id,
            'post_type' => $this->post_type
        ];
        $res = $wpdb->insert($wpdb->prefix . $this->table_name, $data);
        $this->increase_sum();
        return $res;
    }

    /**
     * Delete post from table
     */
    private function delete()
    {
        global $wpdb;
        $where = [
            'post_id' => $this->post_id,
            'user_id' => $this->user_id
        ];
        $res = $wpdb->delete($wpdb->prefix . $this->table_name, $where);
        $this->decrease_sum();
        return $res;
    }

    public function process_ajax()
    {

        /**
         * Check the nonce for security
         */
        check_ajax_referer('ae-wishlist-nonce', 'ae-wishlist-nonce');

        /**
         * sanitize the $_POST
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_POST = array_map(function($e) {
            return trim($e);
        }, $_POST);

        /**
         * check the process type -> it must be one of add/delete
         */
        $action = $_POST['type'];
        if (!in_array($action, ['add', 'delete'])) {
            wp_send_json_error(__('Invalid action.', 'nader'));
        }

        /**
         * Check WordPress post exist
         */
        $this->post_id = $_POST['post_id'];
        if (!empty($this->post_id) && $this->post_id > 0) {
            $post = get_post($this->post_id);
            if ($post === null) {
                wp_send_json_error(__('Post ID not found.', 'nader'));
            }
        } else {
            wp_send_json_error(__('Post ID is empty!', 'nader'));
        }


        /**
         * Check user exist and set user_id for admin in admin panel to be able to delete favorite for another user
         */
        if (!empty($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user = get_userdata($user_id);
            if ($user === false) {
                wp_send_json_error(__('User not found.', 'nader'));
            } else {
                $this->set_user_id($user_id);
            }
        }


        if (!empty($_POST['post_type'])) {
            if (!in_array($_POST['post_type'], get_post_types())) {
                wp_send_json_error(__('Post type not exist!', 'nader'));
            }
            $this->post_type = $_POST['post_type'];
        } else {
            wp_send_json_error(__('Post type is empty!', 'nader'));
        }


        /**
         * check the selected post already exist in user account or not if action is add
         */
        if ($action === 'add' && $this->is_post_already_added($this->post_id)) {
            wp_send_json_error(__('This post is already added.', 'nader'));
        }


        /**
         * check the selected post not exist in user account if action is delete
         */
        if ($action === 'delete' && !$this->is_post_already_added($this->post_id)) {
            wp_send_json_error(__('There is no such post in your account', 'nader'));
        }

        if ($action == 'add') {
            $res = $this->add();
            if ($res) {
                wp_send_json_success([
                    'status' => true,
                    'msg'    => __('Added successfully.', 'nader')
                ]);
            }
        } elseif ($action == 'delete') {
            $res = $this->delete();
            if ($res) {
                wp_send_json_success([
                    'status' => true,
                    'msg'    => __('Deleted successfully.', 'nader')
                ]);
            }
        }

        die();
    }

    public static function icon_add()
    {
        return apply_filters('ae-wishlist/icon/add', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 21.652c-.31 0-.61-.04-.86-.13-3.82-1.31-9.89-5.96-9.89-12.83 0-3.5 2.83-6.34 6.31-6.34 1.69 0 3.27.66 4.44 1.84a6.214 6.214 0 0 1 4.44-1.84c3.48 0 6.31 2.85 6.31 6.34 0 6.88-6.07 11.52-9.89 12.83-.25.09-.55.13-.86.13Zm-4.44-17.8c-2.65 0-4.81 2.17-4.81 4.84 0 6.83 6.57 10.63 8.88 11.42.18.06.57.06.75 0 2.3-.79 8.88-4.58 8.88-11.42 0-2.67-2.16-4.84-4.81-4.84-1.52 0-2.93.71-3.84 1.94-.28.38-.92.38-1.2 0a4.77 4.77 0 0 0-3.85-1.94Z"></path></svg>');
    }

    public static function icon_delete()
    {
        return apply_filters('ae-wishlist/icon/delete', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.44 3.102c-1.81 0-3.43.88-4.44 2.23a5.549 5.549 0 0 0-4.44-2.23c-3.07 0-5.56 2.5-5.56 5.59 0 1.19.19 2.29.52 3.31 1.58 5 6.45 7.99 8.86 8.81.34.12.9.12 1.24 0 2.41-.82 7.28-3.81 8.86-8.81.33-1.02.52-2.12.52-3.31 0-3.09-2.49-5.59-5.56-5.59Z"></path></svg>');
    }

    /**
     * return a list of posts that user bookmarked
     */
    public function fetch_posts(int $limit = -1, string $post_type = '')
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;
        $QUERY = "SELECT * FROM $table_name WHERE user_id = $this->user_id";
        if (!empty($post_type) && in_array($post_type, get_post_types())) {
            $QUERY .= " AND post_type = $post_type";
        }
        if (is_int($limit) && $limit > 0) {
            $QUERY .= " LIMIT " . $limit;
        }
        return $wpdb->get_results($QUERY);
    }

}

$wishlist = AeWishlist::get_instance();

function ae_wishlist_btn($post_id, $icon_add = '', $icon_delete = '')
{

    if (is_user_logged_in()) {

        global $wishlist;
        if ($wishlist->is_post_already_added($post_id)) {
            $user_id = 0;
            if (!empty($_GET['user_id'])) {
                $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $user_id = $_GET['user_id'];
            }
            ?>
            <form method="post" class="ae-wishlist-form added">
                <?php wp_nonce_field('ae-wishlist-nonce', 'ae-wishlist-nonce') ?>
                <input type="hidden" name="type" class="ae-wishlist-input-type" value="delete">
                <input type="hidden" name="post_id" class="ae-wishlist-input-post-id"
                       value="<?php echo esc_html($post_id); ?>">
                <input type="hidden" name="post_type" class="ae-wishlist-input-post-type"
                       value="<?php echo esc_html(get_post_type($post_id)); ?>">
                <?php if (!empty($user_id)) { ?>
                    <input type="hidden" name="user_id" value="<?php echo esc_html($user_id); ?>">
                <?php } ?>
                <button type="submit" name="ae-wishlist-submit" class="ae-wishlist-btn">
                    <span class="add-icon">
                        <?php
                        if (!empty($icon_add)) {
                            echo $icon_add;
                        } else {
                            echo $wishlist::icon_add();
                        }
                        ?>
                    </span>
                    <span class="delete-icon">
                        <?php
                        if (!empty($icon_delete)) {
                            echo $icon_delete;
                        } else {
                            echo $wishlist::icon_delete();
                        }
                        ?>
                    </span>
                </button>
            </form>
            <?php
            return;
        }

        ?>
        <form method="post" class="ae-wishlist-form">
            <?php wp_nonce_field('ae-wishlist-nonce', 'ae-wishlist-nonce') ?>
            <input type="hidden" name="type" class="ae-wishlist-input-type" value="add">
            <input type="hidden" name="post_id" class="ae-wishlist-input-post-id"
                   value="<?php echo esc_html($post_id); ?>">
            <input type="hidden" name="post_type" class="ae-wishlist-input-post-type"
                   value="<?php echo esc_html(get_post_type($post_id)); ?>">
            <button type="submit" name="ae-wishlist-submit" class="ae-wishlist-btn">
                <span class="add-icon">
                    <?php
                    if (!empty($icon_add)) {
                        echo $icon_add;
                    } else {
                        echo $wishlist::icon_add();
                    }
                    ?>
                </span>
                <span class="delete-icon">
                    <?php
                    if (!empty($icon_delete)) {
                        echo $icon_delete;
                    } else {
                        echo $wishlist::icon_delete();
                    }
                    ?>
                </span>
            </button>
        </form>
        <?php
    } else {
        global $wishlist;
        ?>
        <span class="ae-wishlist-btn must-login-btn">
            <span class="icon-add">
                <?php
                if (!empty($icon_add)) {
                    echo $icon_add;
                } else {
                    echo $wishlist::icon_add();
                }
                ?>
            </span>
        </span>
        <?php
    }

}
