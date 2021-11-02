<?
/**
 * @global $post
 */

use TQ\WP\Profession;
get_header(); // вставка header.php
$arCategories = get_the_terms($post->ID,'prof_categories');
$arCatNames = [];
if($arCategories){
    foreach ($arCategories as $category){
        $arCatNames[] = $category->name;
    }
}
$arFields = get_fields();
$arInfo = Profession::getProfInfo($post->ID);

?>
<?get_template_part('breadcrumbs')?>

    <div class="block_direction">
        <section class="container">
            <div class="row">
                <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating"<?if(isset($arFields['background']) && $arFields['background']){?> style="background-image: url(<?=$arFields['background']?>);"<?}?>>
                        <div>
                            <?if($arCatNames){?>
                            <div class="heading">
                                <div class="label desc_2"><?=implode(', ',$arCatNames)?></div>
                            </div>
                            <?}?>
                            <p class="title_1 title"><?the_title()?></p>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <div class="top">
                                </div>
                                <div class="bottom">
                                    <?if($arInfo['specialities']){?>
                                        <a href="#education_programs" class="in_universities button_1 bold"><?=declOfNum(count($arInfo['specialities']),['направление','направления','направлений'])?></a>
                                    <?}?>
                                </div>
                            </div>
                            <div class="right_side col-auto">
                                <?if(isset($arFields['picture']) && $arFields['picture']){?>
                                    <div class="round_image">
                                        <img src="<?=$arFields['picture']['url']?>" alt="<?=$arFields['picture']['alt']?:$post->post_title?>">
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>

                    <div class="collapsed_text">
                        <p class="text_1"><?=get_the_content()?></p>
                        <?if(isset($arFields['hidden_text']) && $arFields['hidden_text']){?>
                        <p class="text_1 hidden_text" style="display: none;"><?=$arFields['hidden_text']?></p>
                        <p class="text_1 expand" data-expand="Развернуть" data-collapse="Свернуть">Развернуть</p>
                        <?}?>
                    </div>
                <?if(isset($arInfo['specialities']) && $arInfo['specialities']){?>
                    <div class="education_programs section" id="education_programs">
                        <p class="title_3 title">Этой профессии обучают <br>на <?=declOfNum(count($arInfo['specialities']),['направлении','направлениях','направлениях'])?></p>
                        <div class="row tab_items searching_block">
                            <div class="item_wrap col col-12 with_search">
                                <div class="lined">
                                    <div class="row aic">
                                        <div class="col col-12 col-md-6">
                                            <div class="input_wrap search hide_not_found">
                                                <input type="text" class="input_item caption_1" placeholder="Поиск по направлениям">
                                            </div>
                                        </div>
                                        <div class="col col-12 col-md-6">
                                            <p class="desc_1 desc">Всего <?=declOfNum(count($arInfo['specialities']),['направление','направления','направлений'])?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?foreach ($arInfo['specialities'] as $speciality){
                                $arSpecFields = get_fields($speciality->ID);
                                ?>
                            <div class="item_wrap col col-12">
                                <div class="lined">
                                    <div class="row aic">
                                        <div class="col col-3 col-sm-2 col-xl-2">
                                            <?if($arSpecFields['picture']){?>
                                            <div class="image">
                                                <img src="<?=$arSpecFields['picture']['url']?>" alt="<?=$arSpecFields['picture']['alt']?:$speciality->post_title?>">
                                            </div>
                                            <?}?>
                                        </div>
                                        <div class="col col-9 col-sm-10 col-xl-10">
                                            <div class="row aic">
                                                <div class="col col-12 col-lg-12 col-xl-5">
                                                    <a href="<?=get_permalink($speciality->ID)?>" class="caption_4 bold searching_value"><?=$speciality->post_title?></a>
                                                </div>
                                                <div class="col col-12 col-lg-12 col-xl-7">
                                                    <div class="row aic">
                                                        <div class="col col-12 col-sm-7 col-md-8 col-lg-7 col-xl-6">
                                                            <ul class="info">
                                                                <?if($arSpecFields['min_price']){?>
                                                                <li class="caption_1">от <?=number_format($arSpecFields['min_price'],'0',',',' ')?> ₽ семестр</li>
                                                                <?}?>
                                                                <?if($arSpecFields['min_period']){?>
                                                                <li class="caption_1">от <?=str_replace('.',',',$arSpecFields['min_period'])?> <?=declOfNum($arSpecFields['min_period'],['года','лет','лет'],false)?></li>
                                                                <?}?>
                                                            </ul>
                                                        </div>
                                                        <div class="col col-12 col-sm-5 col-md-4 col-lg-5 col-xl-6">
                                                            <a data-fancybox data-src="#get_consultation" href="javascript:;" class="link">
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

                    <?if(isset($arFields['diplomas']) && $arFields['diplomas']){?>
                    <div class="education_diploms" id="education_diploms">
                        <p class="title_3 title"><?=$arFields['diplomas']['title']?:'В конце вы получите диплом гособразца'?></p>
                        <p class="text_1 text"><?=$arFields['diplomas']['text']?:'Все наши учебные заведения-партнёры имеют госаккредитацию, а дипломы заносятся в федеральный реестр.'?></p>
                        <div class="row">
                            <?if($arFields['diplomas']['picture']){?>
                            <div class="col col-12 col-md-6">
                                <div class="image">
                                    <a href="<?=$arFields['diplomas']['picture']['url']?>" data-fancybox="images"><img src="<?=$arFields['diplomas']['picture']['url']?>" alt="<?=$arFields['diplomas']['picture']['alt']?>"></a>
                                </div>
                            </div>
                            <?}?>
                            <?if($arFields['diplomas']['second_picture']){?>
                            <div class="col col-12 col-md-6">
                                <div class="image">
                                    <a href="<?=$arFields['diplomas']['second_picture']['url']?>" data-fancybox="images"><img src="<?=$arFields['diplomas']['second_picture']['url']?>" alt="<?=$arFields['diplomas']['second_picture']['alt']?>"></a>
                                </div>
                            </div>
                            <?}?>
                        </div>
                    </div>
                    <?}?>
                    <?if(isset($arFields['other']) && $arFields['other']){

                        $arOtherPrices = Profession::getMinPrices();

                        ?>
                        <div class="education_choose" id="education_choose">
                        <div class="head">
                            <p class="title_3 title">Похожие профессии</p>
                            <p class="desc_1 description">Отличаются сроками <br>и стоимостью</p>
                        </div>
                        <div class="tab_items">
                            <div class="row tab_item">
                                <?foreach ($arFields['other'] as $other){
                                    $arCatNames = [];
                                    $arCategories = get_the_terms($other->ID,'prof_categories');
                                    if($arCategories){
                                        foreach ($arCategories as $category){
                                            $arCatNames[] = $category->name;
                                        }
                                    }
                                    $arOtherFields = get_fields($other->ID);
                                    ?>
                                <div class="item_wrap col col-12">
                                    <div class="lined">
                                        <div class="row aic">
                                            <div class="col col-xl-2 col-sm-3 col-3">
                                                <?if(isset($arOtherFields['picture']) && $arOtherFields['picture']){?>
                                                    <div class="image">
                                                        <img src="<?=$arOtherFields['picture']['url']?>" alt="<?=$arOtherFields['picture']['alt']?:$other->post_title?>">
                                                    </div>
                                                <?}?>
                                            </div>
                                            <div class="col col-xl-10 col-sm-9 col-9">
                                                <div class="row aic">
                                                    <div class="col col-xl-7 col-md-7 col-12">
                                                        <?if($arCatNames){?>
                                                        <div class="label"><span class="desc_2"><?=implode(', ',$arCatNames)?></span></div>
                                                        <?}?>
                                                        <a href="<?=get_permalink($other->ID)?>" class="caption_3 bold searching_value"><?=$other->post_title?></a>
                                                    </div>
                                                    <div class="col col-xl-5 col-md-5 col-12">
                                                        <ul class="info">
                                                            <?if(isset($arOtherFields['wage']) && $arOtherFields['wage']){?>
                                                            <li class="caption_1">от <?=number_format($arOtherFields['wage'],'0',',',' ')?> ₽ зарплата</li>
                                                            <?}?>
                                                            <?if(isset($arOtherPrices[$other->ID]) && $arOtherPrices[$other->ID]){?>
                                                            <li class="caption_1">от <?=number_format($arOtherPrices[$other->ID],'0',',',' ')?> ₽ семестр обучения</li>
                                                            <?}?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                    <?}?>
                </div>
                <div class="form item col col-12 col-xl-4 col-lg-5 col-md-12">
                    <?get_template_part('form_calculate_education')?>
                </div>
            </div>
        </section>
    </div>
<?get_template_part('scheme_block')?>

<?php get_footer(); // footer.php ?>