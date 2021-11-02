<?
/**
 * @var $args
 */
use TQ\WP\Soc;
$socClass = Soc::getInstance();
$soc = $socClass->getSoc();?>
<?if($soc){?>
        <?if(isset($args['links']) && $args['links']){?>
    <div class="social_buttons">
        <?foreach ($soc as $item){
            ?>
            <a href="<?=$item['url']?>" class="social_link" target="_blank">
                <img src="<?=$item['img']?>" alt="<?=$item['title']?>">
            </a>
        <?}?>
       </div>
            <?}else{?>
        <div class="social_buttons">
            <?foreach ($soc as $item){
                $url = sprintf('https://www.addtoany.com/add_to/%s?linkurl=%s',$item['title'],get_permalink())
                ?>
                <a href="<?=$url?>" class="social_link" target="_blank">
                    <img src="<?=$item['img']?>" alt="<?=$item['title']?>">
                </a>
            <?}?>
        </div>
        <?}?>
<?}?>
