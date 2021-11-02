<?
/**
 * @var $args
 */
use \TQ\WP\Profession;
if(isset($args['elements']) && $args['elements']){
    $arItems = $args['elements'];
}else{
    $arItems = Profession::getElements();
}

if($arItems){
    foreach ($arItems as $key=> $item){
        $arCatNames = [];
        $arCategories = get_the_terms($item->ID,'prof_categories');
        if($arCategories){
            foreach ($arCategories as $category){
                $arCatNames[] = $category->name;
            }
        }
        $arFields = get_fields($item->ID);
        ?>
        <div class="item_wrap col col-12" data-index="<?=$key+1?>" data-price="<?=isset($item->minPrice) && $item->minPrice?$item->minPrice:0?>">
            <div class="lined">
                <div class="row aic">
                    <div class="col col-xl-2 col-sm-3 col-3">
                        <?if($arFields['picture']){?>
                        <a href="<?=get_permalink($item->ID)?>" class="image">
                            <img src="<?=$arFields['picture']['url']?>" alt="<?=$arFields['picture']['alt']?:$item->post_title?>">
                        </a>
                        <?}?>
                    </div>
                    <div class="col col-xl-10 col-sm-9 col-9">
                        <div class="row aic">
                            <div class="col col-xl-7 col-md-7 col-12">
                                <?if($arCatNames){?>
                                <div class="label"><span class="desc_2"><?=implode(', ',$arCatNames)?></span></div>
                                <?}?>
                                <a href="<?=get_permalink($item->ID)?>" class="caption_3 bold searching_value"><?=$item->post_title?></a>
                            </div>
                            <div class="col col-xl-5 col-md-5 col-12">
                                <ul class="info">
                                    <?if($arFields['wage']){?>
                                    <li class="caption_1">от <?=number_format($arFields['wage'],'0',',',' ')?> ₽ зарплата</li>
                                    <?}?>
                                    <?if(isset($item->minPrice) && $item->minPrice){?>
                                    <li class="caption_1">от <?=number_format($item->minPrice,'0',',',' ')?> ₽ семестр обучения</li>
                                    <?}?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
?>

<?}?>