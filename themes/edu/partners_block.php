<?php
use TQ\WP\PostTypeHelper;
$arPartners = PostTypeHelper::getPartners();
?>
<?if($arPartners){?>
<section class="section block_logos">
    <div class="container-fluid">
        <div class="partners_logos">
            <?foreach ($arPartners as $partner){?>
            <a <?if($partner->link){?>href="<?=$partner->link?>"<?}?> class="item">
                <div class="image">
                    <img src="<?=$partner->logo['url']?>" alt="<?=$partner->logo['alt']?:$partner->post_title?>">
                </div>
            </a>
            <?}?>
        </div>
    </div>
</section>
<?}?>