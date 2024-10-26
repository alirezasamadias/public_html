<?php
defined('ABSPATH') || die();

class NaderMenuWalker extends Walker_Nav_Menu{

    public int $menu = 0;
    public string $mega_menu_type = '';
    public string $parent_lvl_0_is = '';

    public function __construct($menu_id = 0)
    {
        $this->menu = $menu_id;
        $this->mega_menu_type = 'menu_simple';
    }


    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        // Default class.
        $classes = array('sub-menu');

        if ($depth == 0 && in_array($this->mega_menu_type, [
                'mega_menu_simple',
                'mega_menu_column',
                'mega_menu_elementor'
            ])) {
            $classes[] = $this->mega_menu_type;
        }

        /**
         * Filters the CSS class(es) applied to a menu list element.
         *
         * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
         * @param stdClass $args An object of `wp_nav_menu()` arguments.
         * @param int $depth Depth of menu item. Used for padding.
         * @since 4.8.0
         *
         */
        $class_names = implode(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));

        $atts = array();
        $atts['class'] = !empty($class_names) ? $class_names : '';

        /**
         * Filters the HTML attributes applied to a menu list element.
         *
         * @param array $atts {
         *     The HTML attributes applied to the `<ul>` element, empty strings are ignored.
         *
         * @type string $class HTML CSS class attribute.
         * }
         * @param stdClass $args An object of `wp_nav_menu()` arguments.
         * @param int $depth Depth of menu item. Used for padding.
         * @since 6.3.0
         *
         */
        $atts = apply_filters('nav_menu_submenu_attributes', $atts, $args, $depth);
        $attributes = $this->build_atts($atts);

        $output .= "{$n}{$indent}<ul{$attributes}>{$n}";
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);

        if ($this->mega_menu_type == 'mega_menu_elementor') {
            $output .= "$indent</div>{$n}";
        } else {
            $output .= "$indent</ul>{$n}";
        }
    }


    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {

        if (!ACF_ENABLED) {
            return;
        }

        $description = !empty(trim($data_object->post_content)) ? trim($data_object->post_content) : '';

        $hasColumnDescription = $this->parent_lvl_0_is == 'mega_menu_column' && $depth == 1 && !empty($description);

        $megaMenuColumnHead = $this->parent_lvl_0_is == 'mega_menu_column' && $depth == 1;

        $mega_menu_type = get_field('menu_type', $data_object, true, true);
        if (!empty($mega_menu_type)) {
            $this->mega_menu_type = $mega_menu_type;

            if ($depth == 0) {
                $this->parent_lvl_0_is = $mega_menu_type;
            }
        }

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
        } else {
            $t = "\t";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($data_object->classes) ? array() : (array)$data_object->classes;
        $classes[] = 'menu-item-' . $data_object->ID;

        if (!in_array($this->mega_menu_type, ['mega_menu_simple', 'mega_menu_column', 'mega_menu_elementor'])) {
            $classes[] = 'menu_simple';
        }

        if ($depth == 0 && $this->mega_menu_type == 'mega_menu_elementor') {
            $classes[] = 'menu-item-has-children';
        }

        $args = apply_filters('nav_menu_item_args', $args, $data_object, $depth);


        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $data_object, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li ' . $class_names . '>';


        /**
         * add link attributes
         */
        $atts = array();
        $atts['title'] = !empty($data_object->attr_title) ? $data_object->attr_title : '';
        $atts['target'] = !empty($data_object->target) ? $data_object->target : '';
        if ('_blank' === $data_object->target && empty($data_object->xfn)) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $data_object->xfn;
        }
        $atts['href'] = !empty($data_object->url) ? $data_object->url : '';
        $atts['aria-current'] = $data_object->current ? 'page' : '';

        $attributes = '';
        $atts['class'] = 'nav-link';
        if ($megaMenuColumnHead) {
            $atts['class'] .= ' mega_menu_column_head';
        }
        foreach ($atts as $attr => $value) {
            if (is_scalar($value) && '' !== $value && false !== $value) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = $data_object->title;

        $item_output = '';
        if (!empty($args->before)) {
            $item_output = $args->before;
        }
        $item_output .= '<a' . $attributes . '>';

        /**
         * add custom icon to item
         */
        $icon_type = get_field('icon-type', $data_object, true, true);
        $icon = '';
        if (!empty($icon_type)) {
            if ($icon_type === 'svg') {
                $icon = get_field('svg', $data_object, true, true);
            } elseif ($icon_type === 'font-icon') {
                $icon = '<i class="' . get_field('font-icon-class', $data_object, true, true) . '"></i>';
            } elseif ($icon_type === 'image') {
                $icon = '<img src="' . get_field('image-link', $data_object, true, true) . '">';
            }
        }

        /**
         * if its mega menu and column has description
         */
        if ($hasColumnDescription) {
            $item_output .= '<span class="mega_menu_column-column_title dfx">' . $icon . $title . '</span>';
            $item_output .= '<span class="mega_menu_column-column_description">' . $description . '</span>';
        } else {
            $item_output .= $icon;
            $item_output .= $title;
        }

        /**
         * add dropdown icon to item
         */
        $dd_icon = '<span class="dropdown-icon dfx aic jcc"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="dd-svg"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg></span>';

        $has_child = in_array('menu-item-has-children', (array)$data_object->classes);
        if ($has_child) {
            if (in_array($this->mega_menu_type, ['', 'menu_simple']) && in_array($this->parent_lvl_0_is, [
                    '',
                    'menu_simple'
                ])) {
                $item_output .= $dd_icon;
            } elseif (in_array($this->mega_menu_type, ['mega_menu_simple', 'mega_menu_column']) && $depth == 0) {
                $item_output .= $dd_icon;
            }
        } elseif ($this->mega_menu_type == 'mega_menu_elementor') {
            $item_output .= $dd_icon;
        }

        $item_output .= '</a>';
        if (!empty($args->after)) {
            $item_output .= $args->after;
        }


        /**
         * elementor mega menu
         */
        if ($this->mega_menu_type == 'mega_menu_elementor') {
            $elementor_template_id = get_field('mega_menu_elementor_template', $data_object, true, true);
            $item_output .= '<div class="mega-menu-box"><div class="sub-menu mega_menu_elementor">' . RealPressHelper::loadElementorContent($elementor_template_id) . '</div></div>';
        }

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $data_object, $depth, $args);

        if ($depth == 0 && in_array($this->parent_lvl_0_is, ['mega_menu_simple', 'mega_menu_column'])) {
            $output .= '<div class="mega-menu-box">';
        }

    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        if ($depth == 0 && in_array($this->parent_lvl_0_is, ['mega_menu_simple', 'mega_menu_column'])) {
            $output .= '</div>';
        }
        $output .= "</li>{$n}";
    }
}