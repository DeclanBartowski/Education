<?
/**
 * @var $post
 */
/*
Template Name: текстовая страница
*/
get_header(); // вставка header.php?>
<div class="main block_directions_2">
    <div class="container">
        <p class="title title_1" id="title"><?the_title()?></p>
        <p class="text text_1">
        <?the_content();?>
        </p>
    </div>
</div>
<?get_footer(); // footer.php ?>