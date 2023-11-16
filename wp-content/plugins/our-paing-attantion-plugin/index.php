<?php 
/*
* Plugin Name: Are You Paying Attention Quiz
* Description: Give your readers a multiple choice question.
* Version: 1.0
* Author: ga1robe
* Author URI: http://kreatywne-media.pl
*/
if(!defined('ABSPATH')) exit(); /* Exit if accessed directly */

class OurPayingAttention {
    function __construct(){
        // add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets(){
        wp_register_style('quiz_edit_css', plugin_dir_url(__FILE__).'build/index.css', array(), false, 'all');
        // wp_enqueue_script('our_new_block_type', plugin_dir_url(__FILE__).'build/index.js', array('wp-blocks', 'wp-element'), false, array());
        wp_register_script('our_new_block_type', plugin_dir_url(__FILE__).'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'), false, array());
        register_block_type('ourplugin/our-paying-attention', array('editor_script' => 'our_new_block_type', 'editor_style' => 'quiz_edit_css', 'render_callback' => array($this, 'theHTML')));
    }

    /* Alternative Case */
    // function theHTML($attributes){ return '<h3>Today the sky is completely '.esc_html($attributes['skyColor']).' and the grass is '.esc_html($attributes['grassColor']).'!!!</h3>'; }

    function theHTML($attributes){
        if(!is_admin()){
            wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__).'build/frontend.js', array('wp-element'));
            wp_enqueue_style('attentionFrontendStyles', plugin_dir_url(__FILE__).'build/frontend.css', array(), false, 'all');
        }
        ob_start(); ?><div class="paying-attention-update-me"></div><?php return ob_get_clean();
    }
    // 
}

$ourPayingAttention = new OurPayingAttention();
?>