<div class="full-width-split group">
    <div class="full-width-split__one">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
            <?php
            $today = date('Ymd');
            $homePageEvents = new WP_Query(array(
                'posts_per_page' => 3,
                'post_type' => 'event',
                'orderby' => 'meta_value_num',
                'meta_key' => 'event_date',
                'meta_query' => array(array('key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type' => 'numeric')),
                'order' => 'ASC'
            ));
            $arrayOfEvents = $homePageEvents->get_posts();
            while($homePageEvents->have_posts()){
                $homePageEvents->the_post();
                get_template_part('template-parts/content', 'event');
            }
            ?>
            <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event') ?>" class="btn btn--blue">View All Events</a></p>
        </div>
    </div>
    <div class="full-width-split__two">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
            <?php
            $homepagePosts = new WP_Query(array(
                'posts_per_page' => 3
                // 'category_name' => 'awards',
                // 'post_type' => 'post'
            ));
            $arrayOfPosts = $homepagePosts->get_posts();
            while($homepagePosts->have_posts()){
                $homepagePosts->the_post();
                ?>
                <div class="event-summary">
                    <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>">
                        <span class="event-summary__month"><?php the_time('M') ?></span>
                        <span class="event-summary__day"><?php the_time('d') ?></span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                        <p><?php if(has_excerpt()) echo get_the_excerpt().'&nbsp;'; else echo wp_trim_words(get_the_content(), 18)."&nbsp;" ?><a href="<?php the_permalink() ?>" class="nu gray">Read more</a></p>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata()
            ?>
            <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
    </div>
</div>