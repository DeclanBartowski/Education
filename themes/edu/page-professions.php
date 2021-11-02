<?get_header(); // вставка header.php
/*
Template Name: Профессии
*/
use \TQ\WP\Profession;
$subTitle = get_field('sub_title');

$arItems = Profession::getElements();
?>
    <div class="main block_professions" id="top">
        <div class="container">
            <p class="title title_1" id="title"><?=get_the_content()?></p>
            <?if($subTitle){?>
                <p class="text text_1"><?=$subTitle?></p>
            <?}?>
           <div class="row">
                <div class="col col-xl-3 remove_filter">
                    <div class="sidebar">
                        <?get_template_part('professions_filter')?>
                        <div class="to_top_wrap"><a href="#title" class="to_top button_1 bold">Наверх</a></div>
                    </div>
                </div>
                <div class="col col-12 col-md-1 remove"></div>
                <div class="col col-12 col-lg-8">
                    <div class="head">
                        <div class="labels">
                            <div class="filter_result search_result desc_1">Найдено <span class="count"><?=declOfNum(count($arItems),['профессия','профессии','профессий'])?></span></div>
                        </div>
                        <div class="input_wrap search">
                            <input type="text" class="input_item caption_1" placeholder="Поиск">
                        </div>
                        <select name="sort" class="btn_sort caption_1 styled">
                            <option value="price_up">Стоимость от дешёвых к дорогим</option>
                            <option value="price_down">Стоимость от дорогих к дешёвым</option>
                        </select>
                    </div>
                    <div class="filter_content row tab_items searching_block">
                    <?get_template_part('professions_list')?>
                    </div>
                    <div class="filter_error searching_error">
                        <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                        <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
                    </div>
                </div>
            </div>
            <div class="scroll_top_wrap"><a href="#top" class="button_1 bold scroll_top">Наверх</a></div>
        </div>
    </div>
<?php
get_footer(); // footer.php