<?php


namespace TQ\WP;

use WP_Query;

class PostTypeHelper
{

    /**
     * @param $postType
     * @param string[]|string $order
     * @param array $arFilter
     * @param int $limit
     * @return array
     */
    public static function getElements($postType, $order = ['date' => 'desc'], $arFilter = [], $limit = -1)
    {
        $arItems = [];
        $arArgs = [
            'post_type' => $postType,
            'orderby' => $order,
            'posts_per_page' => $limit
        ];
        if ($arFilter) {
            $arArgs = array_merge($arArgs, $arFilter);
        }
        $q = new WP_Query($arArgs);
        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $arItems[] = get_post();
            }
        }
        wp_reset_postdata();
        return $arItems;
    }

    /**
     * @return array
     */
    public static function getPostList()
    {
        $arResult = [];
        $arItems = self::getElements('post');
        if ($arItems) {
            $arCats = get_categories();
            $arTabs = [
                'all' => [
                    'name' => 'Все',
                    'count' => count($arItems)
                ]
            ];
            if ($arCats) {
                foreach ($arCats as $cat) {
                    $arTabs[sprintf('.%s', $cat->slug)] = [
                        'name' => $cat->name,
                        'count' => $cat->count
                    ];
                }
            }
            $arResult = [
                'tabs' => $arTabs,
                'items' => $arItems
            ];
        }
        return $arResult;
    }

    /**
     * @return array
     */
    public static function getPartners()
    {
        $result = [];
        $arItems = self::getElements('establishments');
        if ($arItems) {
            foreach ($arItems as $item) {
                $item->logo = get_field('logo', $item->ID);
                if($item->logo){
                    $item->link = get_permalink($item->ID);
                    $result[] = $item;
                }

            }
            unset($item);
        }
        return $result;
    }
    /**
     * @return array
     */
    public static function getDiplomas()
    {
        $arItems = self::getElements('diplomas');
        if ($arItems) {
            foreach ($arItems as $item) {
                $item->logo = get_field('picture', $item->ID);
            }
            unset($item);
        }
        return $arItems;
    }
    /**
     * @return array
     */
    public static function getScheme()
    {
        $arItems = self::getElements('scheme');
        if ($arItems) {
            foreach ($arItems as $item) {
                $item->logo = get_field('picture', $item->ID);
            }
            unset($item);
        }
        return $arItems;
    }

}