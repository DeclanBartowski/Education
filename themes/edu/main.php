<?get_header(); // вставка header.php
/*
Template Name: Главная
*/
use \TQ\WP\Establishments;
use TQ\WP\Speciality;
$title = get_field('title');
$subTitle = get_field('sub_title');
$arAfter = get_field('after_text');
$background = get_field('background');
$arLimits = Establishments::getLimitsParams();
?>
    <div class="block_intro">
        <section class="container">
            <div class="wrap row">
                <div class="item col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating"<?if($background){?> style="background-image:url(<?=$background['url']?>)" <?}?>>
                        <div>
                            <?if($title){?>
                            <div class="top_block row">
                                <p class="title_1 col"><?=$title?></p>
                            </div>
                            <?}?>
                            <?if($subTitle){?>
                            <div class="center_block">
                                <p class="text_2"><?=$subTitle?></p>
                            </div>
                            <?}?>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <ul class="info">
                                    <?if(isset($arLimits['price']) && $arLimits['price']){?>
                                    <li class="caption_1">от <?=number_format($arLimits['price'],'0','',' ')?> ₽ семестр</li>
                                    <?}?>
                                    <?if(isset($arLimits['period']) && $arLimits['period']){?>
                                    <li class="caption_1">от <?=number_format($arLimits['period'],'1',',',' ')?> <?=declOfNum($arLimits['period'],['года','лет','лет'],false)?></li>
                                    <?}?>
                                    <?if($arAfter){
                                        foreach ($arAfter as $item){?>
                                            <li class="caption_1"><?=$item['text']?></li>
                                    <?}
                                    }?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form item col-xl-4 col-lg-5 col-md-12">
                    <?get_template_part('form_pick_education',null,['short'=>true])?>
                </div>
            </div>
        </section>
    </div>
    <?get_template_part('partners_block')?>
    <?get_template_part('directions_block')?>
    <?get_template_part('diplomas_block')?>
    <?get_template_part('reviews_block')?>
    <?get_template_part('scheme_block')?>
<?php
get_footer(); // footer.php