<?php get_header() ?>

<?php
    while(have_posts()){
        the_post();
        pageBanner(array())
?>
        
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>"><i class="fa fa-home" aria-hidden="true"></i>Event Home</a> <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>
            <div cass="generic-content"><?php the_content() ?></div>

            <?php
            $relatedPrograms = get_field('related_program');
            if($relatedPrograms){
            ?>
            <hr class="section-break" />
            <h2 class="headline headline--medium">Related Programs</h2>
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