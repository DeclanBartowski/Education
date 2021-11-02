<?php wp_footer();
/**
 * @global $pagename
 */
use TQ\WP\Soc;
$page = get_page_by_path(get_page_uri());
$arMenu = wp_get_nav_menu_items(21);

$arBlocks = [];
if($page){
    $arBlocks['FAQ'] = get_field('show_faq', $page->ID);
    $arBlocks['MORE_QUESTIONS'] = get_field('show_more_questions', $page->ID);
}
$needPadding = true;
$footerLogo = get_theme_mod('tq_site_logo_footer');
$phone = get_theme_mod('tq_phone');
$schedule = get_theme_mod('tq_schedule');
$socClass = Soc::getInstance();
$soc = $socClass->getSoc();
?>
<?if((isset($arBlocks['FAQ']) && $arBlocks['FAQ']) || isset($arBlocks['MORE_QUESTIONS']) && $arBlocks['MORE_QUESTIONS']){
    $needPadding = false;?>
<section class="block_questions">
    <div class="container">
<?if(isset($arBlocks['FAQ']) && $arBlocks['FAQ']){?>
    <?get_template_part('faq_block')?>
<?}?>
<?if(isset($arBlocks['MORE_QUESTIONS']) && $arBlocks['MORE_QUESTIONS'] ){?>
    <?get_template_part('footer_question_block')?>
<?}?>
    </div>
</section>
<?}?>
<footer class="footer <?=$needPadding?'padding':''?>">
    <div class="container">
        <div class="row">
            <div class="col col-12 col-sm-6 col-lg-3">
                <a href="/" class="footer_logo">
                    <?if($footerLogo){?>
                    <img src="<?=$footerLogo?>" alt="<?bloginfo()?>">
                    <?}?>
                </a>
                <p class="desc desc_1"><?bloginfo('description')?></p>
                <a href="<?=get_permalink(POLITIC_PAGE)?>" class="policy desc_1">Политика конфиденциальности</a>
            </div>
            <div class="col col-12 col-md-12 col-lg-6 footer_menu_wrap">
                <?if($arMenu){?>
                <ul class="footer_menu">
                    <?foreach ($arMenu as $item){?>
                        <li><a href="<?=$item->url?>"<?=$item->target?sprintf(' target="%s"',$item->target):''?><?=$item->attr_title?sprintf(' alt="%s"',$item->attr_title):''?> class="link caption_2"><?=$item->title?></a></li>
                    <?}?>
                </ul>
                <?}?>
                <a href="<?=get_permalink(POLITIC_PAGE)?>" class="policy second desc_1">Политика конфиденциальности</a>
            </div>
            <div class="col col-12 col-sm-6 col-lg-3">
                <?if($phone){?>
                <a href="tel:<?=normalizePhone($phone)?>" class="phone caption_2"><?=$phone?></a>
                <?}?>
                <?if($schedule){?>
                <p class="work desc_1">Рабочее время: <br><?=$schedule?></p>
                <?}?>
                <?if($soc){?>
                    <div class="footer_social">
                        <?foreach ($soc as $item){?>
                            <a href="<?=$item['url']?>" class="social_link" target="_blank">
                                <img src="<?=$item['img']?>" alt="<?=$item['title']?>">
                            </a>
                        <?}?>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
</footer>
<?if(isset($page->ID) && $page->ID != PARTNERS_PAGE){?>
<div class="selection_wrap">
    <div class="container">
        <a href="<?=get_permalink(CHECK_PAGE)?>" class="selection">
            <p class="caption_4">Подобрать обучение</p>
            <span class="point"></span>
        </a>
    </div>
</div>
<?}?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- <script src="<?=get_stylesheet_directory_uri()?>/assets/libs/jquery-ui/jquery-ui.min.js"></script> -->
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/slick/slick.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/fancybox/jquery.fancybox.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/jquery-ui-1.12.1.autocomplete/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/jQueryFormStyler/dist/jquery.formstyler.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/inputMask/jquery.inputmask-multi.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/inputMask/jquery.inputmask.bundle.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/mixitup-3/dist/mixitup.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/libs/plupload-3.1.3/js/plupload.full.min.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/js/main.js"></script>
<script src="<?=get_stylesheet_directory_uri()?>/assets/js/costume.js"></script>
<script type="text/javascript">

    jQuery(document).ready(function($){
        if($('.mixitup').length>0){
            var mixer = mixitup('.mixitup');
        }

    });
</script>
</body>
</html>