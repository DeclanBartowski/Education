<?php

get_header(); // вставка header.php

if(isset($wp->query_vars['establishments_name'])){
    get_template_part('detail_establishment_speciality');
}else{
    get_template_part('detail_speciality');
}
get_footer(); // footer.php ?>
