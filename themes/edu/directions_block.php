<?php
use TQ\WP\Speciality;
$speciality = new Speciality();
$arSpecialities = $speciality->getMainSpecialities(true,true);

?>
<?if($arSpecialities['items']){?>
    <section class="section block_directions">
        <div class="container">
            <p class="title title_1">Направления</p>
            <div class="directions">
                <div class="tabs_wrap">
                    <div class="tabs">
                       <?foreach ($arSpecialities['items'] as $key=> $speciality){?>
                        <div class="tab_title<?=$key == 0?' active':''?>">
                            <span class="caption_5"><?=$speciality->name?><sup class="caption_1"><?=$speciality->count?></sup></span>
                            <input type="hidden" name="tab" value="tab_<?=$key+1?>">
                        </div>
                        <?}?>
                    </div>
                    <div class="tab_items">
    <?foreach ($arSpecialities['items'] as $key=> $speciality){?>
        <?if($speciality->slug == 'dpo'){

                $arItems = get_terms([
                    'taxonomy' => 'typespecialties',
                    'hide_empty' => true,
                    'pad_counts' => true,
                    'count' => false,
                    'parent' => $speciality->term_id,
                    'hierarchical' => true,
                ]);?>
            <div class="row tab_item tab_<?=$key+1?><?=$key==0?' active':''?> searching_block"<?=$key!=0?' style="display: none;"':''?>>

                <div class="item_wrap col col-12 with_search">
                    <div class="lined">
                        <div class="input_wrap search">
                            <input type="text"
                                   data-action="search_spec"
                                   data-id="<?=$speciality->term_id?>"
                                   class="input_item caption_1"
                                   placeholder="Поиск по направлениям">
                        </div>
                    </div>
                </div>
                <?foreach ($arItems as $item){
                    ?>
                    <?get_template_part('direction_item',null,['type'=>$speciality->slug,'item'=>$item,'is_term'=>true])?>
                <?}?>
                <div class="searching_error col col-12">
                    <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                    <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
                </div>
            </div>
            <?}else{?>
            <div class="row tab_item tab_<?=$key+1?><?=$key==0?' active':''?>"<?=$key!=0?' style="display: none;"':''?>>
                <?foreach ($speciality->items as $item){?>
                    <?get_template_part('direction_item',null,['type'=>$speciality->slug,'item'=>$item])?>

                <?}?>
            </div>
            <?}?>

    <?}?>

                    </div>
                </div>
            </div>
            <?if($arSpecialities['count']){?>
            <a href="/specialnosti/" class="show_more"><span class="button_1">Показать ещё <?=declOfNum($arSpecialities['count'],['направление','направления','направлений'])?></span></a>
            <?}?>
        </div>
    </section>
<?}?>