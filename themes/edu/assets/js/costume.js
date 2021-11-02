document.addEventListener('wpcf7mailsent', function (event) {
    switch (event.detail.contactFormId) {
        case 315:
            $('#315_form .active').removeClass('active');
            $('#315_form .wpcf7-response-output').hide();
            $('#315_form').append('<div class="block_wrap thanks active">\n' +
                '        <div class="result">\n' +
                '            <div class="title">\n' +
                '                <p class="text_2 mb_18">Спасибо за заявку!</p>\n' +
                '                <p class="text_1">' + event.detail.apiResponse.message + '</p>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>');
            break;
        case 410:
            $('.form_calculate_education  .wpcf7-response-output').hide();
            $('.form_calculate_education  .block_wrap.thanks').show();
            break;
        case 354:
            $('#found_course .wpcf7-response-output').hide();
            $.fancybox.close($('#get_consultation'));
            $.fancybox.open($('#get_consultation_success'));
            break;
        case 363:
            $('.file_list .close').click()
            break;
    }

}, false);
document.addEventListener('wpcf7beforesubmit', function (event) {
    if (event.detail.contactFormId == 363) {
        let documentFields = $('.hidden_files');
        if (documentFields) {
            let docs,
                fileInput,
                files;
            $.each(documentFields, function (index, value) {
                fileInput = $(this);

                if (fileInput.closest('.hide').length > 0) {
                    event.detail.formData.set(fileInput.attr('name'), '1')
                } else {
                    files = $('[name="' + fileInput.attr('name') + '_docs[]"]');
                    docs = [];
                    if (typeof files != "undefined" && files.length > 0) {
                        $.each(files, function (index, value) {
                            docs.push($(this).val().replace('/wp-content/', ''));
                        })
                    }
                    event.detail.formData.set(fileInput.attr('name'), docs.join('\n'))
                }

            })
        }
    }
}, false);

document.addEventListener('wpcf7submit', function (event) {
    if (event.detail.contactFormId == 363) {
    }
}, false);

$(document).on('beforeShow.fb', function( e, instance, slide ) {
    $('#establishment').val('');
    $('#speciality').val('');
    $('#profile').val('');
});
$(document).on('click','[data-action]',function () {
    let $this = $(this),
        action = $this.data('action');
    switch (action){
        case 'save_spec_est':
            $('#establishment').val($this.data('est'));
            $('#speciality').val($this.data('spec'));
            $('#profile').val($this.data('profile'));
            break;
    }

})
$(document).on('click', '.form_pick_education .wpcf7-list-item, .form_calculate_education .wpcf7-list-item', function () {
    $(this).find('input').prop('checked', true).change();
})
$(document).on('change', '.form_pick_education .wpcf7-list-item input, .form_calculate_education .wpcf7-list-item', function () {

    var $this = $(this);
    $this.closest('.block_radio').find('.selected').removeClass('selected');
    $this.closest('.wpcf7-list-item').addClass('selected');
    $this.closest('.block_wrap').find('button').addClass('next');
});
$(document).ready(function () {
    if (typeof EstablishmentsParams != 'undefined' && EstablishmentsParams) {
        let educationLevel = $('#education_level'),
            direction = $('#direction'),
            program = $('#program');
        educationLevel.select2('destroy');
        educationLevel.html('');
        $.each(EstablishmentsParams.levels, function (index, value) {
            educationLevel.append('<option value="' + value.name + '" data-id="' + value.id + '">' + value.name + '</option>');
        })
        educationLevel.select2();
        setValues('directions', educationLevel.find('option:selected').data('id'), direction)
        setValues('profiles', direction.find('option:selected').data('id'), program)
        educationLevel.on('change', function () {
            setValues('directions', $(this).find('option:selected').data('id'), direction)
            setValues('profiles', direction.find('option:selected').data('id'), program)
        })
        $(document).on('change', 'select#direction', function () {
            setValues('profiles', $(this).find('option:selected').data('id'), program)
        })

        function setValues(key, value, item) {

            item.select2('destroy');
            item.html('');
            $.each(EstablishmentsParams[key][value], function (index, value) {
                item.append('<option value="' + value.name + '" data-id="' + value.id + '">' + value.name + '</option>');
            })
            item.select2();

        }
    }
})
$(document).on('change','[name=specialty_type]',function () {
    $(this).closest('form').find('[name=specialty]').val($(this).val());
    $(this).closest('form').find('[name=specialty]').closest('.input_wrap').addClass('in_focus');
})