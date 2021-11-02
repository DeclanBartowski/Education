<?php
/**
 * @var $args
 */
$item = $args['item'];
if($item){
    $background = get_field('background',$item);
    $picture = get_field('picture',$item);
    $minPrice = get_field('min_price',$item);
    $minPeriod = get_field('min_period',$item);

if(isset($args['list']) && $args['list']){
    $class = 'item_wrap col col-12 col-lg-6 tq_item';
}else{
    $class = 'item_wrap col col-xl-4 col-lg-6 col-12 tq_item';
}
?>
        <?if($args['type'] == 'dpo'){?>
            <?if(isset($args['is_term']) && $args['is_term'] ){?>
            <div class="item_wrap col col-12 tq_item">
                <div class="lined">
                    <div class="row aic">
                        <div class="col col-xl-1 col-sm-2 col-3">
                            <?if($picture){?>
                                <div class="image">
                                    <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$item->name?>">
                                </div>
                            <?}?>
                        </div>
                        <div class="col col-xl-11 col-sm-10 col-9">
                            <div class="row aic">
                                <div class="col col-xl-5 col-md-7 col-12">
                                    <a href="<?=get_term_link(intval($item->term_id),'typespecialties')?>" class="caption_4 bold searching_value"><?=$item->name?></a>
                                </div>
                                <div class="col col-xl-7 col-md-5 col-12">
                                    <ul class="info">
                                        <?if($minPeriod){?>
                                            <li class="caption_1">
                                                от <?=declOfNum($minPeriod,['часа','часов','часов'])?>
                                                <span class="popup">~<?=declOfNum(ceil($minPeriod/8),['день','дня','дней'])?></span>
                                                <span class="prompt_popup">
																<span class="prompt_popup_head">
																	<span class="caption_1 bold">Если учиться:</span>
																	<span class="prompt_popup_close"></span>
																</span>
																<span class="desc_1">4 часа в день — <?=declOfNum(ceil($minPeriod/4),['день','дня','дней'])?><br>6 часов в день — <?=declOfNum(ceil($minPeriod/6),['день','дня','дней'])?> <br>8 часов в день — <?=declOfNum(ceil($minPeriod/8),['день','дня','дней'])?></span>
															</span>
                                            </li>
                                        <?}?>

                                        <?if($minPrice){?>
                                            <li class="caption_1">от <?=number_format($minPrice,'0',',',' ')?> ₽</li>
                                        <?}?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?}else{?>
<div class="item_wrap col col-12 tq_item">
    <div class="lined">
        <div class="row aic">
            <div class="col col-xl-1 col-sm-2 col-3">
                <?if($picture){?>
                    <div class="image">
                        <img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$item->post_title?>">
                    </div>
                <?}?>
            </div>
            <div class="col col-xl-11 col-sm-10 col-9">
                <div class="row aic">
                    <div class="col col-xl-5 col-md-7 col-12">
                        <a href="<?=get_permalink($item->ID)?>" class="caption_4 bold searching_value"><?=$item->post_title?></a>
                    </div>
                    <div class="col col-xl-7 col-md-5 col-12">
                        <ul class="info">
                            <?if($minPeriod){?>
                                <li class="caption_1">
                                    от <?=declOfNum($minPeriod,['часа','часов','часов'])?>
                                    <span class="popup">~<?=declOfNum(ceil($minPeriod/8),['день','дня','дней'])?></span>
                                    <span class="prompt_popup">
																<span class="prompt_popup_head">
																	<span class="caption_1 bold">Если учиться:</span>
																	<span class="prompt_popup_close"></span>
																</span>
																<span class="desc_1">4 часа в день — <?=declOfNum(ceil($minPeriod/4),['день','дня','дней'])?><br>6 часов в день — <?=declOfNum(ceil($minPeriod/6),['день','дня','дней'])?> <br>8 часов в день — <?=declOfNum(ceil($minPeriod/8),['день','дня','дней'])?></span>
															</span>
                                </li>
                            <?}?>

                            <?if($minPrice){?>
                                <li class="caption_1">от <?=number_format($minPrice,'0',',',' ')?> ₽</li>
                            <?}?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <?}?>
<?}else{?>
        <div class="<?=$class?>">
            <div class="item"<?if($background){?> style="background-image: url(<?=$background?>);"<?}?>>
                <a href="<?=get_permalink($item->ID)?>" class="item_title caption_4 bold"><?=$item->post_title?></a>
                <div class="content">
                    <div class="left">
                        <ul class="info">
                            <?if($minPrice){?>
                                <li class="caption_1">от <?=number_format($minPrice,'0',',',' ')?> ₽ семестр</li>
                            <?}?>
                            <?if($minPeriod){?>
                                <li class="caption_1">от <?=number_format($minPeriod,'1',',',' ')?> <?=declOfNum($minPeriod,['года','лет','лет'],false)?></li>
                            <?}?>
                        </ul>
                        <a data-fancybox data-src="#get_consultation" href="javascript:;" class="link">
												<span class="points">
													<span class="point"></span>
													<span class="point"></span>
													<span class="point"></span>
												</span>
                            <span class="item_text button_1 bold">консультация</span>
                        </a>
                    </div>
                    <?if($picture){?>
                        <div class="right">
                            <div class="image"><img src="<?=$picture['url']?>" alt="<?=$picture['alt']?:$item->post_title?>"></div>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
        <?}?>
<?}?>