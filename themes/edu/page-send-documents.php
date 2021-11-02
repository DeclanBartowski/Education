<?
/**
 * @var $post
 */
/*
Template Name: Подать документы (Форма)
*/
use TQ\WP\Chances;
if(isset($_REQUEST['id']) && $_REQUEST['id']){
    $establishment = get_post($_REQUEST['id']);
}
$selectUrl = get_permalink(SEND_DOCS_SELECT);
if(!isset($establishment) || !$establishment || $establishment->post_type!='establishments'){
    $error = true;
    wp_redirect($selectUrl);
    exit();
}
get_header(); // вставка header.php
$background = get_field('background',$establishment->ID);
$picture = get_field('preview_picture',$establishment->ID);
$minPrice = get_field('min_price',$establishment->ID);
$advantages = get_field('advantages',$establishment->ID);
$specs = get_field('specs',$establishment->ID);
$arEstablishmentsParams = Chances::getEstablishmentsParams($establishment);
?>
    <section class="section main block_submitDocuments">
        <div class="container">
            <p class="page_title title_1"><?=$post->post_title?></p>
            <div class="row">
                <div class="col-12 show_lg">
                    <div class="tab_items row">
                        <div class="item_wrap col col-12">
                            <div class="item mini"<?if($background){?> style="background-image: url(<?=$background?>);"<?}?>>
                                <div class="head">
                                    <?if($picture){?>
                                    <div class="image_block rounded">
                                        <div class="image">
                                            <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$establishment->post_title?>">
                                        </div>
                                    </div>
                                    <?}?>
                                    <p class="item_title caption_4 bold"><?=$establishment->post_title?></p>
                                </div>
                                <div class="foot">
                                    <a href="<?=$selectUrl?>>" class="link no_points">
                                        <span class="item_text button_1 bold">Изменить</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="submitDocuments_wrap">
                        <?=do_shortcode('[contact-form-7 id="363" title="Подать документы" html_class="submitDocuments"]')?>
                    </div>
                </div>
                <div class="col col-xl-4 col-lg-5 col-md-12 hide_lg">
                    <div class="tab_items row">
                        <div class="item_wrap col col-12">
                            <div class="item"<?if($background){?> style="background-image: url(<?=$background?>);"<?}?>>
                                <?if(isset($advantages) && $advantages){?>
                                    <p class="item_sub desc_2"><?=$advantages?></p>
                                <?}?>
                                <div class="item_title caption_4 bold searching_value"><?=$establishment->post_title?></div>
                                <div class="content">
                                    <div class="left">
                                        <?if($minPrice){?>
                                        <ul class="info">
                                            <li class="caption_1">от <?=number_format($minPrice,'0',',',' ')?> ₽ семестр</li>
                                        </ul>
                                        <?}?>
                                        <?if($specs){?>
                                        <a href="<?=get_permalink($establishment->ID)?>" class="link no_points">
											<span class="points">
												<span class="point"></span>
												<span class="point"></span>
												<span class="point"></span>
											</span>
                                            <span class="item_text button_1 bold"><?=declOfNum(count($specs),['направление','направления','наравлений'])?></span>
                                        </a>
                                        <?}?>
                                    </div>
                                    <?if($picture){?>
                                        <div class="right rounded">
                                            <div class="image">
                                                <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$establishment->post_title?>">
                                            </div>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    let EstablishmentsParams = <?=json_encode($arEstablishmentsParams)?>;
</script>
<?php get_footer(); // footer.php ?>

