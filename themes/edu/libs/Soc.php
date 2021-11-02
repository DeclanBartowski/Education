<?php


namespace TQ\WP;


class Soc
{
    private static $instance;
    private $arSoc = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getSoc()
    {
        if ($this->arSoc == null) {
            $soc = get_theme_mod('tq_soc');
            $arSoc = json_decode($soc, true);
            if ($arSoc) {
                foreach ($arSoc as $key => &$item) {
                    if (isset($item['img'], $item['url']) && $item['img'] && $item['url']) {
                        $item['img'] = wp_get_attachment_url($item['img']);
                    } else {
                        unset($arSoc[$key]);
                    }
                }
                unset($item);
            }
            $this->arSoc = $arSoc;
        }
        return $this->arSoc;
    }

}