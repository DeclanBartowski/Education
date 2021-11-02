<?
/**
 * @global $post
 */

use TQ\WP\PostTypeHelper;
get_header(); // вставка header.php
$arCategories = get_the_category();
$picture = get_field('detail_picture');
$background = get_field('background');

$otherPosts = PostTypeHelper::getElements('post','rand',['post__not_in'=>[$post->ID]],3);
$nextPost = get_next_post();

?>
<?get_template_part('breadcrumbs')?>
    <div class="block_infoArticle">
        <section class="container">
            <div class="wrap row">
                <div class="item col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating" style="background-image: url(<?=$background?:sprintf('%s/assets/images/backgrounds/1.png',get_stylesheet_directory_uri())?>);">
                        <div>
                            <p class="">
                                <?foreach ($arCategories as $arCategory){?>
                                    <span class="label desc_2"><?=$arCategory->name?></span>
                                <?}?>
                            </p>
                            <div class="top_block row">
                                <p class="title_2 col"><?the_title()?></p>
                            </div>
                        </div>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <p class="desc_1 transparent_4"><?the_date()?></p>
                            </div>
                            <?if($picture){?>
                            <div class="right_side col-auto">
                                <div class="image"><img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:the_title_attribute()?>"></div>
                            </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="form item col-xl-4 col-lg-5 col-md-12">
                    <?get_template_part('form_pick_education')?>
                </div>
            </div>
        </section>
    </div>

    <div class="section block_article">
        <div class="container">
            <div class="row">
                <div class="col col-12 col-xl-7 col-lg-6 col-md-12">
                    <?=apply_filters( 'the_content', get_the_content() )?>
                    <p class="social_text text_1">Поделиться:</p>
                    <div class="article_social">
                        <?get_template_part('social_buttons') ?>
                        <?if($nextPost){?>
                        <a href="<?the_permalink($nextPost->ID)?>" class="article_next"><span class="button_1 bold">следующая статья</span></a>
                        <?}?>
                    </div>
                </div>
                <?if($otherPosts){?>
                <div class="col col-xl-5 col-lg-6 col-md-12">
                    <div class="article_interested">
                        <div class="">
                            <p class="title caption_4 bold">Может быть интересно:</p>
                            <?foreach ($otherPosts as $arItem){
                                $post = $arItem;
                                $arCategories = get_the_category();
                                $arCategory = reset($arCategories);
                                ?>
                            <div class="article_item">
                                <p class="label desc_1"><?=$arCategory->name?></p>
                                <a href="<?the_permalink()?>" class="caption_2"><?the_title()?></a>
                            </div>
                            <?}
                            wp_reset_postdata();?>
                        </div>
                    </div>
                    <div class="height"></div>
                </div>
                <?}?>
            </div>
        </div>
    </div>
    <section class="block_questions">
    <div class="container">
<?get_template_part('footer_question_block')?>
    </div>
    </section>
<?php get_footer(); // footer.php ?>