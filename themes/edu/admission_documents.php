<?php
/**
 * @global $args
 */

use TQ\WP\PostTypeHelper;

$arFields = $args['arFields'];
if (!isset($arFields['documents']) || !$arFields['documents']) {
    $arPostDocuments = PostTypeHelper::getElements('admission_documents');
    if ($arPostDocuments) {
        foreach ($arPostDocuments as $item) {
            $arDocuments[] = [
                'name' => $item->post_title,
                'text' => $item->post_content,
            ];
        }
    }

} else {
    $arDocuments = $arFields['documents'];
}
?>
<? if (isset($arDocuments) && $arDocuments) { ?>
    <div class="education_descriptions" id="education_documents">
        <p class="title_3 title">Чек-лист документов <br>для поступления:</p>
        <div class="tab_items">
            <div class="row tab_item">
                <div class="item_wrap col col-12">
                    <div class="lined empty">
                        <div class="row aic">
                            <div class="col col-12  col-md-9">
                            </div>
                            <div class="col col-12 col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
                <? foreach ($arDocuments as $arDocument) { ?>
                    <div class="item_wrap col col-12">
                        <div class="lined">
                            <div class="row aic">
                                <div class="col col-12  col-md-9">
                                    <p class="text_1 list_item"><span
                                                class="bold"><?= $arDocument['name'] ?> — </span><?= $arDocument['text'] ?>
                                    </p>
                                </div>
                                <div class="col col-12 col-md-3">
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

            </div>
        </div>
        <p class="text_1 bold">Отправьте себе чек-лист:</p>
        <? get_template_part('social_buttons') ?>
    </div>
<? } ?>
