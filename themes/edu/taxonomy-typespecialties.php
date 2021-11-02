<?
/**
 * @var $post
 */
/*
Template Name: Список специальностей
*/

use TQ\WP\PostTypeHelper;
use TQ\WP\Speciality;
use TQ\WP\Review;
get_header(); // вставка header.php

$category = get_queried_object();
if($category->parent!=0){
    $arFields = get_fields($category);
    $arCategoryDiplomas = $arFields['diplomas'];
    $arItems = Speciality::getItemsByType($category->term_id);
    $arSpecs = [];
    $arCurSpecs = [];
    foreach ($arItems['tabs'] as $arTabs){
        foreach ($arTabs as $item)
        $arCurSpecs[] = $item->ID;
    }
    $arEstablishmentsIds = [];
    $arEstablishment = PostTypeHelper::getElements('establishments', ['post_title' => 'asc'],[
        'meta_query' => [
            'relation' => 'OR',
            [
                'key' => 'specs',
                //'value' => $speciality->ID,
                'compare' => 'EXISTS'
            ],
        ]
    ]);
    if($arEstablishment){
        foreach ($arEstablishment as $item){

            $arSpecs = get_field('specs',$item->ID);
            if($arSpecs){
                foreach ($arSpecs as $arSpec){
                    if( in_array($arSpec['item']->ID,$arCurSpecs)){
                        $arEstablishmentsIds[] = $item->ID;
                        break;
                    }
                }
            }

        }
    }
    $review = new Review();
    $arReviews = $review->getReviews($arEstablishmentsIds,-1);

    if(isset($arReviews['total']) && $arReviews['total']){
        $reviewCount = $arReviews['total'];
    }else{
        $reviewCount = 0;
    }
?>
    <?get_template_part('breadcrumbs', null, ['tax' => 'typespecialties','post'=>$category]) ?>

    <div class="block_direction">
        <section class="container">
            <div class="row">
                <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating">
                        <div>
                            <?if(isset($arFields['grade']) && $arFields['grade']){?>
                            <div class="heading">
                                <div class="label desc_2"><?=$arFields['grade']?></div>
                            </div>
                            <?}?>
                            <p class="title_1 title"><?=$category->name?></p>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <div class="top">
                                    <ul class="list">
                                        <?
                                        if (isset($arFields['min_price']) && $arFields['min_price']) { ?>
                                            <li class="text_1">от <?= number_format($arFields['min_price'], '0', ',',
                                                    ' ') ?> ₽ за человека
                                            </li>
                                            <?
                                        } ?>
                                        <?
                                        if (isset($arFields['min_period']) && $arFields['min_period']) { ?>
                                            <li class="text_1">от <?= declOfNum($arFields['min_period'],
                                                    ['часа', 'часов', 'часов']) ?></li>
                                            <?
                                        } ?>
                                        <?
                                        if (isset($arFields['after_text']) && $arFields['after_text']) { ?>
                                            <?
                                            foreach ($arFields['after_text'] as $arField) { ?>
                                                <li class="text_1"><?= $arField['text'] ?></li>
                                                <?
                                            } ?>
                                            <?
                                        } ?>
                                    </ul>
                                </div>
                                <div class="bottom">
                                    <a href="javascript:;" class="in_universities button_1 bold">в <?=declOfNum(count($arEstablishmentsIds),['учебном заведении','учебных заведениях','учебных заведениях'])?></a>
                                    <a href="javascript:;" class="reviews button_1 bold"><?=declOfNum($reviewCount,['отзыв','отзыва','отзывов'])?></a>
                                </div>
                            </div>
                            <?
                            if (isset($arFields['picture']) && $arFields['picture']) { ?>
                                <div class="right_side col-auto">
                                    <div class="image"><img src="<?= $arFields['picture']['url'] ?>"
                                                            alt="<?= $arFields['picture']['alt'] ?: $post->post_title ?>">
                                    </div>
                                </div>
                                <?
                            } ?>
                        </div>
                    </div>

                    <div class="collapsed_text">
                        <?if($category->description){?>
                        <p class="text_1"><?=$category->description?></p>
                        <?}?>
                        <?if(isset($arFields['hidden_text']) && $arFields['hidden_text']){?>
                        <p class="text_1 hidden_text" style="display: none;"><?=$arFields['hidden_text']?></p>
                        <p class="text_1 expand" data-expand="Развернуть" data-collapse="Свернуть">Развернуть</p>
                        <?}?>
                    </div>
                    <?if(isset($arItems) && $arItems){?>
                    <div class="education_programs section" id="education_programs">
                        <p class="title_3 title"><?=declOfNum($arItems['cnt'],['программа','программы','программ'])?> онлайн обучения</p>
                        <div class="tabs_wrap">
                            <div class="tabs">
                                <?$count = 0;
                                foreach ($arItems['tabs'] as $name=> $arTab ){?>
                                <div class="tab_title<?=$count == 0?' active':''?>">
                                    <span class="caption_5"><?=$name?><sup class="caption_1"><?=count($arTab)?></sup></span>
                                    <input type="hidden" name="tab" value="tab_<?=$count?>">
                                </div>
                                <?$count++;
                                }?>
                            </div>
                            <div class="tab_items fixed_height styled_scrollbar">
                                <?$count = 0;
                                foreach ($arItems['tabs'] as $name=> $arTab ){?>
                                <div class="row tab_item tab_<?=$count?><?=$count == 0?' active':''?> searching_block found_course" <?=$count != 0?' style="display: none;"':''?>>
                                    <div class="item_wrap col col-12 with_search">
                                        <div class="lined">
                                            <div class="row aic">
                                                <div class="col col-12 col-md-6">
                                                    <div class="input_wrap search hide_not_found">
                                                        <input type="text" class="input_item no_autocomplete caption_1" placeholder="Поиск по программам">
                                                    </div>
                                                </div>
                                                <div class="col col-12 col-md-6">
                                                    <p class="desc_1 desc">Всего <?=declOfNum(count($arTab),['программа','программы','программ'])?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    foreach ($arTab as $item){?>
                                    <div class="item_wrap col col-12">
                                        <div class="lined">
                                            <div class="row_wrap">
                                                <a href="<?=get_permalink($item->ID)?>" class="text_1 bold searching_value"><?=$item->post_title?></a>
                                                <div class="info_wrap">
                                                    <ul class="info">
                                                        <?if($item->min_price){?>
                                                        <li class="caption_1">от <?=number_format($item->min_price,'0',',',' ')?> ₽ семестр</li>
                                                        <?}?>
                                                        <?if($item->min_period){?>
                                                        <li class="caption_1">от <?=declOfNum($item->min_period,['часа','часов','часов'])?></li>
                                                        <?}?>
                                                    </ul>
                                                    <a data-fancybox data-src="#get_consultation" href="javascript:;" class="link">
														<span class="points">
															<span class="point"></span>
															<span class="point"></span>
															<span class="point"></span>
														</span>
                                                        <span class="item_text button_1 bold">заявка</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?}?>
                                </div>
                                <?
                                    $count++;}?>
                            </div>
                            <?=do_shortcode('[contact-form-7 id="409" html_id="found_course" title="Не нашли программу?"]')?>
                            <div class="not_found" id="not_found">
                                <p class="title_3 not_found_title">Не нашли программу?</p>
                                <p class="caption_2 not_found_desc">Напишите нам об этом — возможно информация еще не занесена</p>
                                <a data-fancybox data-src="#get_consultation" href="javascript:;" class="button_black button_2">Сделать запрос</a>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <?
                    if (isset($arCategoryDiplomas) && $arCategoryDiplomas) { ?>
                        <div class="education_diploms" id="education_diploms">

                            <p class="title_3 title"><?= $arCategoryDiplomas['title'] ?: 'В конце вы получите диплом гособразца' ?></p>
                            <p class="text_1 text"><?= $arCategoryDiplomas['text'] ?: 'Все наши учебные заведения-партнёры имеют госаккредитацию, а дипломы заносятся в федеральный реестр.' ?></p>

                            <div class="row">
                                <?
                                if ($arCategoryDiplomas['picture']) { ?>
                                    <div class="col col-12 col-md-6">
                                        <div class="image">
                                            <a href="<?= $arCategoryDiplomas['picture']['url'] ?>"
                                               data-fancybox="images"><img
                                                        src="<?= $arCategoryDiplomas['picture']['url'] ?>"
                                                        alt="<?= $arCategoryDiplomas['picture']['alt'] ?>"></a>
                                        </div>
                                    </div>
                                    <?
                                } ?>
                                <?
                                if ($arCategoryDiplomas['second_picture']) { ?>
                                    <div class="col col-12 col-md-6">
                                        <div class="image">
                                            <a href="<?= $arCategoryDiplomas['second_picture']['url'] ?>"
                                               data-fancybox="images"><img
                                                        src="<?= $arCategoryDiplomas['second_picture']['url'] ?>"
                                                        alt="<?= $arCategoryDiplomas['second_picture']['alt'] ?>"></a>
                                        </div>
                                    </div>
                                    <?
                                } ?>
                            </div>
                        </div>
                        <?
                    } ?>
                </div>
                <div class="form item col col-12 col-xl-4 col-lg-5 col-md-12 tq_sticky_form">
                    <?get_template_part('form_calculate_education') ?>
                </div>
            </div>
        </section>
    </div>
    <?
    if ($arEstablishmentsIds){
        get_template_part('reviews_block', null, ['ids' => $arEstablishmentsIds]);
    }?>
    <?
    get_template_part('scheme_block') ?>
    <?php
}else{
$specialityPage = get_post(SPECIALITY_PAGE);
$speciality = new Speciality();
$arSpecialities = $speciality->getMainSpecialities(false,true);
if($arSpecialities['items']){
if(!isset($category->taxonomy)){
    $category = reset($arSpecialities['items']);
}
if($category->slug == 'dpo'){
    $arItems = get_terms([
        'taxonomy' => 'typespecialties',
        'hide_empty' => true,
        'pad_counts' => true,
        'count' => false,
        'parent' => $category->term_id,
        'hierarchical' => true,
    ]);
} else{
    $arItems = Speciality::getElements(['current_term'=>$category->term_id]);
    if($category->slug != 'dpo' && $arItems){
        $arFilterParams = Speciality::getFilterParams($arItems);
    }
}

$h1 = get_field('h1',$category);
$description = get_field('sub_title',$category);
?>
    <div class="main block_directions_2" id="top">
        <div class="container">
            <p class="title title_1" id="title"><?=$h1?:$specialityPage->post_title?></p>
            <?if($description || $specialityPage->post_content){?>
                <p class="text text_1"><?=$description?:$specialityPage->post_content?></p>
            <?}?>
            <div class="tabs_wrap">
                <div class="tabs">
                    <?foreach ($arSpecialities['items'] as $key=> $speciality){?>
                        <a href="<?=get_term_link(intval($speciality->term_id),'typespecialties')?>" class="tab_title<?=$category->term_id == $speciality->term_id?' active':''?>">
                            <span class="caption_5"><?=$speciality->name?><sup class="caption_1"><?=$speciality->count?></sup></span>
                        </a>
                    <?}?>
                </div>
                <div class="tab_items">
                    <?if($category->slug == 'dpo'){?>
                        <div class="row tab_item tab_3 searching_block active">
                            <div class="item_wrap col col-12 with_search">
                                <div class="lined">
                                    <div class="input_wrap search">
                                        <input type="text"
                                               data-action="search_spec"
                                               data-id="<?=$category->term_id?>"
                                               class="input_item caption_1"
                                               placeholder="Поиск по направлениям">
                                    </div>
                                </div>
                            </div>
                            <?foreach ($arItems as $item){?>
                            <?get_template_part('direction_item',null,['type'=>$category->slug,'item'=>$item,'is_term'=>true])?>
                            <?}?>
                            <div class="searching_error col col-12">
                                <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                                <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
                            </div>
                        </div>
                    <?}else{
                        ?>
                        <div class="row tab_item tab_1 active">
                            <div class="col col-xl-3">
                                <noindex>
                                    <div class="sidebar">
                                        <div class="input_wrap search">
                                            <input type="text"
                                                   data-action="search_spec"
                                                   data-id="<?=$category->term_id?>"
                                                   class="input_item caption_1"
                                                   placeholder="Поиск по направлениям">
                                        </div>
                                        <div class="button_filter">
                                            <p class="button_1 bold">фильтры</p>
                                            <p class="count button_1 bold">0</p>
                                        </div>
                                        <form action="#" class="filter">
                                            <input type="hidden" name="current_term" value="<?=$category->term_id?>">
                                            <div class="group_head line">
                                                <p class="title_1 title bold">Фильтр</p>
                                                <div class="labels">

                                                    <div class="filter_result search_result desc_1">Найдено <span class="count"><?=declOfNum(count($arItems),['направление','направления','направлений'])?></span></div>
                                                </div>
                                            </div>
                                            <div class="group_other line">
                                                <label class="custom_checkbox">
                                                    <span class="caption_2 bold">Онлайн-защита</span>
                                                    <input type="checkbox" value="Y" name="online_protection">
                                                </label>
                                                <label class="custom_checkbox">
                                                    <span class="caption_2 bold">Рассрочка</span>
                                                    <input type="checkbox" value="Y" name="installment">
                                                </label>
                                                <label class="custom_checkbox">
                                                    <span class="caption_2 bold">Можно перевестись</span>
                                                    <input type="checkbox" value="Y" name="transfer">
                                                </label>
                                            </div>
                                            <?if(isset($arFilterParams['terms']) && $arFilterParams['terms']){?>
                                            <div class="group_education line">
                                                <p class="caption caption_2 bold">Уровень образования</p>
                                                <div class="group">
                                                    <?foreach ($arFilterParams['terms'] as $term){?>
                                                    <label class="custom_checkbox_2">
                                                        <input type="checkbox" name="term_id[]" value="<?=$term->term_id?>">
                                                        <span class="caption_1"><?=$term->name?></span>
                                                    </label>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <?}?>
                                            <?if(isset($arFilterParams['themes']) && $arFilterParams['themes']){?>
                                            <div class="group_education line">
                                                <p class="caption caption_2 bold">Тематика направления</p>
                                                <div class="group">
                                                    <?foreach ($arFilterParams['themes'] as $theme){?>
                                                    <label class="custom_checkbox_2">
                                                        <input type="checkbox" name="theme[]" value="<?=$theme?>">
                                                        <span class="caption_1"><?=$theme?></span>
                                                    </label>
                                                    <?}?>
                                                </div>
                                            </div>
                                            <?}?>
                                            <?if(isset($arFilterParams['period']) && $arFilterParams['period']){?>
                                            <div class="group_length line">
                                                <p class="caption caption_2 bold">Длительность обучения</p>
                                                <label class="ionRange">
                                                    <p class="caption caption_1" data-base="<?=$arFilterParams['period']['min_formatted']?> — <?=$arFilterParams['period']['max_formatted']?>"><?=$arFilterParams['period']['min_formatted']?> — <?=$arFilterParams['period']['max_formatted']?></p>
                                                    <input type="text" class="range_slider" data-min="<?=$arFilterParams['period']['min']?>" data-max="<?=$arFilterParams['period']['max']?>" data-from="<?=$arFilterParams['period']['min']?>" data-to="<?=$arFilterParams['period']['max']?>" data-type="double" data-val='years' name="min_period">
                                                </label>
                                            </div>
                                            <?}?>
                                            <?if(isset($arFilterParams['prices']) && $arFilterParams['prices']){?>
                                            <div class="group_price line">
                                                <p class="caption caption_2 bold">Стоимость семестра *</p>
                                                <label class="ionRange">
                                                    <p class="caption caption_1" data-base="<?=$arFilterParams['prices']['min_formatted']?>  — <?=$arFilterParams['prices']['max_formatted']?>"><?=$arFilterParams['prices']['min_formatted']?>  — <?=$arFilterParams['prices']['max_formatted']?></p>
                                                    <input type="text" class="range_slider" data-min="<?=$arFilterParams['prices']['min']?>" data-max="<?=$arFilterParams['prices']['max']?>" data-from="<?=$arFilterParams['prices']['min']?>" data-to="<?=$arFilterParams['prices']['max']?>" data-type="double" data-val="money" name="min_price">
                                                </label>
                                                <p class="desc desc_1">* Семестр — это 6 месяцев, полугодие</p>
                                            </div>
                                            <?}?>
                                            <input type="hidden" name="action" value="filter_directions">
                                            <button class="button_black button_2 bold">Применить</button>
                                            <div class="clear_wrap">
                                                <div class="clear" id="clear">
                                                    <img src="<?=get_stylesheet_directory_uri()?>/assets/images/clear.svg" alt="">
                                                    <p class="button_1">сбросить</p>
                                                </div>
                                            </div>
                                            <div class="close_filter"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/clear.svg" alt=""></div>
                                        </form>
                                        <a href="#title" class="to_top button_1 bold">Наверх</a>
                                    </div>
                                </noindex>
                            </div>
                            <div class="col col-12 col-md-1 remove"></div>
                            <div class="col col-12 col-md-8">
                                <div class="labels">
                                    <div class="filter_result search_result desc_1">Найдено <span class="count"><?=declOfNum(count($arItems),['направление','направления','направлений'])?></span></div>
                                </div>
                                <div class="filter_content row tab_items searching_block">
                                    <?foreach ($arItems as $item){?>
                                        <?get_template_part('direction_item',null,['type'=>$category->slug,'item'=>$item,'list'=>true])?>
                                    <?}?>
                                    <div class="filter_error searching_error">
                                        <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                                        <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    }?>

                </div>
            </div>
            <div class="scroll_top_wrap"><a href="#top" class="button_1 bold scroll_top">Наверх</a></div>
        </div>
    </div>
<?}?>
<?}?>
<section class="block_questions">
    <div class="container">
            <?get_template_part('footer_question_block')?>
    </div>
</section>
<?php get_footer(); // footer.php ?>

