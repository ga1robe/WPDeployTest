<?php get_header() ?>

<?php
    while(have_posts()){
        the_post();
        pageBanner(array());
?>        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs</a> <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>
            <div cass="generic-content"><?php the_field('main_body_content') ?></div>
            
            <?php
            $relatedProfessors = new WP_Query(array(
                'posts_per_page' => -1,
                'post_type' => 'professor',
                'key' => 'title',
                'meta_query' => array(
                    array('key' => 'related_program', 'compare' => 'LIKE', 'value' => '"'.get_the_ID().'"')
                ),
                'order' => 'ASC'
            ));
            ?>

            <?php
            if($relatedProfessors->have_posts()) {
            ?>
                <hr class="section-break" />
                <h2 class="headline headline--medium"><?php the_title() ?> Professors</h2>
            <?php
            }
            ?>
            <ur class="professor-cards">
            <?php
            while($relatedProfessors->have_posts()){
                $relatedProfessors->the_post();
            ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink() ?>">
                    <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>">
                    <spam class="professor-card__name"><?php the_title() ?></spam>
                    </a>
                </li>
            <?php
            }
            ?>
            </ul>
            <?php
            wp_reset_postdata();

            $today = date('Ymd');
            $homePageEvents = new WP_Query(array(
                'posts_per_page' => 3,
                'post_type' => 'event',
                'orderby' => 'meta_value_num',
                'meta_key' => 'event_date',
                'meta_query' => array(
                    array('key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type' => 'numeric'),
                    array('key' => 'related_program', 'compare' => 'LIKE', 'value' => '"'.get_the_ID().'"')
                ),
                'order' => 'ASC'
            ));
            ?>

            <?php
            if($homePageEvents->have_posts()) {
            ?>
                <hr class="section-break" />
                <h2 class="headline headline--medium">Upcoming <?php the_title() ?> Events</h2>
            <?php
            }
            ?>
            <?php
            $arrayOfEvents = $homePageEvents->get_posts();
            while($homePageEvents->have_posts()){
                $homePageEvents->the_post();
                get_template_part('template-parts/content', 'event');
            }
            wp_reset_postdata()
            ?>
            <?php
            $relatedCampuses = get_field('related_campus');
            if($relatedCampuses) {
            ?>
                <hr class="section-break" />
                <h2 class="headline headline--medium"><?php the_title() ?> is Available At These Campuses:</h2>
                <ul class="min-list link-list">
                <?php
                foreach($relatedCampuses as $relatedCampus){
                    ?>
                    <li><a href="<?php the_permalink($relatedCampus) ?>"><?php echo get_the_title($relatedCampus) ?></a></li>
                <?php
                }
                ?>
                </ul>
            <?php
            }
            ?>
            
        </div>
<?php
    }
?>
<?php get_footer() ?>