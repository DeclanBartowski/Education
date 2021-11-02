<?php


namespace TQ\WP;

use WP_Query;

class Review
{
    public array $arSort = [
        'date_desc' => [
            'name' => 'сначала новые',
            'order' => 'desc',
            'field' => 'date'
        ],
        'date_asc' => [
            'name' => 'сначала старые',
            'order' => 'asc',
            'field' => 'date'
        ],
    ];

    private array $order;

    public function __construct($sort = 'date_desc')
    {
        if ($sort) {
            if (isset($this->arSort[$sort])) {
                $_SESSION['review_sort'] = $sort;
                $this->arSort[$sort]['is_current'] = true;
                $this->order = [$this->arSort[$sort]['field'] => $this->arSort[$sort]['order']];
            } else {
                $this->order = ['date' => 'desc'];
            }
        } else {
            if (isset($_SESSION['review_sort']) && $this->arSort[$_SESSION['review_sort']]) {
                $this->arSort[$_SESSION['review_sort']]['is_current'] = true;
                $this->order = [$this->arSort[$_SESSION['review_sort']]['field'] => $this->arSort[$_SESSION['review_sort']]['order']];
            } else {
                $this->order = ['date' => 'desc'];
            }
        }
    }

    /**
     * @param string[] $order
     * @param int $limit
     * @param int|array $id
     * @return array
     */
    public function getReviews($id = 0, $limit = 3)
    {
        $arItems = [];
        $navPag = '';
        $total = 0;
        $arArgs = [
            'post_type' => 'reviews',
            'orderby' => $this->order,
            'posts_per_page' => $limit
        ];
        if ($id) {
            $arArgs['meta_key'] = 'establishment';
            $arArgs['meta_value'] = $id;
        }
        if ($limit > 0) {
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $arArgs['paged'] = $paged;
        } else {
            $arArgs['nopaging'] = true;
        }
        $q = new WP_Query($arArgs);
        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $arItems[] = get_post();
            }
            if (isset($paged) && $paged) {
                $navPag = kama_paginate_links_data(
                    [
                        'total' => $q->max_num_pages,
                        'current' => $paged,
                        'type' => 'array',
                        'prev_next' => false
                    ]
                );
            }
            $total = $q->found_posts;
        }
        wp_reset_postdata();
        return [
            'nav_items' => $navPag,
            'total' => $total,
            'items' => $arItems
        ];
    }

    public static function addReview()
    {
        $form_data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $response['success'] = true;
        if (!$form_data['university']) {
            $response['success'] = false;
            $response['error'][] = 'university';
        }
        if ($form_data['name'] == '') {
            $response['success'] = false;
            $response['error'][] = 'name';
        }
        if ($form_data['review'] == '') {
            $response['success'] = false;
            $response['error'][] = 'review';
        }
        foreach ($form_data['social'] as $key => $value) {
            if ($value != '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                $response['success'] = false;
                $response['error'][] = 'social[' . $key . ']';
            }
        }
        if (!$response['error']) {
            $post_data = array(
                'post_title' => sanitize_text_field($form_data['name']),
                'post_type' => 'reviews',
                'post_content' => $form_data['review'],
                'establishment' => $form_data['university'],
                'meta_input' => [
                    'establishment' => $form_data['university'],
                    'vk' => $form_data['social']['vkontakte'],
                    'facebook' => $form_data['social']['facebook'],
                    'whatsapp' => $form_data['social']['whatsapp'],
                ],
                'post_status'   => 'draft',
            );
            wp_insert_post($post_data);
            $response['success'] = true;
        }
        echo(json_encode($response));
        wp_die();
    }

}