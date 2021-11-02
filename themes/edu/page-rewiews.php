<?
/*
Template Name: Отзывы
*/

use TQ\WP\PostTypeHelper,
    TQ\WP\Review;

get_header(); // вставка header.php
$currentId = isset($_GET['id'])?$_GET['id']:0;
$review = new Review(isset($_GET['sort'])?$_GET['sort']:'');
$universities = PostTypeHelper::getElements('establishments', ['post_title' => 'asc']);
$reviews = $review->getReviews($currentId);
$arSort = $review->arSort;
?>
    <section class="section page_reviews">
        <div class="container">
            <p class="title_1 title" id="title"><?the_title()?></p>
            <p class="text_1 text"><?= get_the_content() ?></p>
            <div class="filter_reviews<?=$currentId>0?' select_item':''?>">
                <div class="row">
                    <?
                    if ($universities) { ?>
                        <div class="col col-12 col-md-4 mb_32 hide_lg">
                            <div class="input_wrap filter_search">
                                <input type="text" class="input_item caption_1"
                                       placeholder="Поиск по учебным заведениям">
                            </div>
                        </div>
                    <?
                    } ?>
                    <?if($arSort){?>
                    <div class="col col-12 col-md-8 mb_32 hide_lg">
                        <div class="filter_reviews_data">
                            <p class="desc_1 filter_reviews_count">Всего <?=declOfNum($reviews['total'],['отзыв','отзыва','отзывов'])?></p>
                            <select name="sort" class="btn_sort caption_1 styled" onchange="location.href=$(this).val()">
                                <?foreach ($arSort as $key=> $item){
                                    $url = http_build_query (['id'=>$_GET['id']??'','sort'=>$key])?>
                                <option value="?<?=$url?>"<?=isset($item['is_current'])?' selected':''?>><?=$item['name']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                    <?}?>
                    <?
                    if ($universities) { ?>
                        <div class="col col-12 col-md-4 hide_lg">
                            <div class="filter_reviews_universities">
                                <?
                                foreach ($universities as $university) {
                                    $picture = get_field('preview_picture', $university->ID);
                                    if($currentId == $university->ID){
                                        $class = ' selected';
                                        $url = get_permalink();
                                    }else{
                                        $class = '';
                                        $url = sprintf('?id=%s',$university->ID);
                                    }
                                    ?>
                                    <a href="<?= $url ?>" class="university_item<?=$class?>"
                                       data-searching="<?= mb_strtolower($university->post_title) ?>">
                                        <div class="image">
                                            <?
                                            if ($picture) { ?>
                                                <img src="<?= $picture['url'] ?>"
                                                     alt="<?= $picture['alt'] ?: $university->post_title ?>">
                                            <?
                                            } ?>
                                        </div>
                                        <p class="caption_2 bold"><?= $university->post_title ?></p>
                                        <div class="remove"></div>
                                        <input type="checkbox" class="hide" name="university"
                                               value="<?= mb_strtolower($university->post_title) ?>">
                                    </a>
                                <?
                                } ?>
                            </div>
                            <div class="to_top_wrap">
                                <a href="#title" class="to_top button_1 bold">Наверх</a>
                            </div>
                        </div>
                    <?
                    } ?>
                    <div class="col col-12 show_lg">
                        <?
                        if ($universities) { ?>
                            <a href="javascript:void(0);" class="show_filter button_1 bold">выберите учебное
                                заведение</a>
                        <?
                        } ?>
                        <p class="desc_1 filter_reviews_count">Всего <?=declOfNum($reviews['total'],['отзыв','отзыва','отзывов'])?></p>
                    </div>
                    <div class="col col-12 col-lg-8 filter_content">
                        <?if($currentId){?>
                        <a href="<?=get_permalink(REVIEW_ADD_ID)?>?id=<?=$currentId?>" class="button_2 bold center leave_review">Оставить отзыв</a>
                        <?}?>
                        <?
                        if ($reviews['items']) { ?>
                            <?
                            foreach ($reviews['items'] as $key=> $item) {
                                $picture = get_field('avatar', $item->ID);
                                if(!$picture){
                                    $picture['url'] = DEFAULT_AVATAR;
                                }
                                $category = get_field('establishment', $item->ID);
                                $vk = get_field('vk',$item->ID)
                                ?>
                                <div class="review_item" data-searching="<?= isset($category)?$category->post_title:'' ?>"
                                     data-index="<?=$key+1?>" data-date="<?=strtotime($item->date)?>">
                                    <div class="head">
                                        <div class="left">
                                            <div class="avatar">
                                                    <img src="<?= $picture['url'] ?>"
                                                         alt="<?= isset($picture['alt']) && $picture['alt'] ?$picture['alt']: $item->post_title ?>">
                                            </div>
                                            <div class="">
                                                <p class="caption_2 bold"><?= $item->post_title ?></p>
                                                <?
                                                if ($category) { ?>
                                                    <p class="desc_1 desc"><?= $category->post_title ?></p>
                                                <?
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <?if($vk){?>
                                            <div class="socail_image"><img
                                                        src="<?= get_stylesheet_directory_uri() ?>/assets/images/users/vk.jpg"
                                                        alt=""></div>
                                            <a href="<?=$vk?>" target="_blank" class="social_link">
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
                                    <p class="text_1">
                                        <?= $item->post_content ?>
                                    </p>
                                    <div class="bottom">
                                        <?if($vk){?>
                                            <div class="socail_image"><img
                                                        src="<?= get_stylesheet_directory_uri() ?>/assets/images/users/vk.jpg"
                                                        alt=""></div>
                                            <a href="<?=$vk?>" target="_blank" class="social_link">
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
                            <?
                            } ?>
                            <?
                            if ($reviews['nav_items'] && count($reviews['nav_items'])>1) {?>
                                <div class="pagination">
                                    <?foreach ($reviews['nav_items'] as $item){?>
                                            <?if($item->is_current){?>
                                            <a class="link current"><?=$item->page_num?></a>
                                            <?}else{?>
                                            <a href="<?=$item->url?>" class="link"><?=$item->page_num?></a>
                                            <?}?>
                                    <?}?>
                                </div>
                            <?
                            } ?>
                        <?
                        }else{
                            echo 'Отзывов не найдено';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?if($universities){?>
    <div class="filter_mobile" id="filter_mobile">
        <div class="head">
            <p class="filter_mobile_title title_2">Выберите учебное заведение</p>
            <div class="close"></div>
        </div>
        <form action="" method="get" class="filter_reviews_universities form">
            <?
            foreach ($universities as $university) {
                $picture = get_field('preview_picture', $university->ID);
                if($currentId == $university->ID){
                    $class = ' selected';
                }else{
                    $class = '';
                }
                ?>
                <label class="university_item<?=$class?>">
                    <div class="image">
                        <?
                        if ($picture) { ?>
                            <img src="<?= $picture['url'] ?>"
                                 alt="<?= $picture['alt'] ?: $university->post_title ?>">
                            <?
                        } ?>
                    </div>
                    <p class="caption_2 bold"><?= $university->post_title ?></p>
                    <div class="remove"></div>
                    <input type="radio" class="hide" name="id"<?=$class?' checked':''?> value="<?=$university->ID?>">
                </label>
                <?
            } ?>
            <input type="hidden" name="action" value="filter_reviews_universities">
            <button class="btn_send button_black button_2 bold">Применить</button>
            <div class="erase_wrap">
                <a class="erase" href="<?=get_permalink()?>">
                    <div class="icon"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/close_black.svg" alt=""></div>
                    <p class="button_1 bold">сбросить</p>
                </a>
            </div>
        </form>
    </div>
    <?}?>
<?php
get_footer(); // footer.php ?>