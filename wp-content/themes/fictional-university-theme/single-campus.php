<?php get_header() ?>

<?php
    while(have_posts()){
        the_post();
        pageBanner(array());
?>        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i>All Campuses</a> <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>
            <div cass="generic-content"><?php the_content() ?></div>

            <?php $mapLocation = get_field('map_location') ?>

            <div class="acf-map">
                <div class="marker" data-lat="<?php if(is_array($mapLocation) AND key_exists('lat', $mapLocation)) echo $mapLocation['lat'] ?>" data-lng="<?php if(is_array($mapLocation) AND key_exists('lng', $mapLocation)) echo $mapLocation['lng'] ?>">
                    <li><a href="<?php the_permalink() ?>"><?php the_title(); if($mapLocation AND is_array($mapLocation)) echo $mapLocation['address']; else echo "&nbsp;[not Map addressed]" ?></a></li>
                </div>
            </div>

            <?php
            $relatedPrograms = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'program',
                'key' => 'title',
                'meta_query' => array(
                    array('key' => 'related_campus', 'compare' => 'LIKE', 'value' => '"'.get_the_ID().'"')
                ),
                'order' => 'ASC'
            ));
            ?>
            <?php
            if($relatedPrograms->have_posts()) {
            ?>
                <hr class="section-break" />
                <h2 class="headline headline--medium">Programs Available At <?php the_title() ?> Campus</h2>
            <?php
            }
            ?>
            <ur class="min-list link-list">
            <?php
            while($relatedPrograms->have_posts()){
                $relatedPrograms->the_post();
            ?>
                <li><a href="<<?php the_permalink() ?>"><?php the_title() ?></a></li>
            <?php
            }
            ?>
            </ul>
            <?php wp_reset_postdata() ?>
        </div>
<?php
    }
?>
<?php get_footer() ?>