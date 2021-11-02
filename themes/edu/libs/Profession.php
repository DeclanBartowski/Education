<?php


namespace TQ\WP;


class Profession
{
    /**
     * @param array $arFilter
     * @return array
     */
    public static function getElements($arFilter = [])
    {
        $arSpecs = PostTypeHelper::getElements('specialties', ['id' => 'asc'], [
            'meta_query' => [
                [
                    'key' => 'professions',
                    'value' => false,
                    'compare' => '!='
                ],
            ]
        ]);
        $arElementsFilter = [];
        if ($arFilter) {
            $arProfIds = [];
            $arProfIdsByPrice = [];
            if (isset($arFilter['terms']) && $arFilter['terms']) {
                $arElementsFilter['tax_query'] = [
                    [
                        'taxonomy' => 'prof_categories',
                        'terms' => $arFilter['terms'],
                        'include_children' => true
                    ]
                ];
            }
            if (isset($arFilter['specialties']) && $arFilter['specialties']) {
                foreach ($arSpecs as $spec) {
                    if (in_array($spec->ID, $arFilter['specialties'])) {
                        $professions = get_field('professions', $spec->ID);
                        foreach ($professions as $profession) {
                            if (!in_array($profession, $arProfIds)) {
                                $arProfIds[] = $profession;
                            }
                        }
                    }
                }
                if(!$arProfIds)$arProfIds[] = null;
            }
            if (isset($arFilter['price']) && $arFilter['price']) {
                $arPrices = explode(';', $arFilter['price']);
                foreach ($arSpecs as $spec) {
                    $minPrice = get_field('min_price', $spec->ID);
                    if ($minPrice && $minPrice <= $arPrices[1] && $minPrice >= $arPrices[0]) {
                        $professions = get_field('professions', $spec->ID);
                        foreach ($professions as $profession) {
                            if (!in_array($profession, $arProfIdsByPrice)) {
                                $arProfIdsByPrice[] = $profession;
                            }
                        }
                    }
                }
                if(!$arProfIdsByPrice)$arProfIdsByPrice[] = null;
            }
            if ($arProfIds || $arProfIdsByPrice) {
                if ($arProfIds && $arProfIdsByPrice) {
                    if (array_intersect($arProfIds, $arProfIdsByPrice)) {
                        $arElementsFilter['post__in'] = array_intersect($arProfIds, $arProfIdsByPrice);
                    }else{
                        $arElementsFilter['post__in'] = [null];
                    }
                } elseif ($arProfIds) {
                    $arElementsFilter['post__in'] = $arProfIds;
                } elseif ($arProfIdsByPrice) {
                    $arElementsFilter['post__in'] = $arProfIdsByPrice;
                }
            }
            if (isset($arFilter['wage']) && $arFilter['wage']) {
                $arWages = explode(';', $arFilter['wage']);
                $arElementsFilter['meta_query'][] = [
                    'key' => 'wage',
                    'value' => [intval($arWages[0]), intval($arWages[1])],
                    'compare' => 'BETWEEN',
                    'type' => 'numeric',

                ];
            }
        }


        $arElements = PostTypeHelper::getElements('professii', ['date' => 'desc'], $arElementsFilter);
        if ($arElements) {
            if ($arSpecs) {
                $arElementPrices = [];
                foreach ($arSpecs as $spec) {
                    $professions = get_field('professions', $spec->ID);
                    if ($professions) {
                        $minPrice = get_field('min_price', $spec->ID);
                        if ($minPrice) {
                            $minPrice = str_replace(',', '.', $minPrice);
                            foreach ($professions as $profession) {
                                if (!isset($arElementPrices[$profession]) || !$arElementPrices[$profession] || $minPrice < $arElementPrices[$profession]) {
                                    $arElementPrices[$profession] = $minPrice;
                                }
                            }
                        }
                    }
                }
                if ($arElementPrices) {
                    foreach ($arElements as &$element) {
                        if (isset($arElementPrices[$element->ID]) && $arElementPrices[$element->ID]) {
                            $element->minPrice = $arElementPrices[$element->ID];
                        }
                    }
                }
            }
        }

        return $arElements;
    }


    public static function getFilterResult()
    {
        $arElements = self::getElements($_REQUEST);
        if ($arElements) {
            $response['success'] = true;
            $response['count'] = declOfNum(count($arElements), ['профессия', 'профессии', 'профессий']);
            ob_start();
            get_template_part('professions_list', null, ['elements' => $arElements]);
            $response['html'] = ob_get_contents();
            ob_end_clean();
        } else {
            $response['success'] = false;
            $response['count'] = '0 профессий';
        }

        echo json_encode($response);
        wp_die();
    }

    /**
     * @return array
     */
    public static function getFilter()
    {
        $result = [];
        $terms = get_terms([
            'taxonomy' => 'prof_categories',
            'hide_empty' => true,
            'pad_counts' => true,
            'count' => false,
            'hierarchical' => true,
        ]);
        if ($terms) {
            $result['terms'] = $terms;
        }
        $arSpecs = PostTypeHelper::getElements('specialties', ['date' => 'desc'], [
            'meta_query' => [
                [
                    'key' => 'professions',
                    'value' => false,
                    'compare' => '!='
                ],
            ]
        ]);
        if ($arSpecs) {
            $result['specialties'] = $arSpecs;
            $arPrices = [];
            foreach ($arSpecs as $spec) {
                $minPrice = get_field('min_price', $spec->ID);
                if (!isset($arPrices['min_price']) || !$arPrices['min_price'] || $minPrice < $arPrices['min_price']) {
                    $arPrices['min_price'] = $minPrice;
                }
                if (!isset($arPrices['max_price']) || !$arPrices['max_price'] || $minPrice > $arPrices['max_price']) {
                    $arPrices['max_price'] = $minPrice;
                }
            }
            $result['prices'] = [
                'min' => $arPrices['min_price'],
                'min_formatted' => number_format($arPrices['min_price'], '0', ',', ' '),
                'max' => $arPrices['max_price'],
                'max_formatted' => number_format($arPrices['max_price'], '0', ',', ' '),
            ];
        }
        $arProfs = PostTypeHelper::getElements('professii');
        if ($arProfs) {
            $arWages = [];
            foreach ($arProfs as $profession) {
                $wage = get_field('wage', $profession->ID);
                if ($wage) {
                    $arWages[] = str_replace(',', '.', $wage);
                }
            }
            if ($arWages) {
                $result['wages'] = [
                    'min' => min($arWages),
                    'min_formatted' => number_format(min($arWages), '0', ',', ' '),
                    'max' => max($arWages),
                    'max_formatted' => number_format(max($arWages), '0', ',', ' '),
                ];
            }
        }


        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getProfInfo($id){
        $result = [];
        $arSpecs = PostTypeHelper::getElements('specialties', ['date' => 'desc'], [
            'meta_query' => [
                [
                    'key' => 'professions',
                    'value' => $id,
                    'compare' => 'LIKE'
                ],
            ]
        ]);
        if($arSpecs){
            $result['specialities'] = $arSpecs;
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getMinPrices(){
        $arElementPrices = [];
        $arSpecs = PostTypeHelper::getElements('specialties', ['id' => 'asc'], [
            'meta_query' => [
                [
                    'key' => 'professions',
                    'value' => false,
                    'compare' => '!='
                ],
            ]
        ]);
        foreach ($arSpecs as $spec) {
            $professions = get_field('professions', $spec->ID);
            if ($professions) {
                $minPrice = get_field('min_price', $spec->ID);
                if ($minPrice) {
                    $minPrice = str_replace(',', '.', $minPrice);
                    foreach ($professions as $profession) {
                        if (!isset($arElementPrices[$profession]) || !$arElementPrices[$profession] || $minPrice < $arElementPrices[$profession]) {
                            $arElementPrices[$profession] = $minPrice;
                        }
                    }
                }
            }
        }
        return $arElementPrices;
    }

}