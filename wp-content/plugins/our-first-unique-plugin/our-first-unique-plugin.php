<?php
/*
* Plugin Name: Our Test Plugin
* Description: A truly amazing plugin.
* Verstion: 1.0
* Author: ga1robe
* Author URI: http://kreatywne-media.pl/graphics-training/
*/

class WordCountAndTimePlugin {
    function __construct() {
        add_action('admin_menu',array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings(){
        add_settings_section('wcp_first_section', null, array(), 'word-count-settings-page');
        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

        add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));
        /* Word count */
        add_settings_field('wcp_wordcount', 'Word Count', array($this, 'WordcountHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
        /* Character count */
        add_settings_field('wcp_charcount', 'Character Count', array($this, 'CharcountHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_charcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
        /* Read time */
        add_settings_field('wcp_readtime', 'Read time', array($this, 'ReadtimeHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }

    function adminPage(){
        add_options_page("Word Count Settings", "Word Count", "manage_options", "word-count-settings-page", array($this, "ourHTML"));
    }

    function ourHTML(){ ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php
                settings_fields("word_count_plugin");
                do_settings_sections('word-count-settings-page');
                submit_button()
                ?>
            </form>
        </div>
    <?php
    }

    function locationHTML(){ ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option("wcp_location"), '0') ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option("wcp_location"), '1') ?>>End of post</option>
        </select>
    <?php
    }

    function headlineHTML(){ ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option("wcp_headline")) ?>">
    <?php
    }

    function WordcountHTML(){ ?>
        <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option("wcp_wordcount"), '1') ?>>
    <?php
    }

    function CharcountHTML(){ ?>
        <input type="checkbox" name="wcp_charcount" value="1" <?php checked(get_option("wcp_charcount"), '1') ?>>
    <?php
    }

    function ReadtimeHTML(){ ?>
        <input type="checkbox" name="wcp_readtime" value="1" <?php checked(get_option("wcp_readtime"), '1') ?>>
    <?php
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();

?>