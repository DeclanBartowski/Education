<?

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{
    // Check function exists.
}

define('DEFAULT_AVATAR', 'https://avatars.dicebear.com/api/bottts/human.svg');
define('MAIN_PAGE', 87);
define('REVIEW_ADD_ID', 131);
define('SPECIALITY_PAGE', 227);
define('POLITIC_PAGE', 2);
define('PARTNERS_PAGE', 284);
define('CHECK_PAGE', 318);
define('CHECK_RESULT_ID', 351);
define('SEND_DOCS_SELECT', 356);
define('SEND_DOCS_FORM', 359);

require_once('libs/PostTypeHelper.php');
require_once('libs/Breadcrumbs.php');
require_once('libs/Review.php');
require_once('libs/Establishments.php');
require_once('libs/Speciality.php');
require_once('libs/Profession.php');
require_once('libs/Chances.php');
require_once('libs/Soc.php');
require_once ('libs/register-ads-post-tax.php');
require_once ('cody-framework/admin.php');
use TQ\WP\Speciality,
    TQ\WP\PostTypeHelper;

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
if (!function_exists('dd')) {
    /**
     * @param $data
     */
    function dump($data)
    {
        ini_set("highlight.comment", "#969896; font-style: italic");
        ini_set("highlight.default", "#FFFFFF");
        ini_set("highlight.html", "#D16568");
        ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
        ini_set("highlight.string", "#F2C47E");
        $output = highlight_string("<?php\n\n" . var_export($data, true), true);
        echo "<div style=\"background-color: #1C1E21; padding: 1rem\">{$output}</div>";
    }
}
/**
 * @param $phone
 * @return string|string[]|null
 */
function normalizePhone($phone)
{
    return preg_replace('/[^,|0-9]/', '', $phone);
}

/**
 * @param $number
 * @param $titles
 * @param boolean $showNumber
 * @param boolean $numberFormat
 * @return string
 */
function declOfNum($number, $titles, $showNumber = true,$numberFormat = false)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    if ($showNumber) {
        $returnNumber = $number;
        if($numberFormat){
            $returnNumber = number_format($number,'0',',',' ');
        }
        return $returnNumber . " " . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    } else {
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}

/**
 * @param array $args {
 * @type int $total Max paginate page.
 * @type int $current Current page.
 * @type string $url_base URL pattern. Use {page_num} placeholder.
 * }
 *
 * @return array
 */
function kama_paginate_links_data($args)
{
    global $wp_query;

    $args = wp_parse_args($args, [
        'total' => $wp_query->max_num_pages ?? 1,
        'current' => null,
        'url_base' => '', //
    ]);

    if (null === $args['current']) {
        $args['current'] = max(1, get_query_var('paged', 1));
    }

    if (!$args['url_base']) {
        $args['url_base'] = str_replace(PHP_INT_MAX, '{page_num}', get_pagenum_link(PHP_INT_MAX));
    }

    $pages = range(1, max(1, (int)$args['total']));

    foreach ($pages as & $page) {
        $page = (object)[
            'is_current' => $page == $args['current'],
            'page_num' => $page,
            'url' => str_replace('{page_num}', $page, $args['url_base']),
        ];
    }
    unset($page);

    return $pages;
}

function checkHeaderParams(&$category,&$isTwoRows,&$arLinks,&$showPostInfo,&$class,&$logo){

    if(isset($category->post_type)){
        switch ($category->post_type){
            case 'specialties':
                if(isset($wp->query_vars['establishments_name'])){
                    $class = 'header header_another header_2';
                    $logo = get_field('picture',$category->ID);
                    $establishments = \TQ\WP\PostTypeHelper::getElements('establishments',['ID'=>'asc'],['name'=>$wp->query_vars['establishments_name']],1);
                    if($establishments){
                        $description = reset($establishments)->post_title;
                    }

                    $showPostInfo = true;
                    $isTwoRows = true;
                    $arLinks = [
                        [
                            'name'=>'Программы',
                            'link'=>'#education_programs'
                        ],
                        [
                            'name'=>'Детали обучения',
                            'link'=>'#education_details'
                        ],
                        [
                            'name'=>'Диплом',
                            'link'=>'#education_diploms'
                        ],
                        [
                            'name'=>'Что вы будете изучать',
                            'link'=>'#education_descriptions'
                        ],
                        [
                            'name'=>'Лицензии',
                            'link'=>'#education_licenses'
                        ],
                        [
                            'name'=>'Документы',
                            'link'=>'#education_documents'
                        ],
                        [
                            'name'=>'Профессии',
                            'link'=>'#education_professions'
                        ],
                    ];
                }else{
                    $class = 'header header_another header_2';
                    $logo = get_field('picture',$category->ID);
                    $showPostInfo = true;
                    $arCategories = get_the_terms($category->ID, 'typespecialties');
                    if ($arCategories) {
                        $category = reset($arCategories);
                        if($category->parent)
                            $category = get_term($category->parent);
                    }
                    if($category->slug == 'dpo'){
                        $isTwoRows = true;
                        $arLinks = [
                            [
                                'name'=>'Программы',
                                'link'=>'#education_programs'
                            ],
                            [
                                'name'=>'Диплом',
                                'link'=>'#education_diploms'
                            ],
                            [
                                'name'=>'Отзывы',
                                'link'=>'#block_reviews'
                            ],
                        ];
                    }else{
                        $arLinks = [
                            [
                                'name'=>'Учебные заведения',
                                'link'=>'#education_choose'
                            ],
                            [
                                'name'=>'Диплом',
                                'link'=>'#education_diploms'
                            ],
                            [
                                'name'=>'Профессии',
                                'link'=>'#education_professions'
                            ],
                        ];
                    }
                }
                break;
            case 'establishments':
                $class = 'header header_another header_2';
                $logo = get_field('preview_picture',$category->ID);
                $showPostInfo = true;
                $isTwoRows = true;
                $arLinks = [
                    [
                        'name'=>'Направления',
                        'link'=>'#education_programs'
                    ],
                    [
                        'name'=>'Диплом',
                        'link'=>'#education_diploms'
                    ],
                    [
                        'name'=>'Документы',
                        'link'=>'#education_documents'
                    ],
                    [
                        'name'=>'Лицензии',
                        'link'=>'#education_licenses'
                    ],
                    [
                        'name'=>'Отзывы',
                        'link'=>'#block_reviews'
                    ],
                ];

                break;
            default:
                $class = 'header';
                $showPostInfo = false;
                break;
        }


    }else{
        $class = 'header';
        $showPostInfo = false;
    }
}


/*add_filter('acf/fields/post_object/query/key=field_615af7cfddbf0', 'my_acf_fields_post_object_query', 10, 4);
function my_acf_fields_post_object_query( $args, $field, $post_id ) {

    $args['post__in'] = [43];
        dump($field);
        die();
        return $args;

}*/


add_action( 'customize_register', 'my_theme_customize_register' );
function my_theme_customize_register( WP_Customize_Manager $wp_customize ) {
    $panelId = 'tq_site_settings';
    $wp_customize->add_panel($panelId,[
        'title'=>'Настройки сайта',
        'priority'     => 10,
    ]);
    $wp_customize->add_section(
        'general',       // id секции
        array(
            'title'       => 'Общие настройки',
            'priority'    => 10,
            'panel'       => $panelId  // id родительской панели
        )
    );
    $wp_customize->add_section(
        'soc',       // id секции
        array(
            'title'       => 'Социальные сети',
            'description'=> 'В title необходимо устанавливать значение с сайта https://www.addtoany.com для работы функционала «Поделиться»',
            'priority'    => 20,
            'panel'       => $panelId  // id родительской панели
        )
    );
    $wp_customize->add_setting( 'tq_site_logo_header' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_site_logo_2_header' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_site_logo_footer' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_phone' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_schedule' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_check_license' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_check_accreditation' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_check_true' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_check_license' , array(
        'default'         => '',
    ));
    $wp_customize->add_setting( 'tq_soc' , array(
        'default'         => '',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'tq_site_logo_header_control', array(
        'label'      => 'Лого сайта в шапке',
        'section'    => 'general',
        'settings'   => 'tq_site_logo_header',
    ) ));
    $wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'tq_site_logo_2_header_control', array(
        'label'      => 'Лого 2 сайта в шапке',
        'section'    => 'general',
        'settings'   => 'tq_site_logo_2_header',
    ) ));

    $wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'tq_site_logo_footer_control', array(
        'label'      => 'Лого в футере',
        'section'    => 'general',
        'settings'   => 'tq_site_logo_footer',
    ) ));


    $wp_customize->add_control('tq_phone_control',[
        'label'      => 'Номер телефона',
        'section'    => 'general',
        'settings'   => 'tq_phone',
    ]);
    $wp_customize->add_control('tq_schedule_control',[
        'label'      => 'Время работы',
        'section'    => 'general',
        'settings'   => 'tq_schedule',
    ]);
    $wp_customize->add_control('tq_check_license_control',[
        'label'      => 'Ссылка на проверку лицензии',
        'section'    => 'general',
        'settings'   => 'tq_check_license',
        'type'=>'url'
    ]);
    $wp_customize->add_control('tq_check_accreditation_control',[
        'label'      => 'Ссылка на проверку аккредитации',
        'section'    => 'general',
        'settings'   => 'tq_check_accreditation',
        'type'=>'url'
    ]);
    $wp_customize->add_control('tq_check_true_control',[
        'label'      => 'Ссылка на проверку достоверности',
        'section'    => 'general',
        'settings'   => 'tq_check_true',
        'type'=>'url'
    ]);

    $wp_customize->add_control(new CF_Slider_Control(
        $wp_customize, 'socs', array(
            'label'       => 'Социальные сети',
            'settings'    => 'tq_soc',
            'section'     => 'soc',
            'img'         => true,
            'link'        => true,
            'title'       => true,
            'desc'        => false,
            'check'       => false,
        )
    ));


}
add_action('acf/save_post', 'calculateFields', 10, 1);
function calculateFields($postId)
{
    $post = get_post($postId);
    if ($post && $post->post_type == 'establishments') {
        $arItems = PostTypeHelper::getElements('establishments');
        if ($arItems) {
            foreach ($arItems as $item) {
                $arSpecs = get_field('specs', $item->ID);
                if($arSpecs){
                    $arPrices = array_column($arSpecs,'price');
                    $arPeriods = array_column($arSpecs,'period');
                    if($arPrices){
                        update_post_meta($item->ID, 'min_price', min($arPrices));
                    }else{
                        update_post_meta($item->ID, 'min_price', false);
                    }
                    if($arPeriods){
                        update_post_meta($item->ID, 'min_period', min($arPeriods));
                    }else{
                        update_post_meta($item->ID, 'min_period', false);
                    }
                    if ($arSpecs) {
                        foreach ($arSpecs as $arSpec) {
                            $arSpecsParams[$arSpec['item']->ID]['price'][] = str_replace(',', '.', $arSpec['price']);
                            $arSpecsParams[$arSpec['item']->ID]['period'][] = str_replace(',', '.', $arSpec['period']);
                        }
                    }
                }

            }
        }

        $arSpecials = PostTypeHelper::getElements('specialties', ['ID' => 'asc']);
        $arTermsMin = [];
        if ($arSpecials) {
            foreach ($arSpecials as $special) {
                $arTaxes = get_the_terms($special->ID,'typespecialties');
                if (isset($arSpecsParams[$special->ID])) {
                    if (isset($arSpecsParams[$special->ID]['price']) && $arSpecsParams[$special->ID]['price']) {
                        update_post_meta($special->ID, 'min_price', min($arSpecsParams[$special->ID]['price']));
                        foreach ($arTaxes as $term){
                            $arTermsMin[$term->term_id]['min_price'][] = min($arSpecsParams[$special->ID]['price']);
                        }

                    }
                    if (isset($arSpecsParams[$special->ID]['period']) && $arSpecsParams[$special->ID]['period']) {
                        update_post_meta($special->ID, 'min_period', min($arSpecsParams[$special->ID]['period']));
                        foreach ($arTaxes as $term){
                            $arTermsMin[$term->term_id]['min_period'][] = min($arSpecsParams[$special->ID]['period']);
                        }
                    }
                } else {
                    update_post_meta($special->ID, 'min_price', false);
                    update_post_meta($special->ID, 'min_period', false);
                }

            }
        }
        $arItems = get_terms([
            'taxonomy' => 'typespecialties',
            'hierarchical' => true,
        ]);
        if($arItems){
            foreach ($arItems as $term){
                if(isset($arTermsMin[$term->term_id]['min_price'])){
                    update_term_meta($term->term_id, 'min_price', min($arTermsMin[$term->term_id]['min_price']));
                }else{
                    update_term_meta($term->term_id, 'min_price', false);
                }
                if(isset($arTermsMin[$term->term_id]['min_period'])){
                    update_term_meta($term->term_id, 'min_period', min($arTermsMin[$term->term_id]['min_period']));
                }else{
                    update_term_meta($term->term_id, 'min_period', false);
                }
            }
        }

    }
}


add_filter('excerpt_length', function () {
    return 4;
});
add_filter('excerpt_more', function ($more) {
    return '...';
});
function acf_wysiwyg_remove_wpautop() {
    remove_filter('acf_the_content', 'wpautop' );
}

add_action('acf/init', 'acf_wysiwyg_remove_wpautop');

add_filter('post_gallery', 'my_gallery_output', 10, 2);
function my_gallery_output($output, $attr)
{
    $ids_arr = explode(',', $attr['ids']);
    $ids_arr = array_map('trim', $ids_arr);

    $pictures = get_posts(array(
        'posts_per_page' => -1,
        'post__in' => $ids_arr,
        'post_type' => 'attachment',
        'orderby' => 'post__in',
    ));
    $mainSlider = '';
    $smallSlider = '';

    if ($pictures) {
        // Вывод
        $mainSlider = '<div class="slider_article">';
        $smallSlider = '<div class="slider_article_nav">';

        // Выводим каждую картинку из галереи
        foreach ($pictures as $pic) {
            if ($pic->post_excerpt) {
                $exerpt = sprintf('<p class="source desc_1">%s</p>', $pic->post_excerpt);
            } else {
                $exerpt = '';
            }
            $mainSlider .= sprintf('<div>
								<div class="image"><img src="%s" alt="%s"></div>
								%s
							</div>', $pic->guid, esc_attr($pic->post_title), $exerpt);
            $smallSlider .= sprintf('<div class="slider_article_item">
								<div class="image"><img src="%s" alt="%s"></div>
							</div>', $pic->guid, esc_attr($pic->post_title));
        }
        $mainSlider .= '</div>';
        $smallSlider .= '</div>';
    }
    return sprintf('%s%s', $mainSlider, $smallSlider);
}

add_shortcode('form_pick_education', 'form_pick_education_shortcode');
add_shortcode('partners_slider', 'partners_slider_shortcode');
add_shortcode('sklonenia', 'sklonenia_shortcode');

function form_pick_education_shortcode($atts)
{
    ob_start();
    get_template_part('form_pick_education', null, ['short' => true]);
    return ob_get_clean();
}
function partners_slider_shortcode($atts)
{
    ob_start();
    get_template_part('partners_block');
    return ob_get_clean();
}
function sklonenia_shortcode($atts)
{

    return declOfNum($atts['number'],explode(',',$atts['words']),$atts['with_number'] == 'true'??false,$atts['number_format']=='true'??false);
}

function js_variables()
{
    $variables = array(
        'ajax_url' => admin_url('admin-ajax.php'),
    );
    echo(
        '<script type="text/javascript">window.wp_data = ' .
        json_encode($variables) .
        ';</script>'
    );
}
function title_filter( $where, &$wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
    }
    return $where;
}
add_action( 'wpcf7_before_send_mail', 'action_function_name_8481', 10, 3 );
function action_function_name_8481( $contact_form, &$abort, $that ){
    $formId = $contact_form->id();

    if($formId == 363){
        $mail = $contact_form->prop( 'mail' );

        $mail['attachments'] = str_replace(['[docs]','[diploma]','[parent_docs]'],[$_POST['docs'],$_POST['diploma'],$_POST['parent_docs']],$mail['attachments']);
        $contact_form->set_properties( array( 'mail' => $mail ) );
    }

}
add_action('wp_head', 'js_variables');

add_action('wp_ajax_leave_review', ['TQ\WP\Review', 'addReview']);
add_action('wp_ajax_nopriv_leave_review', ['TQ\WP\Review', 'addReview']);

add_action('wp_ajax_search_spec', ['TQ\WP\Speciality', 'search']);
add_action('wp_ajax_nopriv_search_spec', ['TQ\WP\Speciality', 'search']);

add_action('wp_ajax_filter_directions', ['TQ\WP\Speciality', 'getFilterResult']);
add_action('wp_ajax_nopriv_filter_directions', ['TQ\WP\Speciality', 'getFilterResult']);

add_action('wp_ajax_filter_prof', ['TQ\WP\Profession', 'getFilterResult']);
add_action('wp_ajax_nopriv_filter_prof', ['TQ\WP\Profession', 'getFilterResult']);

add_action('wp_ajax_filter_directions', ['TQ\WP\Speciality', 'getFilterResult']);
add_action('wp_ajax_nopriv_filter_directions', ['TQ\WP\Speciality', 'getFilterResult']);

add_action('wp_ajax_check_chances', ['TQ\WP\Chances', 'checkChances']);
add_action('wp_ajax_nopriv_check_chances', ['TQ\WP\Chances', 'checkChances']);

add_action('wp_ajax_save_file', ['TQ\WP\Chances', 'saveFile']);
add_action('wp_ajax_nopriv_save_file', ['TQ\WP\Chances', 'saveFile']);