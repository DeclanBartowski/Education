<?
/**
 * @var $args
 */
use TQ\WP\Breadcrumbs;
$breadCrumbs = new  Breadcrumbs();
$arBread = $breadCrumbs->getBreadcrumbs($args);
if($arBread){
?>
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
<?}?>