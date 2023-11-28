<?php
function universityLikeRoutes(){
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($data){
    date_default_timezone_set('Europe/Warsaw');
    $date = date('c');
    if(is_user_logged_in()){
        $professor = sanitize_text_field($data['professor_id']);
        $existQuery = new WP_Query([
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => [
                [
                'key' => 'liked_professor_id',
                'compare' => '==',
                'value' => $professor
                ]
            ]
        ]);
        if($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor'){
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'Professor(id='.$professor.') Like on '.$date.'',
                'meta_input' => array(
                    'liked_professor_id' => $professor,
                )
            ));
        } else { die("Invalid professor ID"); }
    } else
        die("Only logged in user can create a like.");
}

function deleteLike($data){
    $likeId = sanitize_text_field($data['like']);
    if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like'){
        wp_delete_post($likeId, true);
        return "Success. Delete that [".$likeId."].";
    } else
        die("This action do not have permission to delete that.");
}

add_action('rest_api_init', 'universityLikeRoutes')
?>