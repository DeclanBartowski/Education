<?
/**
 * @global $category
 */

use TQ\WP\Soc;

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title(); ?></title>
    <?php wp_head() ?>
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/libs/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/libs/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/libs/slick/slick.css">
    <link rel="stylesheet"
          href="<?= get_stylesheet_directory_uri() ?>/assets/libs/bootstrap-4.1.3/css/bootstrap-grid.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/libs/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet"
          href="<?= get_stylesheet_directory_uri() ?>/assets/libs/jquery-ui-1.12.1.autocomplete/jquery-ui.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css">
    <link rel="stylesheet"
          href="<?= get_stylesheet_directory_uri() ?>/assets/libs/jQueryFormStyler/dist/jquery.formstyler.theme.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/styles/typography.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/styles/main.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/styles/costume.css">
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/styles/media.css">
</head>

<body>
<?
$category = get_queried_object();
$isTwoRows = false;
$class = false;
$showPostInfo = false;
$logo = false;
$arLinks = [];
checkHeaderParams($category, $isTwoRows, $arLinks, $showPostInfo, $class, $logo);
$headerLogo = get_theme_mod('tq_site_logo_header');
$secondHeaderLogo = get_theme_mod('tq_site_logo_2_header');
$phone = get_theme_mod('tq_phone');
$schedule = get_theme_mod('tq_schedule');
$socClass = Soc::getInstance();
$soc = $socClass->getSoc();
?>
<header class="<?= $class ?>">
    <div class="container">
        <div class="top_line">
            <div class="left_side">
                <a href="javascript:;" class="menu_mobile">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <a href="/" class="logo">
                    <? if ($headerLogo) { ?>
                        <img src="<?= $headerLogo ?>" alt="<? bloginfo() ?>" class="logo_1">
                    <? } ?>
                    <? if ($secondHeaderLogo) { ?>
                        <img src="<?= $secondHeaderLogo ?>" alt="<? bloginfo() ?>" class="logo_2">
                    <? } ?>
                </a>
            </div>
            <div class="right_side">
                <? if ($soc) { ?>
                    <div class="social">
                        <? foreach ($soc as $item) { ?>
                            <a href="<?= $item['url'] ?>" class="social_link" target="_blank">
                                <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>">
                            </a>
                        <? } ?>
                    </div>
                <? } ?>
                <? if ($phone) { ?>
                    <div class="contact">
                        <a href="tel:<?= normalizePhone($phone) ?>" class="phone">
                            <span class="caption_2"><?= $phone ?></span>
                            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/phone.svg" alt="">
                        </a>
                    </div>
                <? } ?>
                <div class="get_document">
                    <a href="<?= get_permalink(SEND_DOCS_SELECT) ?>" class="button button_1">подать документы</a>
                </div>
            </div>
        </div>
        <? if ($showPostInfo) { ?>
            <? if ($isTwoRows) { ?>
                <div class="current_direction modify">
                    <div class="left_side">
                        <a href="javascript:;" class="menu_mobile">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                        <?
                        if (isset($logo) && $logo) { ?>
                            <div class="page_logo"><img src="<?= $logo['url'] ?>"
                                                        alt="<?= $logo['alt'] ?: $category->post_title ?>"></div>

                            <?
                        } ?>
                    </div>
                    <div class="spec_header">
                        <div class="">
                            <div class="page_details">
                                <div class="page_desc">
                                    <? if (isset($description) && $description) { ?>
                                        <p class="desc_1 desc"><?= $description ?></p>
                                    <? } ?>
                                    <p class="page_title caption_3 bold"><?= $category->post_title ?></p>
                                </div>
                            </div>
                            <? if ($arLinks) { ?>
                                <div class="links hide_xl">
                                    <? foreach ($arLinks as $link) { ?>
                                        <a href="<?= $link['link'] ?>" class="caption_1"><?= $link['name'] ?></a>
                                    <? } ?>
                                </div>
                            <? } ?>
                        </div>
                        <div class="">
                            <div class="get_document">
                                <a data-fancybox data-src="#get_consultation" href="javascript:;"
                                   class="button button_1">подать документы</a>
                            </div>
                        </div>
                    </div>
                    <? if ($arLinks) { ?>
                        <div class="bottom_side">
                            <div class="links">
                                <? foreach ($arLinks as $link) { ?>
                                    <a href="<?= $link['link'] ?>" class="caption_1"><?= $link['name'] ?></a>
                                <? } ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <? if ($arLinks) { ?>
                    <div class="sub_links">
                        <div class="links">
                            <? foreach ($arLinks as $link) { ?>
                                <a href="<?= $link['link'] ?>" class="caption_1"><?= $link['name'] ?></a>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>
            <? } else { ?>
                <div class="current_direction">
                    <div class="left_side">
                        <a href="javascript:;" class="menu_mobile">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                        <?
                        if (isset($logo) && $logo) { ?>
                            <div class="page_logo"><img src="<?= $logo['url'] ?>"
                                                        alt="<?= $logo['alt'] ?: $category->post_title ?>"></div>

                            <?
                        } ?>

                        <p class="page_title caption_3 bold"><?= $category->post_title ?></p>
                        <? if ($arLinks) { ?>
                            <div class="links hide_xl">
                                <? foreach ($arLinks as $link) { ?>
                                    <a href="<?= $link['link'] ?>" class="caption_1"><?= $link['name'] ?></a>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>
                    <div class="right_side">
                        <div class="get_document">
                            <a data-fancybox data-src="#get_consultation" href="javascript:;" class="button button_1">подать
                                документы</a>
                        </div>
                    </div>
                </div>
                <? if ($arLinks) { ?>
                    <div class="sub_links">
                        <div class="links">
                            <? foreach ($arLinks as $link) { ?>
                                <a href="<?= $link['link'] ?>" class="caption_1"><?= $link['name'] ?></a>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
        <? } ?>
        <?
        $arMenu = wp_get_nav_menu_items(20);
        ?>
        <nav class="navigation_wrap">
            <ul class="navigation" id="main_menu" style="display: none;">
                <? foreach ($arMenu as $item) { ?>
                    <li class="menu_item"><a href="<?= $item->url ?>"<?= $item->target ? sprintf(' target="%s"',
                            $item->target) : '' ?><?= $item->attr_title ? sprintf(' alt="%s"',
                            $item->attr_title) : '' ?> class="link caption_2"><?= $item->title ?></a></li>
                <? } ?>
            </ul>
            <ul class="navigation" id="navigation">
                <li class="has_submenu"><a href="javascript:;" class="link caption_2">Ещё</a>
                    <p class="submenu_wrap">
                    <ul class="submenu"></ul>
                    </p></li>
            </ul>
        </nav>
    </div>
</header>
<div class="menu_mobile_wrap">
    <div class="container">
        <ul class="menu_mobile_navigation">
            <? foreach ($arMenu as $item) { ?>
                <li><a href="<?= $item->url ?>"<?= $item->target ? sprintf(' target="%s"',
                        $item->target) : '' ?><?= $item->attr_title ? sprintf(' alt="%s"', $item->attr_title) : '' ?>
                       class="link caption_4"><?= $item->title ?></a></li>
            <? } ?>
        </ul>
        <div class="menu_mobile_contacts">
            <? if ($phone) { ?>
                <a href="tel:<?= normalizePhone($phone) ?>" class="phone caption_4"><?= $phone ?></a>
            <? } ?>
            <? if ($schedule) { ?>
                <p class="desc_1">Рабочее время: <?= $schedule ?></p>
            <? } ?>
        </div>
        <? if ($soc) { ?>
            <div class="social_double">
                <? foreach ($soc as $item) { ?>
                    <a href="<?= $item['url'] ?>" class="social_link" target="_blank">
                        <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>">
                    </a>
                <? } ?>
            </div>
        <? } ?>
        <a data-fancybox data-src="#get_consultation" href="javascript:;" class="get button button_2">Подать
            документы</a>
        <a href="<?= get_permalink(POLITIC_PAGE) ?>" class="policy desc_1">Политика конфиденциальности</a>
    </div>
</div>
<?= do_shortcode('[contact-form-7 id="354" html_id="get_consultation" title="Получить консультацию"]') ?>

<div id="get_consultation_success">
    <div class="get_consultation_inner">
        <p class="title title_3">Заявка на консультацию принята</p>
        <p class="text text_1">Сотрудник приёмной комиссии свяжется с Вами в ближайшее рабочее время.</p>
        <button class="button button_black button_2">Буду ждать</button>
        <? if ($schedule) { ?>
            <p class="desc desc_1">Мы работаем: <br><?= $schedule ?></p>
        <? } ?>
        <? if ($phone) { ?>
            <a href="tel:<?= normalizePhone($phone) ?>" class="phone caption_5 bold"><?= $phone ?></a>
        <? } ?>
    </div>
</div>