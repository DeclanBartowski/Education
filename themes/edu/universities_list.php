<?php
/**
 * @var $args
 */
use TQ\WP\Establishments;
if(isset($args['term_id']) && $args['term_id']){
    $arItems = Establishments::getElements($args['term_id']);
}else{
    $arItems = Establishments::getElements();
}

?>

    <div class="tab_items row searching_block">
        <?if(isset($arItems) && $arItems){?>
            <?foreach ($arItems as $item){
                $arFields = get_fields($item->ID);
                ?>
                <div class="item_wrap col col-12 col-md-6 col-xl-4">
                    <div class="item"<?if(isset($arFields['background']) && $arFields['background']){?> style="background-image: url(<?=$arFields['background']?>);"<?}?>>
                        <?if(isset($arFields['advantages']) && $arFields['advantages']){?>
                            <p class="item_sub desc_2"><?=$arFields['advantages']?></p>
                        <?}?>
                        <a href="<?=isset($args['link']) && $args['link']?sprintf('%s?id=%s',$args['link'],$item->ID):get_permalink($item->ID)?>" class="item_title caption_4 bold searching_value"><?=$item->post_title?></a>
                        <div class="content">
                            <div class="left">
                                <?if(isset($arFields['specs']) && $arFields['specs']){?>
                                    <?if($arFields['specs']){?>
                                        <ul class="info">
                                            <li class="caption_1">от <?=number_format($item->min_price,'0',',',' ')?> ₽ семестр</li>
                                        </ul>
                                    <?}?>
                                    <a href="<?=get_permalink($item->ID)?>" class="link no_points">
										<span class="points">
											<span class="point"></span>
											<span class="point"></span>
											<span class="point"></span>
										</span>
                                        <span class="item_text button_1 bold"><?=declOfNum(count($arFields['specs']),['направление','направления','наравлений'])?></span>
                                    </a>
                                <?}?>
                            </div>
                            <?if(isset($arFields['preview_picture']) && $arFields['preview_picture']){?>
                                <div class="right rounded">
                                    <div class="image"><img src="<?=$arFields['preview_picture']['url']?>" alt="<?=$arFields['preview_picture']['alt']?:$item->post_title?>"></div>
                                </div>
                            <?}?>

                        </div>
                    </div>
                </div>
            <?}?>
        <?}else{?>
            <div class="searching_error col col-12" style="display:block;">
                <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                <div class="image" style="background-image: url(<?=get_stylesheet_directory_uri()?>/assets/images/find_nothing.png);"></div>
            </div>
        <?}?>
    </div>
