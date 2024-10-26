<?php
defined( 'ABSPATH' ) || exit;

use Elementor\Base_Data_Control;

class Autocomplete extends Base_Data_Control {

    public function get_type()
    {
        return 'wp_active_we_autocomplete';
    }

    protected function get_default_settings() {
        return [
            'label_block' => true,
            'multiple'    => false,
            'taxonomy'    => false,
            'post_type'   => false,
            'options'     => [],
            'callback'    => '',
        ];
    }

    public function enqueue() {
        wp_enqueue_script( 'wp-active-we-autocomplete-control', AE_E_JS_DIR . 'control.auto-complete.js', [ 'jquery' ], false, false );
    }

    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}" data-post-type="{{ data.post_type }}" data-taxonomy="{{ data.taxonomy }}" data-placeholder="جستجو">
                    <# _.each( data.options, function( option_title, option_value ) {
                    var value = data.controlValue;
                    if ( typeof value == 'string' ) {
                    var selected = ( option_value === value ) ? 'selected' : '';
                    } else if ( null !== value ) {
                    var value = _.values( value );
                    var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
                    }
                    #>
                    <option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
