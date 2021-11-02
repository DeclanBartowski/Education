<?php


namespace TQ\WP;


class Establishments
{
    /**
     * @return array|int[]
     */
    public static function getLimitsParams()
    {
        $result = [
            'price' => 0,
            'period' => 0,
        ];
        $arLimits = [];
        $terms = get_terms([
            'taxonomy' => 'typespecialties',
            'hide_empty' => true,
            'pad_counts' => true,
            'count' => false,
            'hierarchical' => true,
        ]);
        if ($terms) {
            foreach ($terms as $key => $term) {
                if ($term->parent != 0 || $term->slug == 'dpo') {
                    unset($terms[$key]);
                } else {
                    $arIds[] = $term->term_id;
                }
            }
        }
        if (isset($arIds) && $arIds) {
            $arElements = PostTypeHelper::getElements('specialties', ['post_title' => 'asc'], [
                'tax_query' => [
                    [
                        'taxonomy' => 'typespecialties',
                        'terms' => $arIds,
                        'include_children' => true,
                        'operator' => 'IN'
                    ]
                ],
            ]);
            if ($arElements) {
                foreach ($arElements as $item) {
                    $price = get_field('min_price', $item->ID);
                    $period = get_field('min_period', $item->ID);
                    if ($price) {
                        $arLimits['price'][] = str_replace(',', '.', $price);
                    }
                    if ($period) {
                        $arLimits['period'][] = str_replace(',', '.', $period);
                    }
                }
            }
        }

        /*$arItems = PostTypeHelper::getElements('establishments');
        if ($arItems) {
            foreach ($arItems as $item) {
                $arSpecs = get_field('specs', $item->ID);
                if ($arSpecs) {
                    foreach ($arSpecs as $arSpec) {
                        $arLimits['price'][] = str_replace(',', '.', $arSpec['price']);
                        $arLimits['period'][] = str_replace(',', '.', $arSpec['period']);
                    }
                }
            }
        }*/
        if ($arLimits) {
            $result = [
                'price' => min($arLimits['price']),
                'period' => min($arLimits['period']),
            ];
        }
        return $result;
    }

    public static function getElements($termId = 0)
    {
        $arFilter = [];
        if ($termId) {
            $arFilter['tax_query'] = [
                [
                    'taxonomy' => 'typesestablishments',
                    'terms' => $termId,
                    'include_children' => true
                ]
            ];
        }
        $arElements = PostTypeHelper::getElements('establishments', ['date' => 'desc'], $arFilter);
        if ($arElements) {
            foreach ($arElements as &$item) {
                $item->min_price = get_field('min_price', $item->ID);
            }
            unset($item);
        }

        return $arElements;
    }

    public static function getQuantity()
    {
        $count = wp_count_posts('establishments');
        return $count->publish;
    }

}