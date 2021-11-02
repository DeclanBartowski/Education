<?php


namespace TQ\WP;


class Speciality
{

    /**
     * @param array $arFilter
     * @return array
     */
    public static function getElements($arFilter = [])
    {
        $arElementFilter = [];
        if($arFilter){
            if(isset($arFilter['term_id']) && $arFilter['term_id']){
                $arElementFilter['tax_query'] = [[
                    'taxonomy' => 'typespecialties',
                    'terms' => $arFilter['term_id'],
                    'include_children' => true
                ]];
            }elseif(isset($arFilter['current_term']) && $arFilter['current_term']){
                $arElementFilter['tax_query'][] = [
                    'taxonomy' => 'typespecialties',
                    'terms' => $arFilter['current_term'],
                    'include_children' => true
                ];
            }
            if(isset($arFilter['theme']) && $arFilter['theme']){
                $arElementFilter['meta_query'][] = [
                    'key' => 'theme',
                    'value' => $arFilter['theme'],
                    'compare' => 'IN'
                ];
            }
            if(isset($arFilter['min_price']) && $arFilter['min_price']){
                $arPrices = explode(';', $arFilter['min_price']);
                $arElementFilter['meta_query'][] = [
                    'key' => 'min_price',
                    'value' => [intval($arPrices[0]), intval($arPrices[1])],
                    'compare' => 'BETWEEN',
                    'type' => 'numeric',
                ];
            }
            if(isset($arFilter['min_period']) && $arFilter['min_period']){
                $arPrices = explode(';', $arFilter['min_period']);
                $arElementFilter['meta_query'][] = [
                    'key' => 'min_period',
                    'value' => [intval($arPrices[0]), intval($arPrices[1])],
                    'compare' => 'BETWEEN',
                    'type' => 'numeric',
                ];
            }
            if(isset($arFilter['online_protection']) || isset($arFilter['installment']) || isset($arFilter['transfer'])){
                $arEstablishments = PostTypeHelper::getElements('establishments',['id'=>'asc'],[
                    'meta_query' => [
                        [
                            'key' => 'specs',
                            'value' => false,
                            'compare' => '!='
                        ],
                    ]
                ]);
                $arAvailableItems = [];
                if($arEstablishments){
                    foreach ($arEstablishments as $establishment){
                        $arSpecs = get_field('specs',$establishment->ID);

                        foreach ($arSpecs as $spec){
                            if(isset($arFilter['online_protection']) && $arFilter['online_protection'] == 'Y' && $spec['online_protection']){
                                $arAvailableItems[$establishment->ID][] = $spec['item']->ID;
                            }
                            if(isset($arFilter['installment']) && $arFilter['installment'] == 'Y' && $spec['installment']){
                                $arAvailableItems[$establishment->ID][] = $spec['item']->ID;
                            }
                            if(isset($arFilter['transfer']) && $arFilter['transfer'] == 'Y' && $spec['transfer']){
                                $arAvailableItems[$establishment->ID][] = $spec['item']->ID;
                            }
                        }
                    }

                }
                if($arAvailableItems){
                    $count = 0;
                    if(isset($arFilter['online_protection']) && $arFilter['online_protection'] == 'Y'){
                        $count++;
                    }
                    if(isset($arFilter['installment']) && $arFilter['installment'] == 'Y' ){
                        $count++;
                    }
                    if(isset($arFilter['transfer']) && $arFilter['transfer'] == 'Y'){
                        $count++;
                    }
                    $arCount = [];
                    foreach ($arAvailableItems as $key => $est){
                        foreach ($est as $id){
                            $arCount[$key][$id]++;
                        }
                    }
                    $arAvailableItems = [];
                    foreach ($arCount as $key => $est){
                        foreach ($est as $id => $specCount){
                           if($count == $specCount)
                               $arAvailableItems[] = $id;
                        }
                    }
                    if(!$arAvailableItems){
                        $arAvailableItems = [null];
                    }
                }else{
                    $arAvailableItems = [null];
                }

                $arElementFilter['post__in'] = $arAvailableItems;
            }

        }

        return PostTypeHelper::getElements('specialties', ['post_title' => 'asc'], $arElementFilter);
    }

    public static function getFilterParams($arItems)
    {
        $arFilterParams = [];
        foreach ($arItems as $item) {
            if ($arTerms = get_the_terms($item->ID, 'typespecialties')) {
                foreach ($arTerms as $term) {
                    if (!isset($arFilterParams['terms'][$term->term_id]) && $term->parent != 0) {
                        $arFilterParams['terms'][$term->term_id] = $term;
                    }
                }
            }
            if(isset($arFilterParams['terms']) && $arFilterParams['terms'] && $theme = get_field('theme',$item->ID)){
                if (!in_array($theme,$arFilterParams['terms'])) {
                    $arFilterParams['themes'][] = $theme;
                }
            }
            if($minPrice = get_field('min_price', $item->ID)){
                if(!isset($arFilterParams['prices']['min']) || $arFilterParams['prices']['min'] > $minPrice){
                    $arFilterParams['prices']['min'] = $minPrice;
                    $arFilterParams['prices']['min_formatted'] =  declOfNum($minPrice,['₽','₽','₽'],true,true);
                }
                if(!isset($arFilterParams['prices']['max']) || $arFilterParams['prices']['max'] < $minPrice){
                    $arFilterParams['prices']['max'] = $minPrice;
                    $arFilterParams['prices']['max_formatted'] =  declOfNum($minPrice,['₽','₽','₽'],true,true);
                }
            }
            if($minPeriod = get_field('min_period', $item->ID)){
                if(!isset($arFilterParams['period']['min']) || $arFilterParams['period']['min'] > $minPeriod){
                    $arFilterParams['period']['min'] = $minPeriod;
                    $arFilterParams['period']['min_formatted'] = declOfNum($minPeriod,['год','года','лет'],true,true);
                }
                if(!isset($arFilterParams['period']['max']) || $arFilterParams['period']['max'] < $minPeriod){
                    $arFilterParams['period']['max'] = $minPeriod;
                    $arFilterParams['period']['max_formatted'] = declOfNum($minPeriod,['год','года','лет'],true,true);
                }

            }
        }
        return $arFilterParams;
    }

    /**
     * @param false $onlyParent
     * @return int[]|string|string[]|\WP_Error|\WP_Term[]
     */
    private function getSections($onlyParent = false)
    {
        $terms = get_terms([
            'taxonomy' => 'typespecialties',
            'hide_empty' => true,
            'pad_counts' => true,
            'count' => false,
            'hierarchical' => true,
        ]);
        if ($onlyParent) {
            if ($terms) {
                foreach ($terms as $key => $term) {
                    if ($term->parent != 0) {
                        unset($terms[$key]);
                    }
                }
            }
        }

        return array_values($terms);
    }

    /**
     * @param boolean $withItems
     * @param boolean $countDpoTerms
     * @param boolean $showAll
     * @return array
     */
    public function getMainSpecialities($withItems = true, $countDpoTerms = false,$showAll = true)
    {
        $arItems = [];
        $arTerms = $this->getSections(true);
        $count = 0;
        if ($arTerms) {


                foreach ($arTerms as &$term) {

                    if ($withItems) {
                    $count += $term->count;
                    if($showAll){
                        $limit = -1;
                    }else{
                        $limit = $term->slug == 'dpo' ? 6 : 5;
                    }

                    $arElements = PostTypeHelper::getElements('specialties', ['post_title' => 'asc'], [
                        'tax_query' => [
                            [
                                'taxonomy' => 'typespecialties',
                                'terms' => $term->term_id,
                                'include_children' => true
                            ]
                        ],
                    ],$limit);
                    if ($arElements) {
                        $term->items = $arElements;
                    }
                }
                    if($term->slug == 'dpo' && $countDpoTerms){
                        $arDpoTerms = get_terms([
                            'taxonomy' => 'typespecialties',
                            'hide_empty' => true,
                            'pad_counts' => true,
                            'count' => true,
                            'parent' => $term->term_id,
                        ]);
                        $term->count = count($arDpoTerms);
                    }
                }
                unset($term);



            $arItems = $arTerms;
        }
        return [
            'items' => $arItems,
            'count' => $count
        ];
    }


    public static function getFilterResult()
    {
        $arElements = self::getElements($_REQUEST);
        if ($arElements) {
            $response['success'] = true;
            $response['count'] = declOfNum(count($arElements), ['направление', 'направления', 'напрпавлений']);
            ob_start();
            foreach ($arElements as $item){
                get_template_part('direction_item',null,['type'=>'','item'=>$item,'list'=>true]);
            }
            $response['html'] = ob_get_contents();
            ob_end_clean();
        } else {
            $response['success'] = false;
            $response['count'] = '0 профессий';
            $response['html'] = '<div class="filter_error searching_error" style="display: block;">
                                        <p class="filter_text caption_2">К сожалению, По Вашему запросу ничего не найдено. Попробуйте другой запрос.</p>
                                        <div class="image" style="background-image: url('.get_stylesheet_directory_uri().'/assets/images/find_nothing.png);"></div>
                                    </div>';
        }

        echo json_encode($response);
        wp_die();
    }
    public static function search()
    {
        $q = $_REQUEST['q'];
        $termId = $_REQUEST['term_id'];
        $arFilter = [];
        if ($termId) {
            $arFilter['tax_query'] = [
                [
                    'taxonomy' => 'typespecialties',
                    'terms' => $termId,
                    'include_children' => true
                ]
            ];
        }
        if ($q) {
            $arFilter['search_prod_title'] = sprintf('%s', $q);
            add_filter('posts_where', 'title_filter', 10, 2);
        }
        $category = get_term($termId);
        if($category->slug=='dpo'){
            $arElements = get_terms([
                'taxonomy' => 'typespecialties',
                'hide_empty' => true,
                'pad_counts' => true,
                'search' => $q,
                'count' => false,
                'parent' => $category->term_id,
                'hierarchical' => true,
            ]);
        }else{
            $arElements = PostTypeHelper::getElements('specialties', ['post_title' => 'asc'], $arFilter);
        }

        if ($q) {
            remove_filter('posts_where', 'title_filter', 10, 2);
        }
        if ($arElements) {

            ob_start();
            foreach ($arElements as $item) {
                get_template_part('direction_item', null, ['type' => $category->slug,'is_term'=>$category->slug=='dpo', 'item' => $item, 'list' => true]);
            }
            echo ob_get_clean();
        } else {
            echo 'not_found';
        }

        wp_die();
    }

    /**
     * @param $speciality
     * @return mixed
     */
    public static function getAdditionalInfo($speciality){
        $result = [];
            $professionIds = get_field('professions',$speciality->ID);
            if($professionIds){
                $arProfessions = PostTypeHelper::getElements('professii', ['post_title' => 'asc'],['post__in' => $professionIds]);
                if ($arProfessions) {
                    $arMinPrices = Profession::getMinPrices();
                    foreach ($arProfessions as &$profession) {
                        if (isset($arMinPrices[$profession->ID]) && $arMinPrices[$profession->ID]) {
                            $profession->min_price = $arMinPrices[$profession->ID];
                        }
                    }
                    unset($profession);
                }
                $result['professions'] = $arProfessions;
            }
            $arEstablishment = PostTypeHelper::getElements('establishments', ['post_title' => 'asc'],[
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key' => 'specs',
                        //'value' => $speciality->ID,
                        'compare' => 'EXISTS'
                    ],
                ]
            ]);
            if($arEstablishment){
                foreach ($arEstablishment as $item){
                    $arSpecs = get_field('specs',$item->ID);
                    if($arSpecs){
                        foreach ($arSpecs as $arSpec){
                            if($arSpec['item']->ID == $speciality->ID){
                                $item->picture = get_field('preview_picture',$item->ID);
                                $item->advantages = get_field('advantages',$item->ID);
                                $item->min_price = get_field('min_price',$item->ID);
                                $item->min_period = get_field('min_period',$item->ID);
                                $result['establishments'][] = $item;
                                break;
                            }
                        }
                    }

                }
            }


        return $result;
    }

    /**
     * @param $termId
     * @return array
     */
    public static function getItemsByType($termId){
        $result = [];
        $arTabs = [];
        $arItems = Speciality::getElements(['current_term'=>$termId]);
        if($arItems){
            foreach ($arItems as $item){
                $item->type = get_field('type',$item->ID);
                $item->min_price = get_field('min_price',$item->ID);
                $item->min_period = get_field('min_period',$item->ID);
                $arTabs[$item->type][] = $item;
            }
            $result = [
                'cnt'=>count($arItems),
                'tabs'=>$arTabs
            ];

        }
        return $result;
    }

}