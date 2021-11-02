<?php
use TQ\WP\PostTypeHelper;
$arDiplomas = PostTypeHelper::getDiplomas();
$title = get_field('diplomas_title',MAIN_PAGE);
$description = get_field('diplomas_description',MAIN_PAGE);
?>
<?if($arDiplomas){?>
    <section class="section block_diplomas">
        <div class="container">
            <div class="row tabs_wrap">
                <div class="col col-lg-6 col-12">
                    <?if(isset($title) && $title){?>
                        <p class="title title_2"><?=$title?></p>
                    <?}?>
                    <?if(isset($description) && $description){?>
                        <p class="text text_2"><?=$description?></p>
                    <?}?>
                    <div class="tabs">
                    <?foreach ($arDiplomas as $key=> $diploma){?>
                        <div class="tab_title<?=$key==0?' active':''?>">
                            <span class="caption_5"><?=$diploma->post_title?></span>
                            <input type="hidden" name="tab" value="tab_<?=$key?>">
                        </div>
                    <?}?>
                    </div>
                </div>
                <div class="col col-lg-6 col-12">
                    <div class="tab_items">
                        <?foreach ($arDiplomas as $key=> $diploma){?>
                            <div class="tab_item tab_<?=$key?><?=$key==0?' active':''?>"<?=$key!=0?' style="display: none;"':''?>>
                                <div class="image">
                                    <a href="<?=$diploma->logo['url']?>" data-fancybox="images">
                                        <img src="<?=$diploma->logo['url']?>" alt="<?=$diploma->logo['alt']?:$diploma->post_title?>">
                                    </a>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?}?>