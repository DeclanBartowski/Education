<?get_header(); // вставка header.php
/**
 * @global $pagename
 */
use TQ\WP;

$pageInfo = get_page_by_path($pagename);
$arItems = WP\PostTypeHelper::getPostList();

?>
    <section class="section block_information">
        <div class="container">
            <p class="title title_1"><?=$pageInfo->post_title?></p>
            <?if($arItems){?>
                <div class="directions">
                    <div class="tabs_wrap">
                        <?if($arItems['tabs']){?>
                            <div class="tabs disable_tabs">
                                <?$cnt = 0;
                                foreach ($arItems['tabs'] as $key=> $arTab){
                                    $cnt++;?>
                                <div class="tab_title<?=$key=='all'?' active':''?>" data-filter="<?=$key?>">
                                    <span class="caption_5"><?=$arTab['name']?><sup class="caption_1"><?=$arTab['count']?></sup></span>
                                    <input type="hidden" name="tab" value="tab_<?=$cnt?>">
                                </div>
                                <?}?>
                            </div>
                        <?}?>
                        <?if($arItems['items']){?>
                            <div class="tab_items">
                                <div class="row tab_item tab_1 active mixitup clearfix">
                                    <?foreach ($arItems['items'] as $key=> $arItem){
                                        $post = $arItem;
                                        $picture = get_field('preview_picture');
                                        $isLarge = get_field('is_large');
                                        $arCategories = get_the_category();
                                        $arClass = [];
                                        if($arCategories){
                                            foreach ($arCategories as $arCategory){
                                                $arClass[] = $arCategory->slug;
                                            }
                                        }

                                        ?>
                                    <div class="item_wrap<?=$isLarge?' large':''?> col col-xl-4 col-md-6 col-12 mix <?=implode(' ',$arClass)?>" data-order="<?=$key+1?>">
                                        <a href="<?the_permalink()?>" class="item">
                                            <div class="content">
                                                <div class="left">
                                                    <?if($arCategories){?>
                                                    <p class="">
                                                        <?foreach ($arCategories as $arCategory){?>
                                                            <span class="label desc_2"><?=$arCategory->name?></span>
                                                        <?}?>
                                                    </p>
                                                    <?}?>
                                                    <p class="item_title caption_4 bold"><?the_title()?></p>
                                                    <p class="short_desc">
                                                        <?the_excerpt()?>
                                                    </p>
                                                </div>
                                                <?if($picture){?>
                                                <div class="right">
                                                    <div class="image"><img src="<?=$picture['url']?>" alt="<?$picture['alt']?:the_title_attribute()?>"></div>
                                                </div>
                                                <?}?>
                                            </div>
                                            <p class="date desc_1"><?the_date()?></p>
                                        </a>
                                    </div>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
            <?}?>
        </div>
    </section>

<?php
get_footer(); // footer.php