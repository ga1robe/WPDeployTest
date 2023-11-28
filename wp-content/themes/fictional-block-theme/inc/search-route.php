<?php

// function university_custom_rest(){
//     register_rest_field('post', 'authorName', array('get_callback' => function(){ return get_the_author(); }));
// }
// add_action('rest_api_init', 'university_custom_rest');

function universityRegisterSearch(){
    register_rest_route('university/v1', 'search', array('methods' => WP_REST_Server::READABLE, 'callback' => 'universitySearchResults'));
}

function universitySearchResults($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
        's' => sanitize_text_field($data['term'])
      ));
    
      $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
        );
    
      while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if(get_post_type() == 'post' OR get_post_type() == 'page' AND get_the_title() != 'Privacy Policy'){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }
        if(get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
                'relatedProgram' => get_field('related_program')[0],
                'content' => get_the_content()
            ));
        }
        if(get_post_type() == 'program'){
            $relatedCampus = get_field('related_campus');
            if($relatedCampus)
                foreach($relatedCampus as $campusItem){
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campusItem),
                        'permalink' => get_the_permalink($campusItem),
                        'ID' => get_the_ID($campusItem),
                        'content' => get_the_content($campusItem)
                    ));
                }
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID(),
                'content' => get_the_content(),
                'relatedCampus' => $relatedCampus
            ));
        }
        if(get_post_type() == 'campus'){
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID(),
                'content' => get_the_content()
            ));
        }
        if(get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $eventMonth = $eventDate->format('M');
            $eventDay = $eventDate->format('d');
            $excerpt = null;
            if(has_excerpt()) $excerpt = get_the_excerpt().'&nbsp;'; else $excerpt = wp_trim_words(get_the_content(), 18)."&nbsp;";
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'content' => get_the_content(),
                'excerpt' => $excerpt,
                'eventDate' => $eventDate,
                'month' => $eventMonth,
                'day' => $eventDay
            ));
        }
      }

      if($results['programs']){
        $programMetaQuery = array('relation' => 'OR');
        foreach($results['programs'] as $programItem){
            array_push($programMetaQuery, array(
                'key' => 'related_program',
                'compare' => 'LIKE',
                'value' => '"'.$programItem['ID'].'"'
            ));
        }
        $programRelatonshipQuery = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programMetaQuery
        ));
    }
    if($programRelatonshipQuery)
        while($programRelatonshipQuery->have_posts()){
            $programRelatonshipQuery->the_post();
            if(get_post_type() == 'professor'){
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
                    'relatedProgram' => get_field('related_program')[0],
                    'content' => get_the_content()
                ));
            }
            if(get_post_type() == 'event'){
                $eventDate = new DateTime(get_field('event_date'));
                $eventMonth = $eventDate->format('M');
                $eventDay = $eventDate->format('d');
                $excerpt = null;
                if(has_excerpt()) $excerpt = get_the_excerpt().'&nbsp;'; else $excerpt = wp_trim_words(get_the_content(), 18)."&nbsp;";
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'content' => get_the_content(),
                    'excerpt' => $excerpt,
                    'eventDate' => $eventDate,
                    'month' => $eventMonth,
                    'day' => $eventDay
                ));
            }
        }

    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));

    return $results;
}

add_action('rest_api_init', 'universityRegisterSearch');

?>