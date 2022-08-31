<?php

class Tooltip {
    function __construct() {
        $version = 1;
        add_action('admin_menu', [$this, 'adminPage']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('admin_init', [$this, 'settings']);
        add_action('wp_body_open', [$this, 'append_to_body']);
        wp_enqueue_style('tooltip-styles', plugin_dir_url(__FILE__) . 'assets/tooltip.css', array(), $version, false);
    }

    function settings() {
        add_settings_section('tt_tooltip_section', null, null, 'scottlind-tooltip-settings');
        
        add_settings_field('tt_text', __('Tekst ved højreklik:'), [$this, 'setting_text'], 'scottlind-tooltip-settings', 'tt_tooltip_section');
        register_setting('tooltip-plugin', 'tt_text', ['sanitize_callback' => 'sanitize_text_field', 'default' => __('Tooltip text.')]);
    }

    function setting_text() {
        ob_start();
            include(__DIR__."/admin_settings/setting_text.php");
        ob_end_flush(); 
    }

    function enqueue_scripts() {
        wp_enqueue_script( 'tooltip', plugin_dir_url(__FILE__) . 'assets/tooltip.js', [], $version, true );
    }

    function admin_enqueue_scripts() {
        wp_enqueue_script( 'tooltip', plugin_dir_url(__FILE__) . 'assets/tooltip.js', [], $version, true );
    }

    function enqueue_styles() {
        wp_enqueue_style('tooltip-styles', plugin_dir_url(__FILE__) . 'assets/tooltip.css', array(), filemtime(plugin_dir_url(__FILE__) . 'assets/tooltip.css'), false);
    }

    function adminPage() {
        add_options_page(__('Tooltip Indstillinger'), __('Tooltip'), 'manage_options', 'scottlind-tooltip-settings', [$this, 'renderAdminPage']);
    }

    function renderAdminPage() {
        ob_start();
            include(__DIR__."/views/tooltip_admin_page.php");
        ob_end_flush(); 
    }

    function sanitize_location($input) {
        if ( $input != 'top' AND $input != 'right' AND $input != 'bottom' AND $input != 'left') {
            add_settings_error('tt_location', 'tt_location_error', __('Teksten skal være af de fire valgmuligheder; over, til højre for, under eller til venstre for tekst.'));
            return get_option('tt_location');
        }
        return $input;
    }

    function append_to_body($input) {
        if ( is_admin() ) {
            return;
        }
        global $wpdb;
        $tooltop_text = $wpdb->get_var( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s", 'tt_text' ) );
        // $tooltop_location = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_name = 'tt_location'" );
        ?> 
        <script type="text/javascript">
            const tooltipText = "<?= html_entity_decode(esc_html($tooltop_text)) ?>";
        </script>
        <?php
    }

}

$tooltip = new Tooltip();