<?php
if(!have_posts()){
    echo __FILE__;
    $theSlugs = explode("/", substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])-2));
    $lastSlug = $theSlugs[sizeof($theSlugs)-1];
    $args = array('post_per_page' => -1, 'post_type' => 'campus', 'post_status' => 'publish', 'slug' => $lastSlug);
    $the_query = new WP_Query($args);
    foreach($the_query->posts as $post){
        if($post && strcmp($post->post_name, $lastSlug) == 0){
            $args = array();
            if(! array_key_exists('title', $args))
                $args['title'] = get_the_title();
            if(! array_key_exists('subtitle', $args))
                $args['subtitle'] = get_field('page_banner_subtitle');
            pageBanner($args);
            get_template_part("template-parts/content", "block-single-campus");
        }
    }
} else{
    while(have_posts()) {
        the_post();
        pageBanner();
        get_template_part("template-parts/content", "block-single-campus");
    }
}