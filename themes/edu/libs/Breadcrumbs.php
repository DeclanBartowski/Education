<?php


namespace TQ\WP;


class Breadcrumbs
{
    /**
     * @param array $args
     * @return array
     */
    public function getBreadcrumbs($args = [])
    {
        $url = str_replace($_SERVER['HTTP_HOST'], '',
            substr(get_permalink(), strpos(get_permalink(), $_SERVER['HTTP_HOST'])));
        $arExUrl = array_diff(explode('/', $url), ['']);
        $result = [];
        $mainPage = get_post(get_option('page_on_front'));
        if ($mainPage) {
            $result[] = [
                'title' => $mainPage->post_title,
                'url' => get_home_url()
            ];
        }

        if ($arExUrl) {
            $elementUrl = '';
            $listPage = null;
            if(isset($args['post']) && $args['post']){
                $post = $args['post'];
            }else{
                $post = get_post();
            }
            foreach ($arExUrl as $slug) {
                if ($elementUrl) {
                    $elementUrl .= sprintf('%s/', $slug);
                } else {
                    $elementUrl .= sprintf('/%s/', $slug);
                }
                if ($page = get_page_by_path($elementUrl)) {
                    $listPage = $page;
                    $result[] = [
                        'title' => $page->post_title,
                        'url' => get_permalink($page->ID)
                    ];
                } elseif ($post && $url == $elementUrl) {
                    $arPostPath = $this->getParentTree($post,$args,$url);
                    if ($arPostPath) {
                        foreach ($arPostPath as $arCategory) {
                            if($arCategory->link){
                                $link = $arCategory->link;
                            }else{
                                $link = isset($listPage)?get_permalink($listPage->ID):'';
                            }

                            $result[] = [
                                'title' => $arCategory->name,
                                'url' =>$link
                            ];
                        }
                    }
                    $result[] = [
                        'title' => isset($post->post_title)?$post->post_title:$post->name,
                        'url' => isset($post->post_title)?get_permalink($post->ID):get_term_link(intval($post->term_id),$args['tax'])
                    ];
                }
            }
        }
        if ($result) {
            $result[array_key_last($result)]['is_last'] = true;
        }


        return $result;
    }

    /**
     * @param $post
     * @param $args
     * @return array
     */
    private function getParentTree($post,$args,$url)
    {
        $arPath = [];
        if(isset($args['tax']) && $args['tax']){
            if(isset($post->parent)){
                $arCategories[] = get_term($post->parent,$args['tax']);
            }else{
                $arCategories = get_the_terms($post->ID,$args['tax']);
            }
            if ($arCategories) {

                $category = reset($arCategories);

                if($category->parent == 0){
                    $category->link = get_term_link(intval($category->term_id),$args['tax']);
                    $arPath[] = $category;
                }else{

                    $parentCategory = get_term($category->parent);
                    $parentCategory->link = get_term_link(intval($parentCategory->term_id),$args['tax']);
                    $arPath[] = $parentCategory;

                    $category->link = get_term_link(intval($category->term_id),$args['tax']);
                    if(strpos(get_permalink(),$category->link)!==false){
                        $arPath[] = $category;
                    }
                }
            }
        }else{
            $arCategories = get_the_category($post->ID);
            if ($arCategories) {
                $arPath[] = reset($arCategories);
            }
        }



        return $arPath;
    }


}