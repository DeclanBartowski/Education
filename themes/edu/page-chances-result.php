<?
/**
 * @var $post
 */
/*
Template Name: Результаты проверки баллов ЕГЭ
*/
use TQ\WP\Chances;
get_header(); // вставка header.php
$arSpecialties = Chances::getResult();
?>
<?get_template_part('breadcrumbs')?>
<?
if($arSpecialties){
?>
    <section class="section block_directionsCheck">
        <div class="container">
            <div class="page_title title_1">Поздравляем! <br>Вы проходите на направления:</div>
            <div class="directions">
                <div class="tab_items">
                    <div class="row tab_item">
                        <?foreach ($arSpecialties as $specialty){
                            $background = get_field('background',$specialty->ID);
                            $picture = get_field('picture',$specialty->ID);
                            $minPrice = get_field('min_price',$specialty->ID);
                            $minPeriod = get_field('min_period',$specialty->ID);
                            ?>
                        <div class="item_wrap col col-xl-4 col-lg-6 col-12">
                            <div class="item"<?if($background){?> style="background-image: url(<?=$background?>);"<?}?>>
                                <a href="<?=get_permalink($specialty->ID)?>" class="item_title caption_4 bold"><?=$specialty->post_title?></a>
                                <div class="content">
                                    <div class="left">
                                        <ul class="info">
                                            <?if($minPrice){?>
                                                <li class="caption_1">от <?=number_format($minPrice,'0',',',' ')?> ₽ семестр</li>
                                            <?}?>
                                            <?if($minPeriod){?>
                                                <li class="caption_1">от <?=number_format($minPeriod,'1',',',' ')?> <?=declOfNum($minPeriod,['года','лет','лет'],false)?></li>
                                            <?}?>
                                        </ul>
                                        <a data-fancybox data-src="#get_consultation" href="javascript:;" class="link">
											<span class="points">
												<span class="point"></span>
												<span class="point"></span>
												<span class="point"></span>
											</span>
                                            <span class="item_text button_1 bold">консультация</span>
                                        </a>
                                    </div>
                                    <div class="right">
                                        <?if($picture){?>
                                            <div class="image">
                                                <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$specialty->post_title?>">
                                            </div>
                                        <?}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?}?>
                    </div>
                </div>
            </div>
            <div class="repeat_check_wrap">
                <a href="<?=get_permalink(CHECK_PAGE)?>" class="repeat_check buton_rounded">
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/images/repeat.svg" alt="">
                    <span class="button_2 bold">Проверить ещё раз</span>
                </a>
            </div>
        </div>
    </section>
    <?}else{?>
    <section class="section block_dontThrough">
        <div class="container">
            <p class="page_title title_1">К сожалению, <br>ваших баллов недостаточно </p>
            <div class="row">
                <div class="col col-12 col-xl-8 col-lg-7 col-md-12">
                    <?=do_shortcode('[contact-form-7 id="353" html_id="found_course" title="К счастью, можно поступить и без ЕГЭ"]')?>
                    <div class="bottom">
                        <a href="<?=get_permalink(CHECK_PAGE)?>" class="repeat_check buton_rounded">
                            <img src="<?=get_stylesheet_directory_uri()?>/assets/images/repeat.svg" alt="">
                            <span class="button_2 bold">Пройти тест ещё раз</span>
                        </a>
                        <div class="social_buttons_wrap">
                            <p class="text text_1">Поделиться:</p>
                            <?get_template_part('social_buttons') ?>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-4 col-lg-5 col-md-12"></div>
            </div>
        </div>
    </section>
    <?}?>
<?php get_footer(); // footer.php ?>