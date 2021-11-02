<?
/**
 * @var $post
 */
/*
Template Name: Проверить шансы по ЕГЭ
*/
use TQ\WP\Chances;
get_header(); // вставка header.php
$arSpecialties = Chances::getSpecialities();

?>
    <section class="section main block_chances">
        <div class="container">
            <p class="title title_1"><?=$post->post_title?></p>
            <?if($post->post_content){?>
            <p class="subtitle text_1"><?=$post->post_content?></p>
            <?}?>
        </div>
        <?if($arSpecialties){
            $count = 0;?>
        <div class="slider_directions_wrap">
            <div class="container">
                <div class="slider_directions">
                    <?while($count<5){?>
                    <?foreach ($arSpecialties as $specialty){
                        if(!isset($specialty->disciplines) || !$specialty->disciplines)continue;?>
                    <div class="item_wrap">
                        <div class="item"<?if($specialty->background){?> style="background-image: url(<?=$specialty->background?>);"<?}?>>
                            <p class="item_title caption_3 bold"><?=$specialty->post_title?></p>
                            <?if($specialty->min_price){?>
                            <ul class="list">
                                <li class="caption_1">от <?=number_format($specialty->min_price,'0',',',' ')?> ₽ семестр</li>
                            </ul>
                            <?}?>
                        </div>
                    </div>
                    <?$count++;
                    }?>
                    <?}?>

                </div>
            </div>
        </div>
        <div class="forms" id="forms">
            <div class="container">
                <?$count = 0;
                while($count<5){?>
                    <?foreach ($arSpecialties as $specialty){
                        if(!isset($specialty->disciplines) || !$specialty->disciplines)continue;?>
                        <form action="#" class="check_chances" data-form="<?=$count?>"<?if($count !=0){?> style="display: none" <?}?>>
                           <?if(isset($specialty->ID)){?>
                           <input type="hidden" name="speciality" value="<?=$specialty->ID?>">
                           <?}?>
                            <?foreach ($specialty->disciplines as $discipline){?>
                            <label class="form_wrap">
                                <p class="caption_4"><?=$discipline->post_title?></p>
                                <input type="text" class="form_item caption_2" name="discipline[<?=$discipline->ID?>]" placeholder="00">
                            </label>
                            <?}?>
                            <input type="hidden" name="action" value="check_chances">
                            <button class="button button_black button_2 bold">Проверить шансы</button>
                            <div class="clear_form">
                                <div class="clear_wrap">
                                    <a href="javascript:;" class="clear buton_rounded">
                                        <span class="image"><img src="<?=get_stylesheet_directory_uri()?>/assets/images/close_black.svg" alt=""></span>
                                        <span class="button_1 bold">сбросить</span>
                                    </a>
                                </div>
                            </div>
                            <div class="error_message_wrap">
                                <div class="error_message">
                                    <div class="error caption_2"></div>
                                </div>
                            </div>
                        </form>

                    <?$count++;
                    }?>
                <?}?>
            </div>
        </div>
        <?}?>
    </section>
<?php get_footer(); // footer.php ?>