<?
/*
Template Name: Оставить отзыв
*/

use TQ\WP\PostTypeHelper,
    TQ\WP\Review;

get_header(); // вставка header.php
$currentId = isset($_GET['id'])?$_GET['id']:0;
$review = new Review(isset($_GET['sort'])?$_GET['sort']:'');
$universities = PostTypeHelper::getElements('establishments', ['post_title' => 'asc']);
if($currentId){
    $arCurrentUniversity = array_filter($universities,function ($arItem) use($currentId){
        if($arItem->ID == $currentId){
            return true;
        }else{
            return false;
        }
    });
    if($arCurrentUniversity){
        $currentUniversity = reset($arCurrentUniversity);
    }
}
if(!isset($arCurrentUniversity) || !$arCurrentUniversity){
    status_header( 404 );
    nocache_headers();
    include( get_query_template( '404' ) );
    die();
}
?>
<?get_template_part('breadcrumbs')?>
    <section class="section block_leave_review">
        <div class="container">
            <p class="title_1 title" id="title"><?the_title()?></p>
            <p class="text_1 text"><?= get_the_content() ?></p>
            <div class="row">
                <div class="col col-12 col-md-12 col-lg-7 col-xl-8">
                    <form action="#" class="leave_review">
                        <?if(isset($currentUniversity) && $currentUniversity){
                            $picture = get_field('preview_picture', $currentUniversity->ID);?>
                        <div class="selected_university">
                            <div class="left">
                                <div class="image">
                                    <?
                                    if ($picture) { ?>
                                        <img src="<?= $picture['url'] ?>"
                                             alt="<?= $picture['alt'] ?: $currentUniversity->post_title ?>">
                                        <?
                                    } ?>
                                </div>
                                <p class="caption_2 name"><?=$currentUniversity->post_title?></p>
                            </div>
                            <div class="right">
                                <a data-fancybox data-src="#change_university" href="javascript:void(0);" class="change desc_1">Изменить</a>
                            </div>
                            <input type="hidden" class="university" name="university" value="<?=$currentId?>">
                        </div>
                        <?}else{?>
                            <div class="selected_university">
                                <div class="right">
                                    <a data-fancybox data-src="#change_university" href="javascript:void(0);" class="change desc_1">Выберите учебное заведение</a>
                                </div>
                            </div>
                        <?}?>
                        <label class="input_wrap">
                            <p class="caption_2 input_text">Как Вас зовут?</p>
                            <input type="text" class="input_item caption_1" name="name" placeholder="Иванов Иван">
                            <p class="caption_2 error_message">Поле не может быть пустым!</p>
                        </label>
                        <label class="input_wrap">
                            <p class="caption_2 input_text">Напишите свой отзыв:</p>
                            <textarea name="review" cols="30" rows="5" class="input_item caption_1" placeholder="Опишите Ваш опыт обучения, что понравилось, что было плохо"></textarea>
                            <p class="caption_2 error_message">Поле не может быть пустым!</p>
                        </label>
                        <p class="caption_2">Прикрепите свой социальный профиль:</p>
                        <div class="add_socials">
                            <div class="social_item">
                                <div class="item">
                                    <div class="left">
                                        <div class="image"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/social/vk.svg" alt=""></div>
                                        <p class="social_name caption_2">Вконтакте</p>
                                    </div>
                                    <a href="javascript:;" class="add_social button_1 bold add" data-add="подключить" data-remove="отключить">подключить</a>
                                </div>
                                <label class="input_wrap" style="display: none;">
                                    <input type="url" class="input_item caption_1" name="social[vkontakte]" placeholder="Введите ссылку">
                                </label>
                                <p class="caption_2 error_message">Поле заполнено некорректно!</p>
                            </div>
                            <div class="social_item">
                                <div class="item">
                                    <div class="left">
                                        <div class="image"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/social/facebook.svg" alt=""></div>
                                        <p class="social_name caption_2">Facebook</p>
                                    </div>
                                    <a href="javascript:;" class="add_social button_1 bold add" data-add="подключить" data-remove="отключить">подключить</a>
                                </div>
                                <label class="input_wrap" style="display: none;">
                                    <input type="url" class="input_item caption_1" name="social[facebook]" placeholder="Введите ссылку">
                                </label>
                                <p class="caption_2 error_message">Поле заполнено некорректно!</p>
                            </div>
                            <div class="social_item">
                                <div class="item">
                                    <div class="left">
                                        <div class="image"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/social/whatsapp.svg" alt=""></div>
                                        <p class="social_name caption_2">WhatsApp</p>
                                    </div>
                                    <a href="javascript:;" class="add_social button_1 bold add" data-add="подключить" data-remove="отключить">подключить</a>
                                </div>
                                <label class="input_wrap" style="display: none;">
                                    <input type="url" class="input_item caption_1" name="social[whatsapp]" placeholder="Введите ссылку">
                                </label>
                                <p class="caption_2 error_message">Поле заполнено некорректно!</p>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="leave_review">
                        <button class="button_black button_2 bold">Отправить отзыв</button>
                        <p class="desc_1 other">Нажимая кнопку “Задать вопрос”, Вы соглашаетесь с условиями обработки персональных данных</p>
                    </form>
                </div>
                <div class="col col-12 col-md-12 col-lg-5 col-xl-4"></div>
            </div>
        </div>
    </section>

<?if ($universities) { ?>
    <div class="change_university filter_reviews" id="change_university">
        <div class="input_wrap filter_search">
            <input type="text" class="input_item caption_1" placeholder="Поиск по учебным заведениям">
        </div>
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
        <p class="text_2" id="filter_none">Извините, такого учебного заведения не найдено</p>
    </div>
    <?}?>
    <div id="leave_review_success">
        <p class="title_2">Спасибо за Ваш отзыв!</p>
    </div>

<?php
get_footer(); // footer.php ?>