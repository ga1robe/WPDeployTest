<?php
if(! have_posts()){
    $lastChar = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['REQUEST_URI'])-1, strlen($_SERVER['REQUEST_URI']));
    if(($lastChar == '/'))
        $theSlugs = explode("/", substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])-2));
    else
        $theSlugs = explode("/", substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])-1));
    $is_lastSlugQuestion = false;
    if(sizeof($theSlugs) == 1)
        $the_slug = sanitize_title_with_dashes($_SERVER['REQUEST_URI']);
    elseif(checkLastSlugIsQuestion($theSlugs))
        $the_slug = $theSlugs[0];
    else
        $the_slug = implode("/", $theSlugs);
    if(checkLastSlugIsQuestion($theSlugs)){
        esc_html($theSlugs[sizeOf($theSlugs)-1]);
        $convertLastSlug = convertLastSlugToArray($theSlugs);
        // var_dump($convertLastSlug);
    }
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

function checkLastSlugIsQuestion($theSlugs){
    if(sizeof($theSlugs) > 1 && strpos($theSlugs[sizeOf($theSlugs)-1], "?") >= 0 && strpos($theSlugs[sizeOf($theSlugs)-1], "=") > 0 && strpos($theSlugs[sizeOf($theSlugs)-1], "&") > 0)
        return true;
    if(sizeof($theSlugs) > 1 && strpos($theSlugs[sizeOf($theSlugs)-1], "?") >= 0 && strpos($theSlugs[sizeOf($theSlugs)-1], "=") > 0)
        return true;
    return false;
}

function convertLastSlugToArray($theSlugs){
    $covertedArray = array();
    if(strpos($theSlugs[sizeOf($theSlugs)-1], "?") == 0)
        $theQuestionsString = substr($theSlugs[sizeOf($theSlugs)-1], 1);
    else
        $theQuestionsString = substr($theSlugs[sizeOf($theSlugs)-1], 0);
    if(str_contains($theQuestionsString, "&")){
        $theQuestionStringArr = explode("&",$theQuestionsString);
        foreach($theQuestionStringArr as $theQuestionString){
            [$key,$value] = explode("=",$theQuestionString, 2);
            $covertedArray[$key] = $value;
        }
    }
    return $covertedArray;
}