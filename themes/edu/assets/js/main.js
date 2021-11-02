(function ($) {

    $(document).ready(function () {
        //////// Форма образования ////////
        // выбор радио-кнопки
        $('.form_pick_education .radio_item').on('change', function () {
            var $this = $(this);

            $this.closest('.block_radio').find('.selected').removeClass('selected');
            $this.addClass('selected');

            $this.closest('.block_wrap').find('button').addClass('next');
        });

        // следующая вкладка формы
        $('.form_pick_education button').on('click', function (e) {

            var $button = $(this);
            var $parent = $button.closest('.block_wrap');
            var next = $parent.find('input[type=hidden]').val();
            if (next != 'finish') {
                $parent.removeClass('active');
                e.preventDefault();
                $parent.closest('.form_pick_education').find('.' + next).addClass('active');
            } /*else {
                // отправляем данные
                var $form = $parent.closest('form');
                var data = $form.serialize();
                // console.log(data);

                $.ajax({
                    url: 'forms.php',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        // console.log(data);
                        if (data['success']) {
                            var $parent = $button.closest('.block_wrap');
                            $parent.removeClass('active');
                            $form.find('.thanks').addClass('active');
                        } else {
                        }
                    }
                });
            }*/
        });

        $('.form_pick_education .input_item').on('blur', function () {
            var $this = $(this);
            var $parent = $this.closest('.block_wrap');
            var next = true;

            $('.input_item', $parent).each(function (index, el) {
                var val = $(this).val();
                if (!val) {
                    next = false;
                }
            });
            if (next == true) {
                $this.closest('.block_wrap').find('button').addClass('next');
            } else {
                $this.closest('.block_wrap').find('button').removeClass('next');
            }
        });

        $('.form_pick_education').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);

            // if ($form) {}
        });
        //////// ----------- ////////

        //////// Форма рассчета срока и длительности ////////
        // выбор радио-кнопки
        $('.form_calculate_education .radio_item').on('change', function () {
            var $this = $(this);

            $this.closest('.block_radio').find('.selected').removeClass('selected');
            $this.addClass('selected');

            $this.closest('.block_wrap').find('button').addClass('next');
        });

        // следующая вкладка формы
        $('.form_calculate_education button').on('click', function (e) {

            var $button = $(this);
            var $parent = $button.closest('.block_wrap');
            var next = $parent.find('input[type=hidden]').val();

            $parent.removeClass('active');
            if (next != 'finish') {
                e.preventDefault();
                $('.' + next, '.form_calculate_education').addClass('active');
            } else {
                // отправляем данные
                var $form = $parent.closest('form');
                var data = $form.serialize();
                // console.log(data);

                /*$.ajax({
                    url: 'forms.php',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        // console.log(data);
                        if (data['success']) {
                            var $parent = $button.closest('.block_wrap');
                            $parent.removeClass('active');
                            $form.find('.thanks').addClass('active');
                        } else {
                        }
                    }
                });*/
            }
        });

        $('.form_calculate_education .input_item').on('blur', function () {
            var $this = $(this);
            var $parent = $this.closest('.block_wrap');
            var next = true;

            $('.input_item', $parent).each(function (index, el) {
                var val = $(this).val();
                if (!val) {
                    next = false;
                }
            });
            if (next == true) {
                $this.closest('.block_wrap').find('button').addClass('next');
            } else {
                $this.closest('.block_wrap').find('button').removeClass('next');
            }
        });

        $('.form_calculate_education').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);

            // if ($form) {}
        });
        //////// ----------- ////////

        //////// Если input имеет метку, то она должна подниматься вверх при наличии в нем текста или фокусе ////////
        // $('.with_label').on('mouseover', function(e){
        $('.with_label').on('focus', function (e) {
            var $this = $(this),
                val = $this.val(),
                $wrap = $this.closest('.input_wrap');
            $wrap.addClass('in_focus');
        });

        $('.with_label').on('blur', function (e) {
            var $this = $(this),
                val = $this.val(),
                $wrap = $this.closest('.input_wrap');
            // console.log(!val)
            if (!val) {
                $wrap.removeClass('in_focus');
            }
        });

        $('.with_label').each(function (index, el) {
            var $this = $(this),
                val = $this.val(),
                $wrap = $this.closest('.input_wrap');
            if (val) {
                $wrap.addClass('in_focus');
            }
        });
        //////// ----------- ////////

        //////// Разное ////////
        // Если ширина главного меню превышает ширину контейнера, прятать все не влезающие пункты меню в подменю
        function create_nav() {
            if ($(window).width() <= 768) {
                return
            }
            var $main = $('#main_menu');
            var $nav = $('#navigation');
            var container_width = $nav.closest('.container').width();
            var $submenu = $('.has_submenu', $nav);
            var width = 0;

            // console.log('container: ', container_width);
            $main.show();
            $('.menu_item:not(.has_submenu)', $nav).remove();
            $('.menu_item', $main).each(function () {
                var $li = $(this);
                var padding = parseInt($li.css('padding-right'));
                // console.log('width:', width);
                // console.log($li.width(), '+', padding);
                // console.log($li);
                if (width + $li.width() + padding + $submenu.width() <= container_width) {
                    width += $li.width() + padding;
                    $submenu.hide();
                    $li.clone().appendTo($nav);
                } else {
                    width += $li.width() + padding;
                    $submenu.show();
                    $li.clone().appendTo($('.submenu', $submenu));
                }
            });
            $submenu.appendTo($nav);
            $main.hide();
        }

        create_nav();

        $(window).on('resize', function () {
            create_nav();
        });

        // открытие меню после скрола
        $('.menu_mobile').on('click', function (e) {
            e.preventDefault();
            var $body = $('body');
            var $header = $('header');

            if ($header.hasClass('scrolled') && $(window).width() > 768) {
                // if ($(window).width() <= 768) {
                // 	return
                // }
                $body.toggleClass('menu_scrolled_opened');
            } else {
                $body.toggleClass('menu_opened');
            }
        });

        // при прокрутке экрана чуток меняем шапку/футер
        $(window).on('scroll', function () {
            var $header = $('.header');
            var $bottom = $('.selection_wrap');
            var $body = $('body');
            if ($(this).scrollTop() > 100) {
                if (!$header.hasClass('scrolled')) {
                    $header.addClass('scrolled');
                    $bottom.addClass('scrolled');
                    $body.addClass('header_scrolled');
                }
            } else {
                $header.removeClass('scrolled');
                $bottom.removeClass('scrolled');
                $body.removeClass('header_scrolled');
            }
        });
        $(window).trigger('scroll');

        // маска для телефона // удалить событие 'mouseenter' ???
        $('input[type="tel"]').inputmask('+7 (999) 999-99-99', {
            "onincomplete": function (e) {
                // console.log(e);
                $(e.currentTarget).val('');
            }
        });

        // плавный переход на якорь
        $('a[href*="#"]').on('click', function (e) {
            var href = $(this).attr('href'),
                hash = href.substring(href.indexOf('#'));
            if ($(hash).length) {
                e.preventDefault();
                $('body, html').animate({
                    scrollTop: $(hash).offset().top,
                });

                // write code to hide menu here
            }
        });

        // Всплывашка с длительностью курса
        $('.info .popup').on('click', function (e) {
            e.stopPropagation();
            $('body').find('.popup.show').removeClass('show');
            $(this).toggleClass('show');
        });
        $('body').on('click', '.prompt_popup_close', function () {
            $('body').find('.popup.show').removeClass('show');
        });
        $('body').on('click', function () {
            $('body').find('.popup.show').removeClass('show');
        });
        $('body').on('click', '.prompt_popup', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });

        // спрятать/показать еще текст
        $('body').on('click', '.collapsed_text .expand', function () {
            var $this = $(this);
            var $parent = $this.closest('.collapsed_text');

            $('.hidden_text', $parent).slideDown(500);
            $this.removeClass('expand').addClass('collapse').text($this.data('collapse'));
        });
        $('body').on('click', '.collapsed_text .collapse', function () {
            var $this = $(this);
            var $parent = $this.closest('.collapsed_text');

            $('.hidden_text', $parent).slideUp(500);
            $this.removeClass('collapse').addClass('expand').text($this.data('expand'));
        });

        // показать еще вакансии
        $('.vacancy_other').on('click', function () {
            var $this = $(this);

            $this.parent().find('.hidden_vacancies').slideToggle();
            $this.hide(300);
        });

        // стилизированный селект-бокс
        if (typeof $.fn.styler == 'function') {
            $('.styled').styler({});
        }
        //////// ----------- ////////

        //////// Слайдеры ////////
        if (typeof $.fn.slick == 'function') {
            $('.partners_logos').slick({
                slidesToShow: 8,
                slidesToScroll: 1,
                centerMode: false,
                infinite: true,
                arrows: false,
                dots: false,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 1630,
                        settings: {
                            slidesToShow: 6,
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    // {
                    //   breakpoint: 720,
                    //   settings: {
                    //   	slidesToShow: 1,
                    //   	rows: 2,
                    //   	slidesPerRow: 2,
                    //   }
                    // },
                ]
            });

            $('.slider_reviews').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                centerMode: false,
                infinite: true,
                arrows: true,
                prevArrow: $('.slider_control .slider_control_left'),
                nextArrow: $('.slider_control .slider_control_right'),
                dots: true,
                appendDots: $('.slider_control .slider_control_dots'),
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                ]
            });

            $('.slider_article').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                arrows: true,
                dots: false,
                fade: true,
                adaptiveHeight: true,
                asNavFor: '.slider_article_nav',
            });
            $('.slider_article_nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                centerMode: false,
                infinite: true,
                arrows: false,
                dots: false,
                adaptiveHeight: true,
                asNavFor: '.slider_article',
                focusOnSelect: true,
                responsive: []
            });

            $('.slider_directions').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                centerMode: false,
                infinite: true,
                arrows: true,
                dots: false,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        }
                    },
                ]
            })
                .on('setPosition', function (event, slick) {
                    slick.$slides.css('height', slick.$slideTrack.height() + 'px');
                    $('.slider_directions .slick-cloned').css('height', slick.$slideTrack.height() + 'px');
                    // console.log(slick);
                    var currentSlide = $('.slider_directions').slick('slickCurrentSlide');
                    var $forms = $('#forms');
                    $forms.find('.check_chances').hide();
                    $forms.find('.check_chances[data-form="' + currentSlide + '"]').show();
                    // $forms.find('.check_chances').slideUp();
                    // $forms.find('.check_chances[data-form="'+currentSlide+'"]').slideDown();
                });
            $('.slider_directions .item_wrap').on('click', function () {
                var toSlide = $(this).data('slick-index');
                $('.slider_directions').slick('slickGoTo', toSlide, false);
                // console.log(toSlide);
            });
        }
        //////// ----------- ////////

        //////// Табы ////////
        $('.tab_title').on('click', function () {
            var $tab = $(this);
            var $tab_item = $tab.find('input[type=hidden]').val();
            var $parent = $tab.closest('.tabs');
            var $tab_items = $parent.closest('.tabs_wrap').find('.tab_items');

            $('.active', $parent).removeClass('active');
            $tab.addClass('active');

            if (!$parent.hasClass('disable_tabs')) {
                // $('.active', $tab_items).removeClass('active').hide(300);
                // $('.'+$tab_item, $tab_items).addClass('active').show(300);
                $('.active', $tab_items).removeClass('active').slideUp();
                $('.' + $tab_item, $tab_items).addClass('active').slideDown();
                // $('.active', $tab_items).removeClass('active').fadeIn(200);
                // $('.'+$tab_item, $tab_items).addClass('active').fadeOut(200);
            }
        });
        //////// ----------- ////////

        //////// Аккордеон ////////
        $('.faq .faq_title').on('click', function () {
            $(this).closest('.item').toggleClass('active').find('.faq_desc').slideToggle();
        });
        //////// ----------- ////////
        let ajax;
        //////// Быстрый поиск ////////
        if (typeof $.fn.autocomplete == 'function') {
            $('.search input').autocomplete({
                // serviceUrl: 'search.php',
                // delimiter: /(,|;)\s*/,
                minChars: 2,
                minLength: 0,
                maxHeight: 400,
                width: 300,
                zIndex: 9999,
                deferRequestBy: 300,
                // params: { country: 'Yes'},
                // onSelect: function(data, value){ },
                // lookup: ['January', 'February', 'March'],
                source: function (request, response) {

                    if ($(this).hasClass('no_autocomplete')) {
                        $.getJSON(window.wp_data.ajax_url, {filter: $('.search input').val()}, function (data) {
                            var suggestions = []; // массив для хранения результатов
                            // console.log(data);
                            $.each(data, function (key, val) {
                                suggestions.push(val); // добавляем все элементы
                            });
                            response(suggestions);
                        });
                    }
                },
                search: function (event, ui) {
                    var $this = $(this);
                    var $searching_block = $this.closest('.searching_block');
                    var searching_request = $this.val();
                    var count = 0;
                    var $parent = $(this).closest('.search');
                    var $searching_error = $this.closest('.tab_item').find('.searching_error');
                    var $found_course = $('#found_course');
                    var hide_not_found = $parent.hasClass('hide_not_found');
                    if ($this.data('action')) {
                        $searching_error.hide();
                        if (!!ajax) ajax.abort();
                        ajax = $.ajax({
                            url: window.wp_data.ajax_url,
                            type: 'POST',
                            dataType: 'html',
                            data: {
                                action: $this.data('action'),
                                term_id: $this.data('id'),
                                q: searching_request
                            },
                            beforeSend: function () {
                            },
                            complete: function () {
                            },
                            success: function (data) {
                                $this.closest('.tab_item').find('.tq_item').remove();
                                if (data === 'not_found') {
                                    $searching_error.show();
                                } else {
                                    $searching_error.before(data)
                                }
                            }
                        });

                    } else {


                        $searching_error.hide();
                        $found_course.hide();
                        if (hide_not_found) {
                            // $searching_block.find('.not_found').show();
                            $('#not_found').show();
                        }

                        $('.searching_value', $searching_block).each(function (index, el) {
                            var $this = $(this);
                            text = $this.text().toLowerCase();
                            if (text.includes(searching_request) || searching_request == '') {
                                $this.closest('.item_wrap').removeClass('hide');
                                count++;
                            } else {
                                $this.closest('.item_wrap').addClass('hide');
                            }
                        });

                        $('.search_result .count').text(count);

                        if (count <= 0) { // Если поиск ничего не нашел
                            $searching_error.show();

                            if ($searching_block.hasClass('found_course')) {
                                $found_course.show();
                            }

                            if (hide_not_found) {
                                // $searching_block.find('.not_found').hide();
                                $('#not_found').hide();
                            }
                        } else {
                            $this.closest('.item_wrap').find('.desc').text('Всего ' + count + ' программ');
                        }
                    }
                },
                select: function (event, ui) {
                    console.log(ui.item.url);
                    window.location = ui.item.url;
                },
            });
        }
        //////// ----------- ////////

        //////// Чекбоксы ////////
        $('.custom_checkbox').each(function () {
            var checkbox = $(this);
            checkbox.append('<span class="custom_checkbox_button"></span>');
            if (checkbox.find('input').is(':checked')) {
                checkbox.addClass('checked');
            }
            checkbox.on('change', function () {
                var input = $(this).find('input');
                input.closest('.custom_checkbox').toggleClass('checked', input.is(':checked'));
            });
        });
        //////// ----------- ////////

        //////// RangeSlider ////////
        if (typeof $.fn.ionRangeSlider == 'function') {
            $('.range_slider').each(function (index, el) {
                var $slider = $(this);
                $(el).ionRangeSlider({
                    hide_min_max: true,
                    hide_from_to: true,
                    onChange: function (data) {
                        var $parent = $slider.closest('label');
                        var type = $parent.find('input').data('val');
                        var value = '';
                        if (type == 'years') {
                            value = 'лет';
                        } else if (type == 'money') {
                            value = '₽';
                        }
                        $parent.find('.caption').html(data.from + ' ' + value + ' - ' + data.to + ' ' + value);
                    },
                    // onStart: function (data) {
                    // 	// Called right after range slider instance initialised
                    // 	console.log('input: ', data.input);        // jQuery-link to input
                    // 	console.log('slider: ', data.slider);       // jQuery-link to range sliders container
                    // 	console.log('min: ', data.min);          // MIN value
                    // 	console.log('max: ', data.max);          // MAX values
                    // 	console.log('from: ', data.from);         // FROM value
                    // 	console.log('from_percent: ', data.from_percent); // FROM value in percent
                    // 	console.log('from_value: ', data.from_value);   // FROM index in values array (if used)
                    // 	console.log('to: ', data.to);           // TO value
                    // 	console.log('to_percent: ', data.to_percent);   // TO value in percent
                    // 	console.log('to_value: ', data.to_value);     // TO index in values array (if used)
                    // 	console.log('min_pretty: ', data.min_pretty);   // MIN prettified (if used)
                    // 	console.log('max_pretty: ', data.max_pretty);   // MAX prettified (if used)
                    // 	console.log('from_pretty: ', data.from_pretty);  // FROM prettified (if used)
                    // 	console.log('to_pretty: ', data.to_pretty);    // TO prettified (if used)
                    // },
                });
            });
        }
        //////// ----------- ////////

        //////// select2 ////////
        if (typeof $.fn.select2 == 'function') {
            $('.select').select2();
        }
        //////// ----------- ////////


        //////// форма отправки документов ////////
        // Загрузка файлов
        var uploaders = new Array();
        initUploaders = function (uploaders) {
            $(".uploader").each(function () {
                var $el = $(this);
                var button = $el.find('.file_load').attr('id');

                var uploader = new plupload.Uploader({
                    browse_button: button, // this can be an id of a DOM element or the DOM element itself
                    url: window.wp_data.ajax_url+'?action=save_file',
                    autostart: true,

                    filters: {
                        max_file_size: '20mb',
                        prevent_duplicates: true,
                        mime_types: [
                            {title: "Image files", extensions: "jpg,gif,png"},
                        ]
                    },

                    init: {
                        FilesAdded: function (up, files) {
                            uploader.start();
                        },
                        UploadFile: function (up, file) {
                            setTimeout(function () {
                                var html = '',
                                name = $el.closest('.file').find('.hidden_files').attr('name');
                                html = '<li id="' + file.id + '"><img src="/wp-content/uploads/documents/' + file.name + '" alt=""><span class="close"></span></li>';
                                $el.closest('.file').find('.file_list').append(html);
                                $el.append('<input type="hidden" class="' + file.id + '" name="'+name+'_docs[]" value="/wp-content/uploads/documents/' + file.name + '">');
                                // console.log(uploader);
                            }, 500);
                        },
                        FilesRemoved: function (up, files) {
                            // console.log(files);
                        },
                    },
                });
                uploader.init();

                // $('body').on('click', '.file_list .close', function(){
                // 	console.log(uploader);
                // 	// var uploader = window[ $(this).closest('.file').find('.uploader').attr('id') ];
                // 	var $li = $(this).closest('li');
                // 	var file = uploader.getFile( $li.attr('id') );
                // 	// console.log(file);
                // 	uploader.removeFile( file );
                // 	$li.remove();
                // });

                uploaders.push(uploader);
            });
        }
        initUploaders(uploaders);

        // удаление картинки
        $('body').on('click', '.file_list .close', function () {
            var $this = $(this);
            var $el = $this.closest('.file').find('.uploader');
            var uploader = uploaders[$el.attr('data-id')];
            // console.log(uploader);
            var $li = $this.closest('li');
            var file = uploader.getFile($li.attr('id'));
            // console.log(file);
            uploader.removeFile(file);
            $li.remove();
            $el.find('.' + $li.attr("id")).remove();
        });

        // чекбокс
        $('.submitDocuments .custom_checkbox').on('change', function () {
            $(this).closest('.file').find('.hidding_block').toggleClass('hide');
        });

        // отправка формы
        /*$('.submitDocuments').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serialize();
            // console.log(data);

            $.ajax({
                url: 'forms.php',
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        $form.hide();
                        $form.parent().append('<p class="caption_4">' + data['message'] + '</p>');
                    } else {
                    }
                }
            });
        });*/
        //////// ----------- ////////

        //////// фильтр специальностей ////////
        // удалить метку
        $('.labels').on('click', '.filter_label', function () {
            var $label = $(this);
            var name = $label.data('name');
            var value = $label.data('value');
            var $form = $label.closest('.tab_item').find('.filter');

            // console.log(name, value);
            $label.remove();
            $('input[name=' + name + ']', $form).trigger('click');
        });

        // клик по фильтру
        $('.filter input').on('change', function () {

            var $input = $(this);
            var $tab = $input.closest('.tab_item');
            var name = $input.attr('name');
            var label = $input.closest('label').find('span').text();
            if ($input.prop('checked')) {
                $('.labels', $tab).prepend('<div class="filter_label" data-name="' + name + '"><p class="caption_1">' + label + '</p><div class="btn_remove"></div></div>')
            } else {
                $('.labels', $tab).find('[data-name="' + name + '"]').remove();
            }

            if (!$('body').hasClass('show_filter')) {
                $('.filter', $tab).trigger('submit');
            }
        });

        // отправка формы
        $('.filter').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $tab = $form.closest('.tab_item');
            var data = $form.serializeArray();
            var $filter_error = $('.filter_error', $tab);

            $filter_error.hide();
            $('.button_filter .count', $tab).text(data.length - 1);
            console.log(data)
            $('body').removeClass('show_filter');
            // console.log(data);
            if (!!ajax) ajax.abort();
            ajax = $.ajax({
                url: window.wp_data.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    
                    if (data['success']) {
                        $('.labels .count', $tab).text(data['count']);
                        $('.filter_content', $tab).html(data['html'])
                    } else {
                        $('.labels .count', $tab).text(data['count']);
                        $filter_error.show();
                        //$('.filter_content', $tab).hide();
                        $('.filter_content', $tab).html(data['html']);
                    }
                }
            });
        });

        // мобилка: показать фильтр
        $('.button_filter').on('click', function () {
            $('body').toggleClass('show_filter');
        });

        // мобилка: свернуть/показать групу
        $('html').on('click', '.show_filter .filter .caption', function () {
            $(this).toggleClass('hide_group').next('.group').slideToggle();
        });

        // мобилка: очистить фильтр
        $('html').on('click', '.show_filter .filter .clear', function () {
            $(this).closest('.filter').find('input[type=checkbox]').prop('checked', false).closest('label').removeClass('checked');
            $('.labels .filter_label').remove();
            $('.range_slider').each(function () {
                var $this = $(this)
                $this.data('ionRangeSlider').reset();
                var $caption = $this.closest('label').find('.caption');
                $caption.text($caption.data('base'));
            });
        });

        // мобилка: закрыть фильтр
        $('html').on('click', '.show_filter .filter .close_filter', function () {
            $('body').toggleClass('show_filter');
        });
        //////// ----------- ////////

        //////// фильтр профессий ////////
        // клик по фильтру
        $('.filter_profession input').on('change', function () {
            $('.filter_profession').trigger('submit');
        });

        // отправка формы
        $(document).on('submit','.filter_profession', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();
            var $filter_error = $('.filter_error');

            $filter_error.hide();
            $('.button_filter .count').text(data.length - 1);

            let formData = new FormData($form.get(0));
            formData.append('action','filter_prof')
            // console.log(data);
            if(!!ajax)ajax.abort();
           ajax = $.ajax({
                url: window.wp_data.ajax_url,
                type: 'POST',
                dataType: 'json',
                //data: data,
                data: formData,
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false

                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        $('.labels .count').text(data['count']);
                        $('.filter_content').html(data['html']).show();
                        $('[name=sort]').change()
                    } else {
                        $('.labels .count').text(data['count']);
                        $filter_error.show();
                        $('.filter_content').hide();
                    }
                }
            })
        });

        // показать еще фильтры
        $('.filter_profession .btn_more').on('click', function () {
            var $this = $(this);
            var $parent = $this.closest('.group');

            $parent.find('.hidden_items').slideToggle();
            if ($this.hasClass('show_items')) {
                $this.removeClass('show_items').addClass('hide_items').find('.text').text($this.data('hide'));
            } else {
                $this.removeClass('hide_items').addClass('show_items').find('.text').text($this.data('show'));
            }
        });
        //////// ----------- ////////

        //////// сортировка профессий ////////
        // поиск data-aттрибута
        function find_data($items, data) {
            var items_list = [];
            var i = 0;
            $items.find('.item_wrap').each(function () {
                var $this = $(this);
                items_list[i] = {};
                items_list[i]['index'] = $this.data('index');
                items_list[i++]['value'] = $this.data(data);
                // items_list[$this.data('index')] = $this.data(data);
            });
            return items_list;
        }

        // сортировка массива с индексами и значениями
        function sorting(myarray, direction) {
            if (direction == 'up') {
                myarray.sort(function (a, b) {
                    return b.value - a.value;
                });
            } else {
                myarray.sort(function (a, b) {
                    return a.value - b.value;
                });
            }
        }

        // клик по кнопке сортировки
        $('select.btn_sort').on('change', function () {
            var $select = $(this);
            var $items = $('.filter_content');
            var items_list = [];

            switch ($select.val()) {
                case 'price_up':
                    items_list = find_data($items, 'price');
                    sorting(items_list, 'down');
                    break;
                case 'price_down':
                    items_list = find_data($items, 'price');
                    sorting(items_list, 'up');
                    break;
                default:
                    break;
            }
            // console.log(items_list);

            $.each(items_list, function (index, value) {
                $items.append($items.find('.item_wrap[data-index=' + value['index'] + ']'));
            });
        });
        //////// ----------- ////////

        //////// Форма консультации ////////
        /*$('#get_consultation').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            $.ajax({
                url: 'consultation.php',
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        $.fancybox.close($('#get_consultation'));
                        $.fancybox.open($('#get_consultation_success'));
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        });*/

        $('#get_consultation_success').fancybox({});

        $('#get_consultation_success .button').on('click', function (e) {
            e.preventDefault();
            $.fancybox.close($('#get_consultation_success'));
        });
        //////// ----------- ////////

        //////// Форма поиска после неудачного поиска ////////
        $('#found_course').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serializeArray();

            $.ajax({
                url: 'consultation.php',
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        // $.fancybox.close($('#get_consultation'));
                        $.fancybox.open($('#get_consultation_success'));
                    } else {
                        alert('Ошибка!');
                    }
                }
            });
        });
        //////// ----------- ////////

        //////// Показать еще (дополнительные поля в блоке с образованием) ////////
        $('.education_descriptions .show_more').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var $parent = $this.closest('.education_descriptions');

            $parent.find('.hidden_items').slideToggle();
            $this.toggleClass('slided');
        });

        //////// ----------- ////////

        function tolowcase(element) {
            var str = element.value;
            var res = str.toLowerCase();
            element.value = res;
        }

        function toupercase(element) {
            var str = element.value;
            var res = str.toUpperCase();
            element.value = res;
        }

        //////// страница отзывы ////////
        // поиск
        $('.filter_search input').on('keyup', function () {
            var $this = $(this);
            var search = $this.val().toLowerCase();
            var $parent = $this.closest('.filter_reviews');
            var $univers = $parent.find('.filter_reviews_universities');

            $('#filter_none').hide();

            if (search == '') {
                $univers.find('.university_item').show();
            } else {
                $univers.find('.university_item').not('[data-searching*="' + search + '"]').hide();
                var length = $univers.find('.university_item[data-searching*="' + search + '"]').show().length;
                if (length == 0) {
                    $('#filter_none').show();
                }
            }
        });

        // клик по учебному заведению
        $('.university_item').on('change', function () {
            var $this = $(this);
            var $parent = $this.closest('.filter_reviews_universities');
            var value = $this.val();

            $parent.find('.selected').removeClass('selected');
            $this.toggleClass('selected');
            $parent.closest('.filter_reviews').addClass('select_item');

            if (!$parent.hasClass('form')) {
                // ?
            }
        });

        // клик по хрестику на учебном заведении
        $('.filter_reviews .remove').on('click', function () {
            var $this = $(this);
            var $parent = $this.closest('.university_item');
            var $items = $parent.find('.filter_content');

            $this.removeClass('selected');
        });

        // поиск data-aттрибута
        function find_data2($items, data) {
            var items_list = [];
            var i = 0;
            $items.find('.review_item').each(function () {
                var $this = $(this);
                items_list[i] = {};
                items_list[i]['index'] = $this.data('index');
                items_list[i++]['value'] = $this.data(data);
                // items_list[$this.data('index')] = $this.data(data);
            });
            return items_list;
        }

        // сортировать отзывы
        $('.filter_reviews select.btn_sort').on('change', function () {
            var $select = $(this);
            var $parent = $select.closest('.filter_reviews');
            var $items = $parent.find('.filter_content');
            var $pagination = $parent.find('.pagination');
            var items_list = [];

            switch ($select.val()) {
                case 'up':
                    items_list = find_data2($items, 'date');
                    sorting(items_list, 'down');
                    break;
                case 'down':
                    items_list = find_data2($items, 'date');
                    sorting(items_list, 'up');
                    break;
                default:
                    break;
            }
            // console.log(items_list);

            $.each(items_list, function (index, value) {
                $items.append($items.find('.review_item[data-index=' + value['index'] + ']'));
            });
            $items.append($pagination);
        });

        // открыть окно для выбора учебного заведения
        $('.filter_reviews .show_filter').on('click', function (e) {
            e.preventDefault();
            $('#filter_mobile').addClass('show');
        });

        // закрыть окно для выбора учебного заведения
        $('.filter_mobile .close').on('click', function () {
            $(this).closest('.filter_mobile').removeClass('show');
        });

        // очистить окно для выбора учебного заведения
        $('.filter_mobile .erase').on('click', function () {
            var $parent = $(this).closest('.filter_mobile');
            $parent.find('.selected').removeClass('selected');
        });

        // отправить окно для выбора учебного заведения
        /*$('.filter_mobile .filter_reviews_universities').on('submit', function(e){
            e.preventDefault();
            var $form = $(this);
            var data = $form.serialize();
            // console.log(data);

            // отправка ajax
            $('#filter_mobile').removeClass('show');
        });*/
        //////// ----------- ////////

        //////// добавить отзыв ////////
        // добавить ссылку на соцсеть
        $('.leave_review .add_social').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);

            if ($this.hasClass('add')) {
                $this.removeClass('add').addClass('remove').text($this.data('remove')).closest('.social_item').find('.input_wrap').slideToggle();
            } else {
                $this.removeClass('remove').addClass('add').text($this.data('add')).closest('.social_item').find('.input_wrap').slideToggle();
            }
        });

        // оставить отзыв
        $('.leave_review').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serialize();
            // console.log(data);

            $('.error_message', $form).hide();
            $('.error', $form).removeClass('error');

            $.ajax({
                url: window.wp_data.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        $.fancybox.open($('#leave_review_success'));
                        $('.leave_review').trigger('reset')
                    } else {
                        $.each(data['error'], function (index, value) {
                            $('[name="' + value + '"]').closest('.input_wrap').addClass('error').find('.error_message').show();
                        });
                    }
                }
            });
        });
        //////// ----------- ////////

        //////// форма проверки шанса на вступление ////////
        $('.check_chances').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var data = $form.serialize();
            // console.log(data);

            $('.error_message_wrap', $form).hide();

            if ($form.find('.incorrect').length != 0) {
                return
            }

            $.ajax({
                url: window.wp_data.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: function () {
                },
                complete: function () {
                },
                success: function (data) {
                    // console.log(data);
                    if (data['success']) {
                        location.href = data['url']
                        // $.fancybox.open($('#leave_review_success'));
                    } else {
                        /*if (data['error'] == 'empty') {
                            $('.error_message_wrap', $form).show();
                        }*/
                        $('.error_message_wrap', $form).find('.error').html(data['error']);
                        $('.error_message_wrap', $form).show();
                    }
                }
            });
        });

        // валидация инпута
        $('.check_chances .form_item').on('blur', function () {
            var $this = $(this);
            var value = $this.val();
            value = value.replace(/,/i, '.');
            var $form = $this.closest('.check_chances');
            var $clear = $form.find('.clear_form');

            $this.removeClass('correct').removeClass('incorrect');
            $('.error_message_wrap', $form).hide();

            if (value === '') {
                return
            }
            if ($.isNumeric(value)) {
                $this.addClass('correct');
                $clear.show();
            } else {
                $this.addClass('incorrect');
                $clear.show();
            }
        });

        // очистить форму
        $('.check_chances .clear').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            $this.closest('.check_chances').find('.form_item').removeClass('correct').removeClass('incorrect').val('');
            $this.closest('.clear_form').hide();
        });
        //////// ----------- ////////


        $('.ajaxForm').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            $('.responce-text', $form).html('').removeClass('with-text');
            $('.form-group', $form).removeClass('is-invalid');
            $.ajax({
                url: 'sendEmail.php',
                type: 'POST',
                dataType: 'json',
                data: $form.serializeArray(),
                beforeSend: function () {
                    $('button[type="submit"]', $form).prop('disabled', true);
                },
                complete: function () {
                    $('button[type="submit"]', $form).prop('disabled', false);
                },
                success: function (data) {
                    console.log(data);
                    if (data.success) {
                        $.fancybox.open('Спасибо за заявку!')

                    } else {
                        if (data.errors && data.errors) {
                            for (var e in data.errors) {
                                console.log(e);
                                $('[name="' + e + '"]', $form).closest('.form-group').addClass('is-invalid');
                            }
                            if (data.message) {
                                $('.responce-text', $form).html(data.message).addClass('with-text');
                            }
                        } else {
                            $.fancybox.open(data.message)
                        }
                    }
                }
            })


        })

        $('.open-modal').fancybox();

        // jQuery Animated Number Counter From Zero To Value
        function AnimateCyfer($win, $animated_cyfer) {
            $animated_cyfer.each(function () {
                var $cur_cyfer = $(this);
                if (
                    ($win.scrollTop() + $win.height() >= $cur_cyfer.offset().top + $cur_cyfer.height())
                    &&
                    ($win.scrollTop() <= $cur_cyfer.offset().top + $cur_cyfer.outerHeight() - $cur_cyfer.height())
                ) {
                    if ($cur_cyfer.hasClass('animation')) {
                        $cur_cyfer.prop('Counter', 0).animate({
                            Counter: $cur_cyfer.data('value')
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function (now) {
                                $cur_cyfer.text(Math.ceil(now));
                            },
                            start: function () {
                                $cur_cyfer.removeClass('animation');
                            },
                            complete: function () {
                                // console.log($cur_cyfer);
                            },
                        });
                    }
                }
            });
        }

        $(window).on("load", function () {
            var $win = $(this);

            // анимируем цифры от нуля до текущего значения
            AnimateCyfer($win, $('.count'));
        });

    });

    function initSlider(sellector, params, breakpoint) {
        var $slider = $(sellector),
            width = $(window).width();

        if (width <= breakpoint) {
            if (!$slider.hasClass('slick-initialized')) {
                $slider.slick(params)
            }
        } else {
            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('unslick')
            }
        }


    }
})(jQuery)
