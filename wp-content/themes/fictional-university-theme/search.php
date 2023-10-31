<?php get_header() ?>

<?php pageBanner(array('title' => 'Search Results', 'subtitle' => 'It\'s your &ldquo;'.esc_html(get_search_query(true)).'&rdquo; search.')) ?>

<div class="container container--narrow page-section">
    <?php
    if(have_posts()){
        while(have_posts()) {
            the_post();
            get_template_part('template-parts/content', get_post_type());
            
       }
        echo paginate_links();
    } else {
        ?>
        <h2 class="headline headline--small-plus">No Results match that search.</h2>
        <?php
    }
    get_search_form()
    ?>
    
</div>
<?php get_footer() ?>