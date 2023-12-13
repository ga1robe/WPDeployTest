<?php
$theParent = wp_get_post_parent_id(get_the_ID());
if ($theParent) { ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
    <?php
}
$testArray = get_pages(array( 'child_of' => get_the_ID() ));
if ($theParent or $testArray) { ?>
    <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
            <?php
            if ($theParent) {
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
            ));
            ?>
        </ul>
    </div>
    <?php
}
?>
<div class="generic-content">
    <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
        <label class="headline headline--medium" for="s">Perform a New Search:</label>
        <div class="search-form-row">
            <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s">
            <input class="search-submit" type="submit" value="Search">
        </div>
    </form>
    <?php
    $showQueryVars = false;
    /*
    * add to file: functions.php
        function themeSlugQueryVars($vars){ $vars[] = 'SkyColor'; $vars[] = 'grassColor'; return $vars; }
        add_filter('query_vars', 'themeSlugQueryVars');
    * and change variable to positive: $showQueryVars = true;
    * after refreshing page, enter the data and confirm…
    * and expect the result in URI address after question mark
    */
    if($showQueryVars){
        echo "<hr />";
        $skyColorValue = sanitize_text_field(get_query_var('skyColor', $_GET['skyColor']));
        $grassColorValue = sanitize_text_field(get_query_var('grassColor', $_GET['grassColor']));
        if($skyColorValue == 'blue' && $grassColorValue == 'green'){ echo "<p>Sky is ".$_GET['skyColor'].", grass is ".$_GET['grassColor'].".</p>"; }
        ?>
        <form method="GET">
            <input name="skyColor" placeholder="sky Color" />
            <input name="grassColor" placeholder="grass Color" />
            <button>Submit</button>
        </form>
        <?php
    } ?>
</div>