<?

use \TQ\WP\Profession;
$arItems = Profession::getFilter();
?>
<form action="#" class="filter_profession">
    <?if(isset($arItems['terms']) && $arItems['terms']){?>
    <div class="group_category line">
        <p class="caption caption_2 bold">Категория профессии</p>
        <div class="group">
            <?foreach ($arItems['terms'] as $key=> $term){
                if($key == 5)break;?>
            <label class="custom_checkbox_2">
                <input type="checkbox" name="terms[]" value="<?=$term->term_id?>">
                <span class="caption_1"><?=$term->name?></span>
            </label>
            <?}?>
            <?if(count($arItems['terms'])>5){?>
                <div class="hidden_items" style="display: none;">
                    <?foreach ($arItems['terms'] as $key=> $item){
                        if($key < 5)continue;?>
                        <label class="custom_checkbox_2">
                            <input type="checkbox" name="terms[]" value="<?=$item->term_id?>">
                            <span class="caption_1"><?=$item->name?></span>
                        </label>
                    <?}?>
                </div>

                <p class="caption_1 bold btn_more show_items" data-show="Показать ещё" data-hide="Скрыть">
                    <span class="text">Показать ещё</span>
                    <span class="count"><?=count($arItems['terms'])-5?></span>
                </p>
            <?}?>
        </div>
    </div>
    <?}?>
    <?if(isset($arItems['specialties']) && $arItems['specialties']){?>
    <div class="group_direction line">
        <p class="caption caption_2 bold">Направление профессии</p>
        <div class="group">
            <?foreach ($arItems['specialties'] as $key=> $item){
                if($key == 5)break;?>
                <label class="custom_checkbox_2">
                    <input type="checkbox" name="specialties[]" value="<?=$item->ID?>">
                    <span class="caption_1"><?=$item->post_title?></span>
                </label>
            <?}?>
            <?if(count($arItems['specialties'])>5){?>
            <div class="hidden_items" style="display: none;">
                <?foreach ($arItems['specialties'] as $key=> $item){
                    if($key < 5)continue;?>
                    <label class="custom_checkbox_2">
                        <input type="checkbox" name="specialties[]" value="<?=$item->ID?>">
                        <span class="caption_1"><?=$item->post_title?></span>
                    </label>
                <?}?>
            </div>

            <p class="caption_1 bold btn_more show_items" data-show="Показать ещё" data-hide="Скрыть">
                <span class="text">Показать ещё</span>
                <span class="count"><?=count($arItems['specialties'])-5?></span>
            </p>
            <?}?>
        </div>
    </div>
    <?}?>
    <?if(isset($arItems['prices']) && $arItems['prices']){?>
    <div class="group_price line">
        <p class="caption caption_2 bold">Стоимость обучения *</p>
        <label class="ionRange">
            <p class="caption caption_1" data-base="<?=$arItems['prices']['min_formatted']?> ₽ — <?=$arItems['prices']['max_formatted']?> ₽"><?=$arItems['prices']['min_formatted']?> ₽ — <?=$arItems['prices']['max_formatted']?> ₽</p>
            <input type="text" class="range_slider" data-min="<?=$arItems['prices']['min']?>" data-max="<?=$arItems['prices']['max']?>" data-from="<?=$arItems['prices']['min']?>" data-to="<?=$arItems['prices']['max']?>" data-type="double" data-val="money" name="price">
        </label>
        <p class="desc desc_1">* Семестр — это 6 месяцев, полугодие</p>
    </div>
    <?}?>
    <?if(isset($arItems['wages']) && $arItems['wages']){?>
    <div class="group_salary line">
        <p class="caption caption_2 bold">Средняя заработная плата</p>
        <label class="ionRange">
            <p class="caption caption_1" data-base="<?=$arItems['wages']['min_formatted']?> ₽ — <?=$arItems['wages']['max_formatted']?> ₽"><?=$arItems['wages']['min_formatted']?> ₽ — <?=$arItems['wages']['max_formatted']?> ₽</p>
            <input type="text" class="range_slider" data-min="<?=$arItems['wages']['min']?>" data-max="<?=$arItems['wages']['max']?>" data-from="<?=$arItems['wages']['min']?>" data-to="<?=$arItems['wages']['max']?>" data-type="double" data-val="money" name="wage">
        </label>
    </div>
    <?}?>
</form>