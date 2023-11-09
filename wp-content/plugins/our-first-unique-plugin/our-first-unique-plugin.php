i<?php
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
        add_filter('the_content', array($this, 'ifWrap'));
    }

    function adminPage(){
        add_options_page("Word Count Settings", "Word Count", "manage_options", "word-count-settings-page", array($this, "ourHTML"));
    }

    function settings(){
        add_settings_section('wcp_first_section', null, array(), 'word-count-settings-page');
        /* Display Location */
        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));
        /* Headline Text */
        add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section', array());
        register_setting('word_count_plugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));
        /* Word Count */
        add_settings_field("wcp_wordcount", "Word Count", array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theId' => 'wcp_wordcount', "theTitle" => "Word Count"));
        register_setting('word_count_plugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
        /* Character count */
        add_settings_field("wcp_charcount", 'Character Count', array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theId' => 'wcp_charcount', "theTitle" => ""));
        register_setting('word_count_plugin', 'wcp_charcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
        /* Read time */
        add_settings_field("wcp_readtime", "Read Time", array($this, 'checkboxHTML'), 'word-count-settings-page', 'wcp_first_section', array('theId' => 'wcp_readtime', "theTitle" => "Read Time"));
        register_setting('word_count_plugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
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

    function sanitizeLocation($input){
        if($input != '0' AND $input != '1'){
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or end.');
            return get_option('wcp_location');
        }
        return $input;
    }

    function headlineHTML(){ ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option("wcp_headline")) ?>">
    <?php
    }

    function checkboxHTML($args){ ?>
	<input type="checkbox" name="<?php echo $args['theId'] ?>" value="1" <?php checked(get_option($args['theId']), '1') ?>>
    <?php
    }

    function ifWrap($content){
        if(is_main_query() AND is_single() AND
            (get_option('wcp_wordcount', '1') OR
            get_option('wcp_charcount', '1') OR
            get_option('wcp_readtime', '1')
        )){ return $this->createHTML($content); }
        return $content;
    }

    function createHTML($content){
        $html = "<h3>". esc_html(get_option('wcp_headline', 'Post Statistics'))."</h3><p>";
        /*
            get word count once because both wordcount and read time will need it.
        */
        if(get_option('wcp_wordcount', '1') == '1' OR get_option('wcp_readtime', '1') == '1')
            $wordCount = str_word_count(strip_tags($content));
        if(get_option('wcp_wordcount', '1') == '1')
            $html .= '<p>' . "This post has " . $wordCount . " words.<br/>";
        if(get_option('wcp_charcount', '1') == '1') {
            $charCount = mb_strlen(strip_tags($content));
            $html .= "This post has " . $charCount . " characters.<br/>";
        }
        if(get_option('wcp_readtime', '1') == '1'){
            $html .= "This post will take about " . round($wordCount/255, 1) . " minute(s) to read.</br>";
        }
        $html .= '</p>';
        if(get_option('wcp_location', '0') == 0)
            return $html . $content;
        return $content . $html;
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();

?>
