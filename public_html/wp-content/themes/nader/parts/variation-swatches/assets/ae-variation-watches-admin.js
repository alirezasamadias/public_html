jQuery(document).ready(function ($) {

    /**
     * Implement wp color picker
     */
    $('#term-color').wpColorPicker()


    /**
     * Implement wp media uploader
     */
    let aeVariationSwatchesMedia;
    const selectImageBtn = $('.variation-swatches-upload-image-btn')
    const removeImageBtn = $('.variation-swatches-remove-image-btn')

    selectImageBtn.click(function (e) {

        e.preventDefault();

        if (aeVariationSwatchesMedia) {
            aeVariationSwatchesMedia.open();
            return;
        }

        // Extend the wp.media object
        aeVariationSwatchesMedia = wp.media.frames.file_frame = wp.media({
            title: 'انتخاب تصویر',
            button: {
                text: 'انتخاب تصویر',
            }, multiple: false,
            library: { type: 'image' },
        });

        // When a file is selected, grab the URL and set it as the text field's value
        aeVariationSwatchesMedia.on('select', function () {
            let attachment = aeVariationSwatchesMedia.state().get('selection').first().toJSON()
            $('.variation-swatches-term-image').val(attachment.id)
            $('.ae-variation-swatches-image-preview').attr('src', attachment.url)
            removeImageBtn.removeClass('hidden')
        });
        // Open the upload dialog
        aeVariationSwatchesMedia.open();
    })
    removeImageBtn.click(function (e) {
        e.preventDefault()
        $('.variation-swatches-term-image').val('')
        $('.ae-variation-swatches-image-preview').attr('src', '')
        removeImageBtn.addClass('hidden')
    })


})
jQuery(document).ajaxComplete(function (event, request, options) {
    if (request && 4 === request.readyState && 200 === request.status
        && options.data && 0 <= options.data.indexOf('action=add-tag')) {

        // clear color picker
        if (jQuery('.wp-picker-container').length) {
            jQuery('.wp-picker-container .wp-picker-clear').trigger('click')
        }


        // Clear Thumbnail fields on submit.
        jQuery('.ae-variation-swatches-image-preview').attr('src', AeVariationSwatchesObj.placeholder_img)
        jQuery('.variation-swatches-term-image').val('')
        jQuery('.variation-swatches-remove-image-btn').addClass('hidden')
    }
});