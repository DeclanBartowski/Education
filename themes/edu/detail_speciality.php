<?php
/**
 * @global $post
 */
use TQ\WP\Review,
    TQ\WP\Speciality;
$arFields = get_fields($post->ID);
$arCategories = get_the_terms($post->ID, 'typespecialties');
$isDpo = false;

if ($arCategories) {
    foreach ($arCategories as $term){
        if($term->slug == 'dpo'){
            $isDpo = true;
            break;
        }
        while ($term->parent) {
            $term = get_term($term->parent);
            if($term->slug == 'dpo'){
                $isDpo = true;
                break;
            }
        }
        if($isDpo)break;
    }
    $category = reset($arCategories);
    $arCategoryDiplomas = get_field('diplomas', $category);
}
$arEstablishmentsIds = [];
$arAdditionalInfo = Speciality::getAdditionalInfo($post);

if (isset($arAdditionalInfo['establishments']) && $arAdditionalInfo['establishments']) {
    foreach ($arAdditionalInfo['establishments'] as $establishment) {
        $arEstablishmentsIds[] = $establishment->ID;
    }
    $review = new Review();
    $arReviews = $review->getReviews($arEstablishmentsIds,-1);
}
if(isset($arReviews['total']) && $arReviews['total']){
    $reviewCount = $arReviews['total'];
}else{
    $reviewCount = 0;
}
if(!$isDpo){
    unset($arFields['type']);
}
?>
<?get_template_part('breadcrumbs', null, ['tax' => 'typespecialties']) ?>

<div class="block_direction">
    <section class="container">
        <div class="row">
            <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                <?if(isset($arFields['type'])){?>
                    <div class="education floating"<?if($arFields['background']){?> style="background-image: url(<?=$arFields['background']?>);"<?}else{?> style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/backgrounds/23.jpg);"<?}?>>
                        <div>
                            <div class="label desc_2"><?= $arFields['type'] ?></div>
                            <p class="title_2 title"><?the_title(); ?></p>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <div class="top">
                                </div>
                                <div class="bottom">
                                    <?if(isset($arAdditionalInfo['establishments']) && $arAdditionalInfo['establishments']){?>
                                    <a href="#education_choose" class="in_universities button_1 bold">в <?=declOfNum(count($arAdditionalInfo['establishments']),['учебном заведении','учебных заведениях','учебных заведениях'])?></a>
                                    <?}?>
                                    <?if($reviewCount){?>
                                        <a href="#reviews_block" class="reviews button_1 bold"><?=declOfNum($reviewCount,['отзыв','отзыва','отзывов'])?></a>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}else{?>
                    <div class="education floating">
                        <div class="top_block">
                            <?
                            if (isset($arFields['grade']) && $arFields['grade']) { ?>
                                <p><span class="desc_2 label"><?= $arFields['grade'] ?></span></p>
                                <?
                            } ?>
                            <p class="title_1"><?
                                the_title(); ?></p>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <div class="top">

                                    <ul class="list">
                                        <?
                                        if (isset($arFields['min_price']) && $arFields['min_price']) { ?>
                                            <li class="text_1">от <?= number_format($arFields['min_price'], '0', ',',
                                                    ' ') ?> ₽ семестр
                                            </li>
                                            <?
                                        } ?>
                                        <?
                                        if (isset($arFields['min_period']) && $arFields['min_period']) { ?>
                                            <li class="text_1">от <?= declOfNum($arFields['min_period'],
                                                    ['года', 'лет', 'лет']) ?></li>
                                            <?
                                        } ?>
                                        <?
                                        if (isset($arFields['after_text']) && $arFields['after_text']) { ?>
                                            <?
                                            foreach ($arFields['after_text'] as $arField) {if(!$arField['text'])continue; ?>
                                                <li class="text_1"><?= $arField['text'] ?></li>
                                                <?
                                            } ?>
                                            <?
                                        } ?>
                                    </ul>

                                </div>
                                <div class="bottom">
                                    <?if(isset($arAdditionalInfo['establishments']) && $arAdditionalInfo['establishments']){?>
                                    <a href="#education_choose" class="in_universities button_1 bold">в <?=declOfNum(count($arAdditionalInfo['establishments']),['вузе','вузах','вузах'])?></a>
                                    <?}?>
                                    <?if($reviewCount){?>
                                        <a href="#reviews_block" class="reviews button_1 bold"><?=declOfNum($reviewCount,['отзыв','отзыва','отзывов'])?></a>
                                    <?}?>
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
                <?}?>
                <div class="collapsed_text">
                    <p class="text_1"><?
                        the_content() ?></p>
                    <?
                    if (isset($arFields['hidden_text']) && $arFields['hidden_text']) { ?>
                        <p class="text_1 hidden_text" style="display: none;"><?= $arFields['hidden_text'] ?></p>
                        <p class="text_1 expand" data-expand="Развернуть" data-collapse="Свернуть">Развернуть</p>
                        <?
                    } ?>
                </div>
                <?
                if (isset($arFields['detail_info']) && $arFields['detail_info']) {
                    $arStatistic = array_chunk($arFields['detail_info'], ceil(count($arFields['detail_info']) / 2))
                    ?>
                    <div class="education_details">
                        <div class="row">
                            <?
                            foreach ($arStatistic as $arStaticBlock) { ?>
                                <div class="col col-12 col-sm-6">
                                    <?
                                    foreach ($arStaticBlock as $item) {
                                        switch ($item['type']) {
                                            case 'Минимальный срок':
                                                $item['value'] = sprintf('от %s',
                                                    declOfNum($arFields['min_period'], ['года', 'лет', 'лет']));
                                                break;
                                            case 'Минимальная цена':
                                                $item['value'] = sprintf('от %s ₽ семестр',
                                                    number_format($arFields['min_price'], '0', ',', ' '));
                                                break;
                                        } ?>
                                        <div class="block">
                                            <p class="text_1 bold title"><?= $item['name'] ?></p>
                                            <p class="text_1"><?= $item['value'] ?></p>
                                        </div>
                                        <?
                                    } ?>
                                </div>
                                <?
                            } ?>

                        </div>
                        <?
                        if (isset($arFields['text_after_detail']) && $arFields['text_after_detail']) { ?>
                            <p class="desc_1 comment"><?= $arFields['text_after_detail'] ?></p>
                            <?
                        } ?>
                    </div>
                    <?
                } ?>
                <?
                if (isset($arAdditionalInfo['establishments']) && $arAdditionalInfo['establishments']) { ?>
                    <div class="education_choose" id="education_choose">
                        <div class="head">
                            <p class="title_3 title">Выберите учебное <br>заведение</p>
                            <p class="desc_1 description">Отличаются сроками <br>и стоимостью</p>
                        </div>
                        <div class="tabs_wrap">

                            <div class="tab_items">
                                <div class="row tab_item tab_1 active">
                                    <?
                                    foreach ($arAdditionalInfo['establishments'] as $establishment) {
                                        $arSpecs = get_field('specs',$establishment->ID);
                                        $arSpec = array_filter($arSpecs,function ($arItem) use($post){
                                            return $arItem['item']->ID == $post->ID;
                                        });
                                        if($arSpec){
                                            $arSpec = reset($arSpec);
                                            $establishment->min_price = $arSpec['price'];
                                            $establishment->min_period = $arSpec['period'];
                                        }
                                        ?>
                                        <div class="item_wrap col col-12">
                                            <div class="lined">
                                                <div class="row aic">
                                                    <div class="col col-xl-2 col-sm-3 col-3">
                                                        <?
                                                        if ($establishment->picture) { ?>
                                                            <div class="image">
                                                                <img src="<?= $establishment->picture['url'] ?>"
                                                                     alt="<?= $establishment->picture['alt'] ?: $establishment->post_title ?>">
                                                            </div>
                                                            <?
                                                        } ?>
                                                    </div>
                                                    <div class="col col-xl-10 col-sm-9 col-9">
                                                        <div class="row aic">
                                                            <div class="col col-xl-7 col-md-7 col-12">
                                                                <div class="label"><span
                                                                        class="desc_2"><?= $establishment->advantages ?></span>
                                                                </div>
                                                                <a href="<?= get_permalink($establishment->ID) ?><?=$post->post_name?>"
                                                                   class="caption_3 bold searching_value"><?= $establishment->post_title ?></a>
                                                            </div>
                                                            <div class="col col-xl-5 col-md-5 col-12">
                                                                <ul class="info">

                                                                    <?
                                                                    if ($establishment->min_price) { ?>
                                                                        <li class="caption_1">
                                                                            от <?= number_format($establishment->min_price,
                                                                                '0', ',', ' ') ?> ₽ семестр
                                                                        </li>
                                                                        <?
                                                                    } ?>
                                                                    <?
                                                                    if ($establishment->min_period) { ?>
                                                                        <li class="caption_1">срок
                                                                            от <?= declOfNum($establishment->min_period,
                                                                                ['года', 'лет', 'лет']) ?></li>
                                                                        <?
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?
                } ?>
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
                <?
                if (!isset($arFields['type']) && isset($arAdditionalInfo['professions']) && $arAdditionalInfo['professions']) { ?>
                    <div class="education_professions" id="education_professions">
                        <p class="title_3 title">Профессии направления</p>
                        <div class="row tab_items">
                            <?
                            foreach ($arAdditionalInfo['professions'] as $profession) {
                                $arCatNames = [];
                                $arCategories = get_the_terms($profession->ID, 'prof_categories');
                                if ($arCategories) {
                                    foreach ($arCategories as $category) {
                                        $arCatNames[] = $category->name;
                                    }
                                }
                                $arProfessionFields = get_fields($profession->ID); ?>
                                <div class="item_wrap col col-12">
                                    <div class="lined">
                                        <div class="row aic">
                                            <div class="col col-xl-2 col-sm-3 col-3">
                                                <?
                                                if ($arProfessionFields['picture']) { ?>
                                                    <div class="image">
                                                        <img src="<?= $arProfessionFields['picture']['url'] ?>"
                                                             alt="<?= $arProfessionFields['picture']['alt'] ?: $profession->post_title ?>">
                                                    </div>
                                                    <?
                                                } ?>
                                            </div>
                                            <div class="col col-xl-10 col-sm-9 col-9">
                                                <div class="row aic">
                                                    <div class="col col-xl-7 col-md-7 col-12">
                                                        <?
                                                        if ($arCatNames) { ?>
                                                            <div class="label"><span class="desc_2"><?= implode(', ',
                                                                        $arCatNames) ?></span></div>
                                                            <?
                                                        } ?>
                                                        <a href="<?= get_permalink($profession->ID) ?>"
                                                           class="caption_3 bold searching_value"><?= $profession->post_title ?></a>
                                                    </div>
                                                    <div class="col col-xl-5 col-md-5 col-12">
                                                        <ul class="info">
                                                            <?
                                                            if ($arProfessionFields['wage']) { ?>
                                                                <li class="caption_1">
                                                                    от <?= number_format($arProfessionFields['wage'],
                                                                        '0', ',', ' ') ?> ₽ зарплата
                                                                </li>
                                                                <?
                                                            } ?>
                                                            <?
                                                            if (isset($profession->min_price) && $profession->min_price) { ?>
                                                                <li class="caption_1">
                                                                    от <?= number_format($profession->min_price, '0',
                                                                        ',', ' ') ?> ₽ семестр обучения
                                                                </li>
                                                                <?
                                                            } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                <?if(isset($arFields['type'])){?>
                    <?get_template_part('form_calculate_education') ?>
                <?}else{?>
                    <?get_template_part('form_pick_education') ?>
                <?}?>
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
<section class="block_questions">
    <div class="container">
        <?
        get_template_part('faq_block') ?>
        <?
        get_template_part('footer_question_block') ?>
    </div>
</section>