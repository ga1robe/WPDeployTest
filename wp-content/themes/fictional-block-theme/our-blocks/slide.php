<?php
if (!empty($attributes['themeimage']))
    $attributes['imgURL'] = get_theme_file_uri("/images/".$attributes["themeimage"]);
if (!array_key_exists('imgURL', $attributes))
    $attributes['imgURL'] = get_theme_file_uri('/images/library-hero.jpg');
?>
<div class="hero-slider__slide" style="background-image: url('<?php echo $attributes['imgURL'] ?>')">
    <div class="hero-slider__interior container">
        <div class="hero-slider__overlay t-center"><?php echo $content ?></div>
    </div>
</div>