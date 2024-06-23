<?php
/**
 * Plugin Name: List Plugins and Themes
 * Description: Lists all plugins and themes with their names, slugs, status, versions, and WordPress core version.
 * Version: 1.1
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook for the admin menu
add_action('admin_menu', 'lpt_add_admin_menu');

function lpt_add_admin_menu() {
    add_management_page('List Plugins & Themes', 'Plugins & Themes', 'manage_options', 'list-plugins-themes', 'lpt_display_page');
}

function lpt_enqueue_scripts($hook) {
    if ($hook !== 'tools_page_list-plugins-themes') {
        return;
    }
    wp_enqueue_style('lpt_styles', plugin_dir_url(__FILE__) . 'css/lpt_styles.css');
    wp_enqueue_script('lpt_scripts', plugin_dir_url(__FILE__) . 'js/lpt_scripts.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'lpt_enqueue_scripts');

function lpt_display_page() {
    ?>
    <div class="wrap">
        <h1>List of Plugins and Themes</h1>
        <h2>WordPress Version: <?php echo get_bloginfo('version'); ?></h2>
        <h2>Plugins</h2>
        <table class="widefat sortable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Version</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $all_plugins = get_plugins();
                foreach ($all_plugins as $plugin_file => $plugin_data) {
                    $plugin_status = is_plugin_active($plugin_file) ? 'Active' : 'Inactive';
                    echo '<tr>';
                    echo '<td>' . esc_html($plugin_data['Name']) . '</td>';
                    echo '<td>' . esc_html(dirname($plugin_file)) . '</td>';
                    echo '<td>' . esc_html($plugin_status) . '</td>';
                    echo '<td>' . esc_html($plugin_data['Version']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        
        <h2>Themes</h2>
        <table class="widefat sortable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Version</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $themes = wp_get_themes();
                foreach ($themes as $theme_slug => $theme_data) {
                    $theme_status = wp_get_theme()->get('Name') == $theme_data->get('Name') ? 'Active' : 'Inactive';
                    echo '<tr>';
                    echo '<td>' . esc_html($theme_data->get('Name')) . '</td>';
                    echo '<td>' . esc_html($theme_slug) . '</td>';
                    echo '<td>' . esc_html($theme_status) . '</td>';
                    echo '<td>' . esc_html($theme_data->get('Version')) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
