<?

/*
Template Name: Как поступить
*/
get_header(); // вставка header.php
$page = get_post();
$picture = get_field('picture', $page->ID);
$background = get_field('background', $page->ID);
$arList = get_field('list', $page->ID);

?>
    <div class="block_direction how_to_proceed">
        <section class="container">
            <div class="row">
                <div class="item col col-12 col-xl-8 col-lg-7 col-md-12">
                    <div class="education floating"
                         style="background-image: url(<?= $background ?: get_stylesheet_directory_uri() . '/assets/images/backgrounds/25.jpg' ?>);">
                        <p class="title_1 title"><?= $page->post_content ?></p>
                        <div class="bottom_block row">
                            <div class="left_side col">
                                <div class="top">
                                </div>
                                <div class="bottom">
                                </div>
                            </div>
                            <?
                            if ($picture) { ?>
                                <div class="right_side col-auto">
                                    <div class="image">
                                        <img src="<?= $picture ?>" alt="<?= $page->post_title ?>">
                                    </div>
                                </div>
                                <?
                            } ?>
                        </div>
                    </div>
                    <?
                    if ($arList) { ?>
                        <div class="education_descriptions" id="education_documents">
                            <div class="tab_items">
                                <div class="row tab_item">
                                    <?
                                    foreach ($arList as $key => $arItem) { ?>
                                        <div class="item_wrap col col-12">
                                            <div class="lined">
                                                <p class="text_1 list_item"><span
                                                            class="bold">Шаг <?= $key + 1 ?>: </span><?= $arItem['text'] ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?
                                    } ?>
                                </div>
                            </div>
                            <p class="text_1 bold">Отправьте себе чек-лист:</p>
                            <?php
                            get_template_part('social_buttons') ?>
                        </div>
                    <?
                    } ?>
                </div>
                <div class="form item col col-12 col-xl-4 col-lg-5 col-md-12">
                    <?get_template_part('form_pick_education') ?>
                </div>
            </div>
        </section>
    </div>

<?php
get_footer(); // footer.php ?>