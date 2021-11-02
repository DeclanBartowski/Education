<?php


namespace TQ\WP;


class Chances
{
    /**
     * @return array
     */
    public static function getSpecialities()
    {
        $arElements = [];
        $arEstablishments = PostTypeHelper::getElements('establishments', ['id' => 'desc'], [
            'meta_query' => [
                [
                    'key' => 'specs',
                    'value' => false,
                    'compare' => '!='
                ],
            ]
        ]);
        if ($arEstablishments) {
            foreach ($arEstablishments as $establishment) {
                $arSpecs = get_field('specs', $establishment->ID);
                foreach ($arSpecs as $spec) {
                    if (!isset($arElements[$spec['item']->ID])) {
                        $arElements[$spec['item']->ID] = $spec['item'];
                    }
                }
            }
            if ($arElements) {
                $arPrices = [];
                foreach ($arElements as &$element) {
                    $element->min_price = get_field('min_price', $element->ID);
                    $element->background = get_field('background', $element->ID);
                    $element->disciplines = get_field('disciplines', $element->ID);
                    if ($element->min_price) {
                        $arPrices[] = $element->min_price;
                    }
                }
                unset($element);
                $object = new \stdClass();
                $object->post_title = 'Все направления';
                $object->min_price = min($arPrices);
                $object->background = false;
                $object->disciplines = PostTypeHelper::getElements('disciplines', ['post_title' => 'asc']);
                array_unshift($arElements, $object);
            }
        }
        return $arElements;
    }
    public static function getResult(){
        $arItems = [];
        if($_REQUEST['result']){
            $arRequest = unserialize(base64_decode($_REQUEST['result']));
                $arEstablishments = PostTypeHelper::getElements('establishments', ['id' => 'desc'], [
                    'meta_query' => [
                        [
                            'key' => 'specs',
                            'value' => false,
                            'compare' => '!='
                        ],
                    ]
                ]);
                if($arEstablishments){
                    foreach ($arEstablishments as $establishment){
                        $arSpecs = get_field('specs',$establishment->ID);
                        foreach ($arSpecs as $spec){
                            if(isset($arItems[$spec['item']->ID]))continue;
                            if($spec['self_disciplines']){
                                if($spec['disciplines']){
                                    $arSuccessDisciplines = [];
                                    foreach ($spec['disciplines'] as $discipline){
                                        $minPoints = get_field('min_points',$discipline['discipline']->ID);
                                        if(isset($arRequest['discipline'][$discipline['discipline']->ID]) && floatval($arRequest['discipline'][$discipline['discipline']->ID])>=floatval($minPoints)){
                                            $arSuccessDisciplines[] = $discipline['discipline']->ID;
                                        }
                                    }
                                    if(count($arSuccessDisciplines) == count($spec['disciplines'])){
                                        $arItems[$spec['item']->ID] = $spec['item'];
                                    }
                                }
                            }else{
                                $arSuccessDisciplines = [];
                                $arDisciplines = get_field('disciplines',$spec['item']->ID);
                                if($arDisciplines){
                                    foreach ($arDisciplines as $discipline){
                                        $minPoints = get_field('min_points',$discipline->ID);
                                        if(isset($arRequest['discipline'][$discipline->ID]) && floatval($arRequest['discipline'][$discipline->ID])>=floatval($minPoints)){
                                            $arSuccessDisciplines[] = $discipline->ID;
                                        }
                                    }
                                    if(count($arSuccessDisciplines) == count($arDisciplines)){
                                        $arItems[$spec['item']->ID] = $spec['item'];
                                    }
                                }

                            }

                        }

                    }
                }

        }

        return $arItems;
    }

    public static function checkChances()
    {
        $response = [];
        $arRequest = $_REQUEST;
        $count = count($arRequest['discipline']);
        $arRequest['discipline'] = array_diff($arRequest['discipline'],['']);
        if($arRequest['speciality']){
            if($count == count($arRequest['discipline'])){
                $response['success'] = true;
                $response['url'] = sprintf('%s?result=%s',get_permalink(CHECK_RESULT_ID),base64_encode(serialize($arRequest)));
            }else{
                $response['success'] = false;
                $response['error'] = 'Введите данные ЕГЭ по предметам';
            }

        }else{

            if($arRequest['discipline']){
                $response['success'] = true;
                $response['url'] = sprintf('%s?result=%s',get_permalink(CHECK_RESULT_ID),base64_encode(serialize($arRequest)));
            }else{
                $response['success'] = false;
                $response['error'] = 'Введите данные ЕГЭ хотя бы по 1 предмету';
            }

        }
        echo json_encode($response);
        wp_die();
    }
    public static function getEstablishmentsParams($establishment){
        $arParams = [];
        $arSpecs = get_field('specs',$establishment->ID);
        if($arSpecs){

            foreach ($arSpecs as $spec){
                $arProfiles = get_field('profiles',$spec['item']->ID);
                $arCategories = get_the_terms($spec['item']->ID,'typespecialties');
                if($arProfiles){
                    foreach ($arProfiles as $profile){
                        $arParams['profiles'][$spec['item']->ID][$profile->ID] = [
                            'id'=>$profile->ID,
                            'name'=>$profile->post_title
                        ];
                    }

                }

                if($arCategories){
                    foreach ($arCategories as $category){
                        $arParams['levels'][$category->term_id] = [
                            'id'=>$category->term_id,
                            'name'=>$category->name
                        ];
                        $arParams['directions'][$category->term_id][$spec['item']->ID] = [
                            'id'=>$spec['item']->ID,
                            'name'=>$spec['item']->post_title
                        ];
                    }

                }
            }
        }
        return $arParams;
    }
    public static function saveFile(){
        if (empty($_FILES) || $_FILES["file"]["error"]) {
            die('{"success": false}');
        }


        $fileName = $_FILES["file"]["name"];

        move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/documents/$fileName");

        die('{"success": true}');
    }
}