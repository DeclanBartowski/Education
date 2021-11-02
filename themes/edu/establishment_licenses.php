<?php
/**
 * @global $args
 * @global $post
 */
$arFields = $args['arFields'];
$isDpo = isset($args['dpo'])?$args['dpo']:false;
$licenseLink = get_theme_mod('tq_check_license');
$accreditationLink = get_theme_mod('tq_check_accreditation');
$trueLink = get_theme_mod('tq_check_true');
?>
<?if(isset($arFields['licenses']) && $arFields['licenses']){?>
<div class="education_diploms" id="education_licenses">
    <p class="title_3 title">Лицензии <?if(!$isDpo){?>и аккредитация<?}?> <?=isset($arFields['name_r_p']) && $arFields['name_r_p']?$arFields['name_r_p']:''?></p>
    <div class="buttons">
        <noindex>
            <?if($licenseLink){?>
            <a href="<?=$licenseLink?>" target="_blank" class="button_1 bold buton_rounded">проверить лицензии</a>
            <?}?>
            <?if(!$isDpo && $accreditationLink){?>
            <a href="<?=$accreditationLink?>" target="_blank" class="button_1 bold buton_rounded">проверить аккредитацию</a>
            <?}?>
            <?if($trueLink){?>
            <a href="<?=$trueLink?>" target="_blank" class="button_1 bold buton_rounded mobile">проверить достоверность</a>
            <?}?>
        </noindex>
    </div>
        <div class="row">
            <?foreach ($arFields['licenses'] as $picture){?>
                <div class="col col-6 col-xl-3">
                    <div class="image">
                        <a href="<?=$picture['url']?>" data-fancybox="license">
                            <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$post->post_title?>">
                        </a>
                    </div>
                </div>
            <?}?>
        </div>

</div>
<?}?>