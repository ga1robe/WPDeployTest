<?php get_header() ?>

<?php pageBanner(array('title' => 'Our Campuses', 'subtitle' => 'We have several conveniently located campuses.')) ?>

<div class="container container--narrow page-section">
<div class="acf-map">
<?php
while(have_posts()) {
    the_post();
    $mapLocation = get_field('map_location')
    ?>
    <div class="marker" data-lat="<?php if(is_array($mapLocation) AND key_exists('lat', $mapLocation)) echo $mapLocation['lat'] ?>" data-lng="<?php if(is_array($mapLocation) AND key_exists('lng', $mapLocation)) echo $mapLocation['lng'] ?>">
        <li><a href="<?php the_permalink() ?>"><?php the_title(); if($mapLocation AND is_array($mapLocation)) echo $mapLocation['address']; else echo "&nbsp;[not Map addressed]" ?></a></li>
    </div>
    
<?php
}
// echo paginate_links()
?>
</div>

</div>
<?php get_footer() ?>