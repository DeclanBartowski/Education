<?
/**
 * @var $post
 */
/*
Template Name: Подать документы
*/
get_header(); // вставка header.php
?>

    <section class="section main block_selectUniversity">
        <div class="container">
            <p class="page_title title_1"><?=$post->post_title?></p>
            <p class="text text_1"><?=$post->post_content?></p>
            <p class="title title_3">Чтобы начать — выберите <br>учебное заведение</p>
            <?get_template_part('universities_list',null,['link'=>get_permalink(SEND_DOCS_FORM)])?>
        </div>
    </section>
<?php get_footer(); // footer.php ?>