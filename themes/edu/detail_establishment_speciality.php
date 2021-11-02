<?php
/**
 * @global $post
 * @global $wp
 */
use TQ\WP\Breadcrumbs,
    TQ\WP\Review,
    TQ\WP\Speciality;
$arFields = get_fields($post->ID);
$arCategories = get_the_terms($post->ID, 'typespecialties');
$isDpo = false;
$establishments = \TQ\WP\PostTypeHelper::getElements('establishments',['ID'=>'asc'],['name'=>$wp->query_vars['establishments_name']],1);
if($establishments){
    $curEstablishment = reset($establishments);
    $arSpecs = get_field('specs',$curEstablishment->ID);
    $arEstablishmentsFields = get_fields($curEstablishment->ID);
    foreach ($arSpecs as $spec){
        if($spec['item']->ID == $post->ID){
            $arSpecFields = $spec;
        }
    }
    $establishmentPicture = get_field('preview_picture',$curEstablishment->ID);
    $description = $curEstablishment->post_title;
}
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


$arAdditionalInfo = Speciality::getAdditionalInfo($post);
if (isset($curEstablishment) && $curEstablishment) {
    $review = new Review();
    $arReviews = $review->getReviews($curEstablishment->ID,-1);
}
if(isset($arReviews['total']) && $arReviews['total']){
    $reviewCount = $arReviews['total'];
}else{
    $reviewCount = 0;
}
if(!$isDpo){
    unset($arFields['type']);
}
if(isset($curEstablishment)){
    $breadCrumbs = new  Breadcrumbs();
    $post = $curEstablishment;
    $arBread = $breadCrumbs->getBreadcrumbs();
    wp_reset_postdata();
    unset($arBread[array_key_last($arBread)]['is_last']);
    $arBread[] = [
            'is_last'=>true,
            'title'=>$post->post_title,
    ];
}

$arProfiles = [];
if(isset($curEstablishment) && $curEstablishment){
    $arSpecs = get_field('specs',$curEstablishment->ID);
    $arSpec = array_filter($arSpecs,function ($arItem) use($post){
        return $arItem['item']->ID == $post->ID;
    });
    if($arSpec){
        $arSpec = reset($arSpec);
        $arProfiles = $arSpec['profiles'];
        $arFields['min_price'] = $arSpec['price'];
        $arFields['min_period']= $arSpec['period'];
    }
}

?>
<?if(isset($arBread)){?>
<div class="container">
    <div class="breadcrumbs">
        <?foreach ($arBread as $arItem){?>
            <?if(isset($arItem['is_last']) && $arItem['is_last']){?>
                <a class="link last desc_1"><?=$arItem['title']?></a>
            <?}else{
                ?>
                <a href="<?=$arItem['url']?>" class="link desc_1"><?=$arItem['title']?></a>
                <span class="delimiter">/</span>
                <?
            }?>
        <?}?>
    </div>
</div>
<?}else{?>
<?get_template_part('breadcrumbs', null, ['tax' => 'typespecialties']) ?>
<?}?>
<div class="block_direction">
    <section class="container">
        <div class="row">
            <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                <div class="education floating">
                    <div>
                        <div class="heading">
                            <?if(isset($curEstablishment) && isset($establishmentPicture) && $establishmentPicture){?>
                            <div class="image">
                                <img src="<?=$establishmentPicture['url']?>" alt="<?=$establishmentPicture['alt']?:$curEstablishment->post_title?>">
                            </div>
                            <?}?>
                            <div class="">
                                <?if(isset($curEstablishment) && $curEstablishment->post_title){?>
                                <p class="caption_2 bold"><?=$curEstablishment->post_title?></p>
                                <?}?>
                                <?if(isset($arFields['type'])){?>
                                    <p class="desc_1 specialty"><?=$arFields['type']?:''?></p>
                                <?}elseif(isset($category) && $category){?>
                                    <p class="desc_1 specialty"><?=$category->name?></p>
                                <?}?>

                            </div>
                        </div>
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
                                <?if($arProfiles){?>
                                <a href="#education_programs" class="in_universities button_1 bold"><?=declOfNum(count($arProfiles),['программа','программы','программ'])?></a>
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
                <?if(!$isDpo && isset($arProfiles) && $arProfiles){?>
                <div class="education_programs section" id="education_programs">
                    <p class="title_3 title"><?=declOfNum(count($arProfiles),['программа','программы','программ'])?> онлайн обучения</p>
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
                                        <p class="desc_1 desc">Всего <?=declOfNum(count($arProfiles),['программа','программы','программ'])?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?foreach ($arProfiles as $profile){?>
                        <div class="item_wrap col col-12">
                            <div class="lined">
                                <div class="row_wrap">
                                    <div class="text_1 bold searching_value"><?=$profile->post_title?></div>
                                    <div class="info_wrap">
                                        <ul class="info">
                                            <?
                                            if (isset($arFields['min_price']) && $arFields['min_price']) { ?>
                                                <li class="caption_1">от <?= number_format($arFields['min_price'], '0', ',',
                                                        ' ') ?> ₽ семестр
                                                </li>
                                                <?
                                            } ?>
                                            <?
                                            if (isset($arFields['min_period']) && $arFields['min_period']) { ?>
                                                <li class="caption_1">от <?= declOfNum($arFields['min_period'],
                                                        ['года', 'лет', 'лет']) ?></li>
                                                <?
                                            } ?>
                                        </ul>
                                        <a data-fancybox
                                           data-action="save_spec_est"
                                           data-est="<?=isset($curEstablishment)?$curEstablishment->post_title:''?>"
                                           data-spec="<?=$post->post_title?>"
                                           data-profile="<?=$profile->post_title?>"
                                           data-src="#get_consultation"
                                           href="javascript:;"
                                           class="link">
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
                        <div class="searching_error col col-12">
                            <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                            <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
                        </div>
                        <div class="col col-12">
                            <div class="not_found">
                                <p class="title_3 not_found_title">Не нашли программу?</p>
                                <p class="caption_2 not_found_desc">Напишите нам об этом — возможно информация еще не занесена</p>
                                <a data-fancybox data-src="#get_consultation" href="javascript:;" class="button_black button_2">Сделать запрос</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?}?>

                <? if (isset($arFields['detail_info']) && $arFields['detail_info']) {?>
                        <?if(!$isDpo){?>
                <p class="title_3 title" id="education_details">Детали онлайн обучения</p>
                            <?}else{?>
                        <div class="collapsed_text">
                        </div>
                    <?}?>
                <div class="education_details">

                            <?
                            foreach ($arFields['detail_info'] as $item) {
                                switch ($item['type']) {
                                    case 'Минимальный срок':
                                        $item['value'] = sprintf('от %s',
                                            declOfNum($arFields['min_period'], ['года', 'лет', 'лет']));
                                        break;
                                    case 'Минимальная цена':
                                        $item['value'] = sprintf('от %s ₽ семестр',
                                            number_format($arFields['min_price'], '0', ',', ' '));
                                        break;
                                    case 'Вступительные испытания':
                                        if(isset($arSpecFields['introductory']) && $arSpecFields['introductory']){
                                            $item['value'] = $arSpecFields['introductory'];
                                        }
                                        break;
                                } ?>
                                <div class="row education_details_row">
                                    <div class="col col-12 col-md-4">
                                        <p class="text_1 bold"><?= $item['name'] ?></p>
                                    </div>
                                    <div class="col col-12 col-md-8">
                                        <p class="text_1"><?= $item['value'] ?></p>
                                    </div>
                                </div>
                                <?
                            } ?>


                    <?
                    if (isset($arFields['text_after_detail']) && $arFields['text_after_detail']) { ?>
                        <p class="desc_1 comment"><?= $arFields['text_after_detail'] ?></p>
                        <?
                    } ?>
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
                <?if(isset($arFields['what_study']) && $arFields['what_study']){?>
                <div class="education_descriptions" id="education_descriptions">
                    <p class="title_3 title">Что вы будете изучать:</p>
                    <div class="tab_items">
                        <div class="row tab_item">
                            <div class="item_wrap col col-12">
                                <div class="lined empty">
                                    <div class="row aic">
                                        <div class="col col-12 col-md-9">
                                        </div>
                                        <div class="col col-12 col-md-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?foreach ($arFields['what_study'] as $key=> $arField){?>
                                    <?if($key == 5){?>
                                    <div class="hidden_items" style="display: none;">
                                            <?}?>
                            <div class="item_wrap col col-12">
                                <div class="lined">
                                    <div class="row aic">
                                        <div class="col col-12 col-md-9">
                                            <p class="text_1 bold list_item"><?=$arField['name']?></p>
                                        </div>
                                        <div class="col col-12 col-md-3">
                                            <p class="desc_1 desc"><?=$arField['text']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                                        <?if(count($arFields['what_study'])>5){?>
                                    </div>
                                        <?}?>
                        </div>
                    </div>
                    <?if(count($arFields['what_study'])>5){?>
                    <a href="javascript:;" class="show_more"><span class="button_1">Показать ещё <?=count($arFields['what_study'])-5?></span></a>
                    <?}?>
                </div>
                <?}?>
                <?if(isset($arEstablishmentsFields) && $arEstablishmentsFields){?>
                <?get_template_part('establishment_licenses',null,['arFields'=>$arEstablishmentsFields,'dpo'=>$isDpo]) ?>
                <?}?>
                <?if(isset($arEstablishmentsFields) && $arEstablishmentsFields){?>
                <?get_template_part('admission_documents',null,['arFields'=>$arEstablishmentsFields]) ?>
                <?}?>

                <?
                if ( isset($arAdditionalInfo['professions']) && $arAdditionalInfo['professions']) { ?>
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
                <?if($isDpo){?>
                    <?get_template_part('form_calculate_education') ?>
                <?}else{?>
                    <?get_template_part('form_pick_education') ?>
                <?}?>
            </div>
        </div>
    </section>
</div>

<?
if (isset($curEstablishment->ID)){
    get_template_part('reviews_block', null, ['ids' => $curEstablishment->ID]);
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