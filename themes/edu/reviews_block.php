<?php
/**
 * @var $args
 */
use TQ\WP\Review;
$review = new Review('date_desc');
if(isset($args['ids']) && $args['ids']){
    $ids = $args['ids'];
}else{
    $ids = 0;
}
$arReviews = $review->getReviews($ids,-1);
?>
<?if($arReviews['items']){?>
    <section class="section block_reviews" id="reviews_block">
        <div class="container">
            <div class="row aic">
                <div class="col col-12 col-md-6">
                    <p class="title_2">Отзывы реальных студентов</p>
                </div>
                <div class="col col-12 col-md-6">
                    <div class="slider_control">
                        <div class="slider_control_left"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/arrow_left.svg" alt=""></div>
                        <div class="slider_control_dots">
                            <!-- <div class="dot"></div> -->
                        </div>
                        <div class="slider_control_right"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/arrow_right.svg" alt=""></div>
                    </div>
                </div>
            </div>
            <div class="slider_reviews">
                <?foreach ($arReviews['items'] as $item){
                    $picture = get_field('avatar', $item->ID);
                    if(!$picture){
                        $picture['url'] = DEFAULT_AVATAR;
                    }
                    $category = get_field('establishment', $item->ID);
                    $vk = get_field('vk',$item->ID)?>
                <div class="slider_reviews_wrap">
                    <div class="slider_reviews_item">
                        <div class="slider_reviews_text">
                            <div class="slider_reviews_text_inner">
                                <p class="text_1">
                                    <?=$item->post_content?>
                                </p>
                            </div>
                        </div>
                        <div class="slider_reviews_info">
                            <div class="slider_reviews_images">
                                <div class="image">
                                        <img src="<?= $picture['url'] ?>" alt="<?= isset($picture['alt']) && $picture['alt'] ?$picture['alt']: $item->post_title ?>">
                                </div>
                                <?if($vk){?>
                                <div class="image"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/users/vk.jpg" alt="vk"></div>
                                <?}?>
                            </div>
                            <div class="slider_reviews_author">
                                <p class="caption_2 bold title"><?=$item->post_title?></p>
                                <?
                                if ($category) { ?>
                                    <p class="desc_1 work"><?= $category->post_title ?></p>
                                    <?
                                } ?>
        <?if($vk){?>
                                <a href="<?=$vk?>" target="_blank" class="link">
									<span class="points">
										<span class="point"></span>
										<span class="point"></span>
										<span class="point"></span>
									</span>
                                    <span class="button_1 bold">написать в vk</span>
                                </a>
            <?}?>
                            </div>
                        </div>
                    </div>
                </div>
                <?}?>
            </div>
        </div>
    </section>
<?}?>