<?
/*
Template Name: Партнерам
*/

/**
 * @var $post
 */

use TQ\WP\Establishments;

get_header(); // вставка header.php

$arFields = get_fields();
if(!isset($arFields['background']) || !$arFields['background']){
    $arFields['background']['url'] = get_stylesheet_directory_uri().'/assets/images/backgrounds/26.jpg' ;
}
?>
    <div class="block_direction get_partners">
        <section class="container">
            <div class="row">
                <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating"
                         style="background-image: url(<?=  $arFields['background']['url'] ?>);">
                        <div>
                            <?
                            if (isset($arFields['title']) && $arFields['title']) { ?>
                                <div class="top_block row">
                                    <p class="title_1 col"><?= $arFields['title'] ?></p>
                                </div>
                            <?
                            } ?>
                            <?
                            if ($post->post_content) { ?>
                                <div class="center_block">
                                    <p class="text_2">
                                        <?= the_content() ?>
                                    </p>
                                </div>
                            <?
                            } ?>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                            </div>
                            <div class="right_side col-auto">
                                <?
                                if (isset($arFields['picture']) && $arFields['picture']) { ?>
                                    <div class="image"><img src="<?= $arFields['picture']['url'] ?>"
                                                            alt="<?= $arFields['picture']['alt'] ?: $post->post_title ?>">
                                    </div>
                                <?
                                } ?>
                            </div>
                        </div>
                    </div>
                    <?
                    if (isset($arFields['statistic']) && $arFields['statistic']) {
                        $arStatistic = array_chunk($arFields['statistic'], ceil(count($arFields['statistic']) / 2))
                        ?>
                        <div class="education_details">
                            <div class="row">
                                <?
                                foreach ($arStatistic as $col) { ?>
                                    <div class="col col-12 col-sm-6">
                                        <?
                                        foreach ($col as $item) {
                                            if ($item['show_uz']) {
                                                $quantity = Establishments::getQuantity();
                                                $item['value'] = $quantity;
                                                $item['name'] = declOfNum($quantity, [
                                                    'учебное заведение с нами',
                                                    'учебных заведения с нами',
                                                    'учебных заведений с нами'
                                                ],false);
                                            } ?>
                                            <div class="block">
                                                <p class="title_3 bold title"><?= $item['value'] ?></p>
                                                <p class="caption_2"><?= $item['name'] ?></p>
                                            </div>
                                        <?
                                        } ?>
                                    </div>
                                <?
                                } ?>
                            </div>
                            <?
                            if ($arFields['static_text']) { ?>
                                <p class="desc_1 comment"><?= $arFields['static_text'] ?></p>
                            <?
                            } ?>
                        </div>
                    <?
                    } ?>
                    <?if($arFields['items']){?>
                    <div class="education_choose" id="education_choose">
                        <div class="tab_items">
                            <div class="row tab_item">
                                <div class="item_wrap col col-12">
                                    <div class="lined">
                                        <div class="row aic">
                                            <div class="col col-3 col-sm-3 col-xl-3">
                                            </div>
                                            <div class="col col-9 col-sm-9 col-xl-9">
                                            </div>
                                        </div>
                                    </div>
                                    <?foreach ($arFields['items'] as $arItem){?>
                                    <div class="lined">
                                        <div class="row aic">
                                            <div class="col col-3 col-sm-3 col-xl-3">
                                                <?if($arItem['picture']){?>
                                                <div class="image">
                                                    <img src="<?=$arItem['picture']['url']?>" alt="<?=$arItem['picture']['alt']?:$arItem['name']?>">
                                                </div>
                                                <?}?>
                                            </div>
                                            <div class="col col-9 col-sm-9 col-xl-9">
                                                <p class="title_3 bold"><?=$arItem['name']?></p>
                                                <br>
                                                <p class="text_1"><?=$arItem['text']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <?get_template_part('form_found_course') ?>

                </div>
                <div class="form item col col-12 col-xl-4 col-lg-5 col-md-12 tq_sticky_form">
                    <?get_template_part('form_become_partner') ?>
                </div>
            </div>
        </section>

        <div class="container">
            <p class="title_3">Наши партнёры</p>
            <br>
        </div>
        <?get_template_part('partners_block') ?>
    </div>
<?php
get_footer(); // footer.php ?>