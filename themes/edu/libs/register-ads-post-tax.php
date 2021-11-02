<?php

add_action('init', 'estate_type_register');
function estate_type_register()
{
    add_filter('term_link', 'deal_realty_tax_link_fix', 10, 3);
    function deal_realty_tax_link_fix($link, $term, $taxonomy)
    {
        if (!in_array($taxonomy, array('typespecialties'))) {
            return $link;
        }
        if ($taxonomy == 'typespecialties') {
            $link = str_replace('/typespecialties/', '/specialnosti/', $link);
        }

        return esc_url(user_trailingslashit($link));
    }

    add_permastruct('specialties', '/specialnosti/%typespecialties%/%post_name%', array(
        'with_front' => 0,
        'paged' => 0,
        'feed' => 0,
        'walk_dirs' => 0,
    ));
    add_permastruct('establishments', '/%typesestablishments%/%post_name%', array(
        'with_front' => 0,
        'paged' => 0,
        'feed' => 0,
        'walk_dirs' => 0,
    ));


    add_filter( 'query_vars', function( $vars ){
        $vars[] = 'tax';
        $vars[] = 'establishments_name';
        $vars[] = 'spec_name';

        return $vars;
    } );

    add_filter('specialties' . '_rewrite_rules', 'delete_realty_rewrite_rules');
    function delete_realty_rewrite_rules($rules)
    {
        $rules = [];
        $_first_part = 'specialnosti/(' . implode('|', __type_deal_elements('typespecialties')) . ')';
        $arLinks = __type_deal_elements('typespecialties');
        if($arLinks){
            foreach ($arLinks as $link){
                $arExp = explode('/',$link);
                $rules[sprintf('specialnosti/%s$',$link)] = 'index.php?taxonomy=typespecialties&typespecialties='.end($arExp);
            }
        }

        /*$rules = array(
            $_first_part.'$' =>'index.php?taxonomy=typespecialties&full_tax=$matches[1]',
            $_first_part.'/(.+)' => 'index.php?post_type=specialties&tax=$matches[1]&name=$matches[2]',

        );*/
        $rules[$_first_part.'/(.+)'] = 'index.php?post_type=specialties&tax=$matches[1]&name=$matches[2]';

        $_first_part = '(' . implode('|', __type_deal_elements('typesestablishments')) . ')';
        $rules[$_first_part.'/(.+)/(.+)/(.+)'] = 'index.php?post_type=profiles&tax=$matches[1]&establishments_name=$matches[2]&spec_name=$matches[3]&name=$matches[4]';
        $rules[$_first_part.'/(.+)/(.+)'] = 'index.php?post_type=specialties&tax=$matches[1]&establishments_name=$matches[2]&name=$matches[3]';
        $rules[$_first_part.'/(.+)'] = 'index.php?post_type=establishments&tax=$matches[1]&name=$matches[2]';
        return $rules;
    }

    function __type_deal_elements($tax)
    {
        $deal_terms = [];
        $arTerms = get_terms(array('taxonomy' => $tax, 'hide_empty' => 0, 'parent'=>0));
        if($arTerms){
            foreach ($arTerms as $term){
                $deal_terms[] = $term->slug;
                if($term->slug == 'dpo'){
                    $arItems = get_terms([
                        'taxonomy' => $tax,
                        'hide_empty' => false,
                        'pad_counts' => true,
                        'count' => false,
                        'parent' => $term->term_id,
                        'hierarchical' => true,
                        'fields'=>'id=>slug'
                    ]);
                    if($arItems){
                        foreach ($arItems as $item){
                            $deal_terms[] = sprintf('%s/%s',$term->slug,$item);
                        }
                    }
                }
            }
        }
        return array_reverse($deal_terms);
    }


    ## Отфильтруем ЧПУ произвольного типа
    add_filter('post_type_link', 'realty_permalink', 1, 2);
    function realty_permalink($permalink, $post)
    {
        if (false !== strpos($permalink, '%typespecialties%')) {
            $type_deal_path = __build_tax_uri(get_the_terms($post, 'typespecialties'));

            return strtr($permalink, array(
                //'%typespecialties%' => $type_deal_path,
                '%typespecialties%' => is_array($type_deal_path)?reset($type_deal_path):$type_deal_path,
                '%post_name%' =>$post->post_name,
            ));
        }elseif(false !== strpos($permalink, '%typesestablishments%')){
            $arCategories = get_the_terms($post, 'typesestablishments');
            $type_est_path = __build_tax_uri($arCategories);

            return strtr($permalink, array(
                '%typesestablishments%' => is_array($type_est_path)?reset($type_est_path):'',
                '%post_name%' =>$post->post_name,
            ));
        }else{
            return $permalink;
        }



    }
    function __build_tax_uri($terms)
    {

        if (is_wp_error($terms) || empty($terms) || !(is_object(reset($terms)) || is_object($terms))) {
            return 'no_terms';
        }

        $term = is_object(reset($terms)) ? reset($terms) : $terms;
        $path = array($term->slug);
        while ($term->parent) {
            $term = get_term($term->parent);
            $path = $term->slug;
        }
        if($path == 'dpo'){
            $term = is_object(reset($terms)) ? reset($terms) : $terms;
            $path = array($term->slug);
            while ($term->parent) {
                $term = get_term($term->parent);
                $path[] = $term->slug;
            }
            return implode('/', array_reverse($path) );
        }else{
            return $path;
        }


    }

    ## 404 страница если в URL указаны неправильные названия таксономий.
    ## По факту, WP затем 301 редиректит на правильный URL...
    add_filter('pre_handle_404', 'custom_404');
    function custom_404($false)
    {
        if (!get_queried_object()) {
            return $false;
        } // ничего не делает...

        $_404 = false;

        // запись объявления
        if (is_singular('specialties')) {
            $post = get_queried_object();

            // type_deal
            if (!$_404 && ($term_name = get_query_var('typespecialties')) && !has_term(explode('-', $term_name), 'typespecialties',
                    $post)) {
                $_404 = 1;
            }

        }

        // для такс
        if (is_tax(['typespecialties'])) {
            // type_deal
            if (!$_404 && ($term_name = get_query_var('type_deal')) && !get_term_by('slug', $term_name, 'type_deal')) {
                $_404 = 1;
            }

            // type_realty
            if (!$_404 && ($term_name = get_query_var('type_realty')) && !get_term_by('slug', $term_name,
                    'type_realty')) {
                $_404 = 1;
            }

            // country
            if (!$_404 && ($term_name = get_query_var('country')) && !get_term_by('slug', $term_name, 'country')) {
                $_404 = 1;
            }
        }

        if ($_404) {
            global $wp_query;

            $wp_query->set_404();
            status_header(404);
            nocache_headers();

            return 1; // обрываем следующие проверки
        }

        return $false; // ничего не делает...
    }
}

