<?php
function themeSlugQueryVars($vars){ $vars[] = 'SkyColor'; $vars[] = 'grassColor'; return $vars; }
add_filter('query_vars', 'themeSlugQueryVars');

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');
function pageBanner($args = NULL){
    if(! array_key_exists('title', $args))
        $args['title'] = get_the_title();
    if(! array_key_exists('subtitle', $args))
        $args['subtitle'] = get_field('page_banner_subtitle');
    if(! array_key_exists('background', $args) AND ! is_archive() AND ! is_home() AND get_field('page_banner_background_image'))
        $args['background'] = get_field('page_banner_background_image');
    else
        $args['background'] = get_theme_file_uri('/images/ocean.jpg');
    $pageBannerImage =$args['background']
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php if(is_array($pageBannerImage) AND array_key_exists('sizes', $pageBannerImage)) echo $pageBannerImage['sizes']['pageBanner']; else echo $pageBannerImage ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
    </div>
    <?php
}
function university_files(){
    wp_enqueue_script('main-university-js', '//maps.googleapis.com/maps/api/js?key=AIzaSyD2VUWuPPHF7ctxDnvW4_H34cv3QXlSA80', array(), '1.0', true);
    wp_enqueue_script('googleMap', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-university-js', 'universityData', array('root_url' => get_site_url(), 'nonce' => wp_create_nonce('wp_rest')));
    // if(strstr($_SERVER['SERVER_NAME'], 'localhost:10033')){ wp_enqueue_script('main-university-js', 'http://localhost:100033/bundled.js', null, '1.0'); }
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 411, 260, array('left', 'top')); //411x260
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner',1500, 350, true);
    add_image_size('slideshowImage', 1900, 525, true);
    /* additional features */
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'First Footer Menu Location');
    register_nav_menu('footerLocationTwo', 'Second Footer Menu Location');
    /* additional features for block-banner */
    add_theme_support('editor-styles');
    add_editor_style(array('https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', 'build/style-index.css', 'build/index.css'));
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query){
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(array('key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type' => 'numeric')));
        // $query->set('posts_per_page', '-1');
    }
    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', '-1');
    }
    if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
        $query->set('posts_per_page', '-1');
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function university_custom_rest(){
    register_rest_field('post', 'authorName', array('get_callback' => function(){ return get_the_author(); }));
    register_rest_field('note', 'userNoteCount', array('get_callback' => function(){ return count_user_posts(get_current_user_id(), 'note'); }));
}

add_action('rest_api_init', 'university_custom_rest');

function universityMapKey($api){
    $api['key'] = 'AIzaSyD2VUWuPPHF7ctxDnvW4_H34cv3QXlSA80';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

/*
* Redirect subscriber accounts out of admin and onto homepage
*/
function redirectSubsToFrontend(){
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar(){
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber')
        show_admin_bar(false);
}

add_action('wp_loaded', 'noSubsAdminBar');

/*
* Customize Login Screen
*/
function ourHeaderUrl(){
    return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'ourHeaderUrl');

function ourLoginCSS(){
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginTitle(){
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'ourLoginTitle');

/*
* Force note posts to be private
*/
function makeNotePrivate($data, $postarr){
    if($data['post_type'] == 'note' AND count_user_posts(get_current_user_id(), 'note') > 4 and !$postarr['ID']){
        die("Notes have a limit reached.");
    }
    if($data['post_type'] == 'note'){
        $data['post_title'] = sanitize_text_field($data['post_title']);
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
    }
    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash')
        $data['post_status'] = 'private';
    return $data;
}

add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function ingoreCertainFiles($exclude_filters){
    $exclude_filters[] = 'themes/fictional-university-theme/node_modules';
    return $exclude_filters;
}

add_filter('ai1m_exclude_content_from_export', 'ingoreCertainFiles');

class JSXBlock {
    var $renderCallback;
    var $name;
    var $data;
    function __construct($name, $renderCallback = null, $data = null) {
        $this->name = $name;
        $this->renderCallback = $renderCallback;
        $this->data = $data;
        add_action('init', array($this, 'onInit'));
    }
    function onInit() {
        wp_register_script($this->name, get_stylesheet_directory_uri() . "/build/{$this->name}.js", array('wp-blocks', 'wp-editor'));
        if($this->data)
            wp_localize_script($this->name, $this->name, $this->data);
        $ourArgs = array( 'editor_script' => $this->name );
        if ($this->renderCallback)
            $ourArgs['render_callback'] = array($this, 'ourRenderCallback');
        register_block_type("our-block-theme/{$this->name}", $ourArgs);
    }
    function ourRenderCallback($attributes, $content) {
        ob_start();
        require get_theme_file_path("/our-blocks/{$this->name}.php");
        return ob_get_clean();
    }
}

new JSXBlock("banner", true, array( "fallbackimage" => get_theme_file_uri("/image/library-hero.jpg") ));
new JSXBlock("generic-heading");
new JSXBlock("generic-button");
new JSXBlock('slide-show', true);
new JSXBlock('slide', true, array( "themeimagepath" => get_theme_file_uri("/images/") ));

class PlaceholderBlock {
    var $name;
    function __construct($name){
        $this->name = $name;
        add_action("init", array($this, 'onInit'));
    }
    function onInit(){
        wp_register_script($this->name, get_stylesheet_directory_uri()."/our-blocks/{$this->name}.js", array('wp-blocks', 'wp-editor'));
        register_block_type("our-block-theme/{$this->name}", array( "editor_script" => $this->name, "render_callback" => array($this, "ourRenderCallback") ));
    }

     function ourRenderCallback($attributes, $content){
        ob_start();
        require get_theme_file_path("/our-blocks/{$this->name}.php");
        return ob_get_clean();
    }
}

new PlaceholderBlock("events-and-blogs");
new PlaceholderBlock("header");
new PlaceholderBlock("footer");
new PlaceholderBlock("single-post");
new PlaceholderBlock("page");
new PlaceholderBlock("blog-index");
new PlaceholderBlock("archive-program");
new PlaceholderBlock("single-program");
new PlaceholderBlock("single-professor");
new PlaceholderBlock("page-my-notes");
new PlaceholderBlock("archive-campus");
new PlaceholderBlock("single-campus");
new PlaceholderBlock("archive-event");
new PlaceholderBlock("past-events");
new PlaceholderBlock("single-event");
new PlaceholderBlock("archive");
new PlaceholderBlock("search");
new PlaceholderBlock("search-results");

function ourAllowedBlocks($allowed_block_types, $editor_context){
    // if(!empty($editor_context->post->post_type == 'event'))
    //     return array('core/paragraph', 'core/list'); // for examples…
    /*
    * If you are on a page/post editor screen
    */
    if(!empty($editor_context->post))
        return $allowed_block_types;
    /*
    * If you are on the FSE sceen
    */
    return array('ourblocktheme/header', 'ourblocktheme/footer'); // for example…
}
/*
* Uncomment the line bellow if you actually wamt to restrict which block types are allowed
*/
// add_filter('allowed_block_types_all', 'ourAllowedBlocks', 10, 2);
?>