<?
/*
Template Name: Контакты
*/

get_header(); // вставка header.php
$pageInfo = get_post();
$arTabs = get_field('tabs', $pageInfo->ID);

?>
    <section class="section block_contacts">
        <div class="container">
            <p class="title title_1"><?=$pageInfo->post_title?></p>
            <div class="directions">
                <?if($arTabs){?>
                <div class="tabs_wrap">
                    <div class="tabs">
                        <?foreach ($arTabs as $key=> $arTab){?>
                        <div class="tab_title<?=$key == 0?' active':''?>">
                            <span class="caption_5 hide_mobile"><?=$arTab['title']?></span>
                            <span class="caption_2 show_mobile"><?=$arTab['title']?></span>
                            <input type="hidden" name="tab" value="tab_<?=$key?>">
                        </div>
                        <?}?>
                    </div>
                    <div class="tab_items">
                        <?foreach ($arTabs as $key=> $arTab){?>
                            <div class="tab_item tab_<?=$key?><?=$key == 0?' active':''?>"<?if($key!=0){?> style="display: none" <?}?>>
                                <?if($arTab['description']){?>
                                    <p class="text desc_1"><?=$arTab['description']?></p>
                                <?}if($arTab['phone']){?>
                                    <a href="tel:<?=normalizePhone($arTab['phone'])?>" class="phone caption_5 bold"><?=$arTab['phone']?></a>
                                <?}if($arTab['schedule']){?>
                                    <p class="grafic caption_2"><?=$arTab['schedule']?></p>
                                <?}?>
                            </div>
                        <?}?>
                    </div>
                </div>
                <?}?>
                <?get_template_part('social_buttons',null,['links'=>true]) ?>
                <div class="contact_map" id="contact_map">
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Acc5b2e2afeb6242b224641bc2b806c77beb67cc6a08f559767b6eca6f2befccb&amp;width=100%25&amp;height=456&amp;lang=ru_RU&amp;scroll=true"></script>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); // footer.php ?>