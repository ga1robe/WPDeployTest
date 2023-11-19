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
        register_block_type(__DIR__, array('render_callback' => array($this, 'theHTML')));
    }

    /* Alternative Case */
    // function theHTML($attributes){ return '<h3>Today the sky is completely '.esc_html($attributes['skyColor']).' and the grass is '.esc_html($attributes['grassColor']).'!!!</h3>'; }

    function theHTML($attributes){
        // if(!is_admin()) wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__).'build/frontend.js', array('wp-element'));
        ob_start(); ?><div class="paying-attention-update-me"><pre style="display: none;"><?php echo wp_json_encode($attributes) ?></pre></div><?php return ob_get_clean();
    }
    // 
}

$ourPayingAttention = new OurPayingAttention();
?>