<?php
if(!have_posts()){
    $request_uri = $_SERVER['REQUEST_URI'];
    $args = array('post_per_page' => -1, 'post_type' => 'post', 'post_status' => 'published', array('field' => 'slug'));
    $the_query = new WP_Query($args);
    while($the_query->have_posts()){
        $the_query->the_post();
        if (strcmp(sanitize_title(get_the_title()), sanitize_title($request_uri)) == 0){
            $args = array();
            if(! array_key_exists('title', $args))
                $args['title'] = get_the_title();
            if(! array_key_exists('subtitle', $args))
                $args['subtitle'] = get_field('page_banner_subtitle');
            pageBanner($args);
            ?>
            <div class="container container--narrow page-section">
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on <?php the_time('G:i D, F j, Y') ?> in <?php echo get_the_category_list(', ') ?>></span></p>
                </div>
                <div class="generic-content"><?php the_content() ?></div>
            </div>
            <?php
        }
    }
} else {
    while(have_posts()) {
        the_post();
        pageBanner()
        ?>
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on <?php the_time('G:i D, F j, Y') ?> in <?php echo get_the_category_list(', ') ?>></span></p>
            </div>
            <div class="generic-content"><?php the_content() ?></div>
        </div>
        <?php
    }
}
