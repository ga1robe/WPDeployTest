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
        add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
    }

    function adminAssets(){
        wp_enqueue_script('our_new_block_type', plugin_dir_url(__FILE__).'test.js', array('wp-blocks', 'wp-element'), false, array());
    }
}

$ourPayingAttention = new OurPayingAttention();
?>