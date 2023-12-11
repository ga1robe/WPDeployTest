<?php
if(! have_posts()){
    $theSlugs = explode("/", substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])-2));
    if(sizeof($theSlugs) == 1)
        $the_slug = sanitize_title_with_dashes($_SERVER['REQUEST_URI']);
    else
        $the_slug = implode("/", $theSlugs);
    $args = array('post_per_page' => -1, 'post_type' => 'page', 'post_status' => 'publish', 'pagename' => $the_slug, 'fields' => 'ids');
    $the_query = new WP_Query($args);
    foreach($the_query->posts as $post){
        if($post){
            the_post();
            $args = array();
            if(! array_key_exists('title', $args))
                $args['title'] = get_the_title();
            if(! array_key_exists('subtitle', $args))
                $args['subtitle'] = get_field('page_banner_subtitle');
            pageBanner($args);

            if (array_key_exists('title', $args) && (strcmp(sanitize_title($args['title']),"search")==0) && ($the_query->posts[0]==99))
                get_template_part("template-parts/content", "block-search-form");
            get_template_part("template-parts/content", "block-page");
        }
    }
}
else {
    while(have_posts()) {
        the_post();
        pageBanner();
        if (array_key_exists('title', $args) && (strcmp(sanitize_title($args['title']),"search")==0)."&".($the_query->posts[0]==99))
            get_template_part("template-parts/content", "block-search-form");
        get_template_part("template-parts/content", "block-page");
    }
}