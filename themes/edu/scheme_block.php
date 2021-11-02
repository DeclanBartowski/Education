<?php
use TQ\WP\PostTypeHelper;
$arItems = PostTypeHelper::getScheme();

?>
<?if($arItems){?>
        <?foreach ($arItems as $key=> $item){
            $picture = get_field('picture',$item->ID);
            $arLinks = get_field('link_params',$item->ID);
            ?>
    <section class="section">
        <div class="container">
            <div class="row sheme<?=$key%2 != 0?' reverse':''?>">
                <div class="col col-12 col-md-6">
                    <div class="text_block">
                        <p class="title title_2"><?=$item->post_title?></p>
                        <p class="text text_2"><?=$item->post_content?></p>
                        <?if($picture){?>
                        <div class="image mobile">
                            <img src="<?=$picture['url']?>" alt="<?= isset($picture['alt']) && $picture['alt'] ?$picture['alt']: $item->post_title ?>">
                        </div>
                        <?}?>
                        <?if($arLinks){?>
                        <a href="<?=$arLinks['link_url']?>" class="link caption_2 bold"><?=$arLinks['link_text']?></a>
                        <?}?>
                    </div>
                </div>
                <div class="col col-12 col-md-6">
                    <?if($picture){?>
                        <div class="image">
                            <img src="<?=$picture['url']?>" alt="<?= isset($picture['alt']) && $picture['alt'] ?$picture['alt']: $item->post_title ?>">
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
    </section>
        <?}?>
<?}?>