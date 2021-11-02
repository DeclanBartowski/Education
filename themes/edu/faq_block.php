<?

use TQ\WP\PostTypeHelper;

$arItems = PostTypeHelper::getElements('faq', ['date' => 'desc']);

$post = get_page_by_path('/faq/');

?>
    <div class="faq">
        <? if ($post) { ?>
            <div class="title line">
                <p class="title_2">Вопрос-ответ:</p>
                <p class="text desc_1"><?= $post->post_content ?></p>
            </div>
        <? } ?>
        <? foreach ($arItems as $arItem) { ?>
            <div class="item line">
                <p class="text_2 faq_title"><?= $arItem->post_title ?><span class="union"></span></p>
                <p class="text_1 faq_desc" style="display: none;"><?= $arItem->post_content ?></p>
            </div>
        <? } ?>
    </div>
<? wp_reset_postdata(); ?>