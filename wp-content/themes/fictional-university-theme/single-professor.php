<?php get_header() ?>

<?php
    while(have_posts()){
        the_post();
        pageBanner(array());
?>

<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" nohref><i class="fa fa-home" aria-hidden="true"></i></a><span class="metabox__main"><?php the_title() ?></span>
        </p>
    </div>
    <div cass="generic-content">
        <div class="tow group">
            <div class="one-third">
                <?php the_post_thumbnail('professorPortrait') ?>
            </div>
            <div class="two-thirds">
                <?php
                $likeCount = new WP_Query(array(
                    'post_type' => 'like',
                    'meta_query' => array(
                      array(
                        'key' => 'liked_professor_id',
                        'compare' => '==',
                        'value' => get_the_ID()
                      )
                    )
                ));
                $existQuery = (is_user_logged_in()) ? new WP_Query(array(
                        'author' => get_current_user_id(),
                        'post_type' => 'like',
                        'meta_query' => array(
                            array(
                            'key' => 'liked_professor_id',
                            'compare' => '==',
                            'value' => get_the_ID()
                            )
                        )
                    )) : new WP_Query(array());
                $existStatus = 'no';
                if ($existQuery->found_posts)
                    $existStatus = 'yes';
                ?>
                <span class="like-box" data-like="<?php if(isset($existQuery->posts[0]->ID)) echo $existQuery->posts[0]->ID ?>" data-professor="<?php the_ID() ?>" data-exists="<?php echo $existStatus ?>">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <span class="like-count"><?php echo $likeCount->found_posts ?></span>
                </span>
                <?php the_content() ?>
            </div>
        </div>
    </div>

    <?php
    $relatedPrograms = get_field('related_program');
    if($relatedPrograms){
    ?>
    <hr class="section-break" />
    <h2 class="headline headline--medium">Sobject(s) Taught</h2>
    <ul class="link-list min-list">
    <?php
        foreach($relatedPrograms as $relatedProgram){
        ?>
            <li><a href="<?php the_permalink($relatedProgram) ?>"><?php echo get_the_title($relatedProgram) ?></a></li>
    <?php
        }
    }
    ?>
    </ul>
</div>
<?php
    }
?>
<?php get_footer() ?>