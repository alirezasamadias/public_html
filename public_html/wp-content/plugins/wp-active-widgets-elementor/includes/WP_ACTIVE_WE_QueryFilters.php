<?php

use Elementor\Controls_Manager;

defined('ABSPATH') || die();

trait WP_ACTIVE_WE_QueryFilters{

    protected function FilterSettings()
    {
        AE_E_UTILS::SWITCH_FIELD($this, 'enable-filters', 'فیلتر داشته باشد؟', 'yes');
        AE_E_UTILS::SELECT_FIELD($this, 'filter', 'تکسونومی فیلتر', AE_E_FUNCTIONS::getRegisteredTaxonomies(), 'category', 'enable-filters', 'yes');
    }

    protected function FilterStyles()
    {
        //filter style
        AE_E_UTILS::SECTION_START($this, 'filter-section', 'فیلتر', 'style', 'enable-filters', 'yes');
        AE_E_UTILS::H_ALIGNMENT_MIN($this, 'filter-alignment', '.filter-buttons');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'filter-margin', 'فاصله', 0, 100, null, '.filter-buttons', 'margin-bottom');
        AE_E_UTILS::FONT_FIELD($this, 'filter-font', 'تایپوگرافی', '.filter-buttons button');
        AE_E_UTILS::SLIDER_FIELD_PIX_STYLE($this, 'filter-items-gap', 'فاصله بین آیتم ها', 0, 100, null, '.filter-buttons', 'gap');
        // filter button tabs
        AE_E_UTILS::TAB_START($this, 'filter-button');
        AE_E_UTILS::DynamicStyleControls($this, 'filter-button-normal-styles', '.filter-buttons button', [
            'padding',
            'color',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_MIDDLE_($this, 'filter-button', 'حالت فعال');
        AE_E_UTILS::DynamicStyleControls($this, 'filter-button-active-styles', '.filter-buttons button.active', [
            'padding',
            'color',
            'bg',
            'border',
            'radius',
            'shadow'
        ]);
        AE_E_UTILS::TAB_END($this);

        AE_E_UTILS::SECTION_END($this);
    }

    protected function FilterStructureForAjax()
    {
        return [
            'all' => '<button class="active" data-filter=".all" data-class-name="all">' . __('All', 'wp-active-widgets-elementor') . '</button>',
            'btn' => '<button data-filter="{filter_select}" data-class-name="{filter_class}" title="{filter_title}">{filter_title}</button>'
        ];
    }

    protected function FilterPlaceholder()
    {
        ?>
        <div class="filter-buttons dfx wrap aic jcc ae-gap-5 animated-placeholder">
            <span class="btn dfx skeleton-bg"></span>
            <span class="btn dfx skeleton-bg"></span>
            <span class="btn dfx skeleton-bg"></span>
            <span class="btn dfx skeleton-bg"></span>
            <span class="btn dfx skeleton-bg"></span>
        </div>
        <?php
    }

    protected function DisplayFilters($query)
    {
        $settings = $this->get_settings_for_display();
        $enable_filter = $settings['enable-filters'];
        if (empty($enable_filter)) {
            return;
        }
        $taxonomy = $settings['filter'];
        $filters = AE_E_FUNCTIONS::extractQueryTerms($query, $taxonomy);
        if (empty($filters)) {
            return;
        }

        ?>
        <div class="filter-buttons dfx wrap aic jcc ae-gap-5">
            <button class="active" data-filter=".all" data-class-name="all">
                <?php _e('All', 'wp-active-widgets-elementor'); ?>
            </button>
            <?php foreach ($filters as $filter) { ?>
                <button data-filter=".<?php echo esc_attr(key($filter)); ?>"
                        data-class-name="<?php echo esc_attr(key($filter)); ?>"
                        title="<?php echo esc_html(current($filter)); ?>">
                    <?php echo esc_html(current($filter)); ?>
                </button>
            <?php } ?>
        </div>
        <?php
    }

}