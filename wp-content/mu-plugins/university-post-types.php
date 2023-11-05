<?php

/*
University Post Types
*/
function university_post_types(){
    /*
    Event Post Type
    */
    register_post_type('event', array(
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'excerpt', 'event-date'),
        'show_in_rest' => true,
        // 'rewrite' => array('blog' => 'event'),
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'rewrite' => array('slug' => 'event'),
        'menu_icon' => 'dashicons-calendar',
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
            )
    ));
        
    /*
    Program Post Type
    */
    register_post_type('program', array(
    'public' => true,
    'has_archive' => true,
    'supports' => array('title'),
    'show_in_rest' => true,
    'rewrite' => array('slug' => 'programs'),
    'menu_icon' => 'dashicons-forms',
    'labels' => array(
        'name' => 'Programs',
        'add_new_item' => 'Add New Program',
        'edit_item' => 'Edit Program',
        'all_items' => 'All Programs',
        'singular_name' => 'Program'
        )
    ));

    /*
    Professor Post Type
    */
    register_post_type('professor', array(
    'public' => true,
    'has_archive' => false,
    'supports' => array('title', 'editor', 'thumbnail'),
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-welcome-learn-more',
    'labels' => array(
        'name' => 'Professors',
        'add_new_item' => 'Add New Professor',
        'edit_item' => 'Edit Professor',
        'all_items' => 'All Professors',
        'singular_name' => 'Professor'
        )
    ));

    /*
    Campus Post Type
    */
    register_post_type('campus', array(
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'capability_type' => 'campus',
        'map_meta_cap' => true,
        // 'rewrite' => array('blog' => 'campuses'),
        'rewrite' => array('slug' => 'campuses'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-location-alt',
        'labels' => array(
            'name' => 'Campuses',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
            )
    ));

    /*
    Note Post Type
    */
    register_post_type('note', array(
        'public' => true,
        'show_ui' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor'),
        'show_in_rest' => true,
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
            )
    ));
    
    /*
    Like Post Type
    */
    register_post_type('like', array(
        'public' => true,
        'show_ui' => true,
        'supports' => array('title'),
        'menu_icon' => 'dashicons-heart',
        'labels' => array(
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like'
            )
    ));
        
    /*
    Homepage Slideshow Post Type
    */
    register_post_type('homepage-slideshow', [
        'public' => false, /* not publicly visible */
        'has_archive' => false,
        'supports' => array('title'),
        'show_in_rest' => true,
        'show_ui' => true, /* to be visible in the admin panel */
        'menu_icon' => 'dashicons-images-alt',
        'labels' => [
            'name' => 'Homepage-slideshow',
            'add_new_item' => 'Add New Homepage-slide',
            'edit_item' => 'Edit Homepage-slide',
            'all_items' => 'All Homepage-slides',
            'singular_name' => 'Homepage-slide'
            ]
    ]);
}

add_action('init', 'university_post_types');
?>