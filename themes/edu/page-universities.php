<?get_header(); // вставка header.php
/*
Template Name: Учебные заведения
*/
use \TQ\WP\Establishments;
$subTitle = get_field('sub_title');
$termId = get_field('term_id');
?>
    <div class="main">
        <section class="section block_universities">
            <div class="container">
                <p class="title title_1"><?=get_the_content()?></p>
                <?if($subTitle){?>
                <p class="sub text_1"><?=$subTitle?></p>
                <?}?>
                <?get_template_part('universities_list',null,['term_id'=>$termId])?>
            </div>
        </section>
    </div>
<?php
get_footer(); // footer.php