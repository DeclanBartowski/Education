<?
/**
 * @global $post
 */
use TQ\WP\Review;
get_header(); // вставка header.php

$arFields = get_fields();
$arCategories = get_the_terms($post->ID, 'typesestablishments');

if ($arCategories) {
    $category = reset($arCategories);
    $arCategoryDiplomas = get_field('diplomas', $category);
}


$review = new Review();
$arReviews = $review->getReviews($post->ID,-1);
if(isset($arReviews['total']) && $arReviews['total']){
    $reviewCount = $arReviews['total'];
}else{
    $reviewCount = 0;
}

?>
<?get_template_part('breadcrumbs')?>
    <div class="block_direction">
        <section class="container">
            <div class="row">
                <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating" style="background-image: url(<?=isset($arFields['background']) && $arFields['background']?$arFields['background']:sprintf('%s/assets/images/backgrounds/22.jpg',get_stylesheet_directory_uri())?>);">
                        <div>
                            <?if(isset($arFields['advantages']) && $arFields['advantages']){?>
                                <div class="label desc_2"><?=$arFields['advantages']?></div>
                            <?}?>

                            <p class="title_1 title"><?the_title()?></p>
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
                                    <?if(isset($arFields['specs']) && $arFields['specs']){?>
                                    <a href="javascript:;" class="in_universities button_1 bold"><?= declOfNum(count($arFields['specs']),['направление', 'направления', 'направлений']) ?></a>
                                    <?}?>
                                    <?if($reviewCount){?>
                                        <a href="javascript:;" class="reviews button_1 bold"><?=declOfNum($reviewCount,['отзыв','отзыва','отзывов'])?></a>
                                    <?}?>
                                </div>
                            </div>
                            <?if(isset($arFields['preview_picture']) && $arFields['preview_picture']){?>
                                <div class="right_side col-auto">
                                    <div class="round_image"><img src="<?=$arFields['preview_picture']['url']?>" alt="<?=$arFields['preview_picture']['alt']?:$post->post_title?>"></div>
                                </div>
                            <?}?>

                        </div>
                    </div>

                    <div class="collapsed_text">
                        <p class="text_1"><?the_content()?></p>
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

                    <?if(isset($arFields['specs']) && $arFields['specs']){?>
                    <div class="education_programs section" id="education_programs">
                        <p class="title_3 title"><?=declOfNum(count($arFields['specs']),['направление','направления','направлений'])?> онлайн обучения</p>
                        <div class="row tab_items searching_block">
                            <div class="item_wrap col col-12 with_search">
                                <div class="lined">
                                    <div class="row aic">
                                        <div class="col col-12 col-md-6">
                                            <div class="input_wrap search hide_not_found">
                                                <input type="text" class="input_item caption_1" placeholder="Поиск по программам">
                                            </div>
                                        </div>
                                        <div class="col col-12 col-md-6">
                                            <p class="desc_1 desc">Всего <?=declOfNum(count($arFields['specs']),['направление','направления','направлений'])?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?foreach ($arFields['specs'] as $spec){
                                $arSpecFields['picture'] = get_field('picture',$spec['item']->ID);
                                $arSpecFields['min_price'] = $spec['price']?: get_field('min_price',$spec['item']->ID);
                                $arSpecFields['min_period'] = $spec['period']?:get_field('min_period',$spec['item']->ID);?>
                            <div class="item_wrap col col-12">
                                <div class="lined">
                                    <div class="row aic">
                                        <div class="col col-3 col-sm-2 col-xl-2">
                                            <?if($arSpecFields['picture']){?>
                                            <div class="image"><img src="<?=$arSpecFields['picture']['url']?>" alt="<?=$arSpecFields['picture']['alt']?:$spec['item']->post_title?>"></div>
                                            <?}?>
                                        </div>
                                        <div class="col col-9 col-sm-10 col-xl-10">
                                            <div class="row aic">
                                                <div class="col col-12 col-lg-12 col-xl-5">
                                                    <a href="<?=$spec['item']->post_name?>/" class="caption_4 bold searching_value"><?=$spec['item']->post_title?></a>
                                                </div>
                                                <div class="col col-12 col-lg-12 col-xl-7">
                                                    <div class="row aic">
                                                        <div class="col col-12 col-sm-7 col-md-8 col-lg-7 col-xl-6">
                                                            <ul class="info">
                                                                <?if($arSpecFields['min_price']){?>
                                                                <li class="caption_1">от <?=number_format($arSpecFields['min_price'],'0',',',' ')?> ₽ семестр</li>
                                                                <?}?>
                                                                <li class="caption_1">от <?= declOfNum($arSpecFields['min_period'],['года', 'лет', 'лет']) ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col col-12 col-sm-5 col-md-4 col-lg-5 col-xl-6">
                                                            <a data-action="save_spec_est"
                                                               data-est="<?=$post->post_title?>"
                                                               data-spec="<?=$spec['item']->post_title?>"
                                                               data-fancybox
                                                               data-src="#get_consultation"
                                                               href="javascript:;" class="link">
																<span class="points">
																	<span class="point"></span>
																	<span class="point"></span>
																	<span class="point"></span>
																</span>
                                                                <span class="item_text button_1 bold">консультация</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                            <div class="searching_error col col-12">
                                <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                                <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
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
                    <?get_template_part('admission_documents',null,['arFields'=>$arFields]) ?>
                    <?get_template_part('establishment_licenses',null,['arFields'=>$arFields]) ?>
                </div>
                <div class="form item col col-12 col-xl-4 col-lg-5 col-md-12 tq_sticky_form">
                    <?get_template_part('form_pick_education') ?>
                </div>
            </div>
        </section>
    </div>
<? get_template_part('reviews_block', null, ['ids' => $post->ID]);?>
<?get_template_part('scheme_block')?>
    <section class="block_questions">
        <div class="container">
                <?get_template_part('faq_block')?>
                <?get_template_part('footer_question_block')?>

        </div>
    </section>
<?php get_footer(); // footer.php ?>