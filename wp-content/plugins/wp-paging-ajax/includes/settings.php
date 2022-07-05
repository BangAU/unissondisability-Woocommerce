<?php
/**
 * setings.php
 *
 * @package:
 * @since: 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('admin_menu', 'wppa_add_admin_menu');
add_action('admin_init', 'wppa_settings_init');

function wppa_add_admin_menu()
{

    add_options_page('WP Paging Ajax', 'WP Paging Ajax', 'manage_options', 'wp_paging_ajax', 'wppa_options_page');

}

function wwppa_get_setting($key, $default)
{
    $wppa_settings = get_option('wppa_settings');
    if (isset($wppa_settings[$key]) && !empty($wppa_settings[$key])) {
        return $wppa_settings[$key];
    }

    return $default;
}


function wppa_settings_init()
{
    register_setting('pluginPage', 'wppa_settings');
}

function wppa_settings_fields()
{
    register_setting('pluginPage', 'wppa_settings');


    $main_selector = wwppa_get_setting('main_selector', '#main');
    $paging_class_name = wwppa_get_setting('paging_class_name', 'page-numbers');
    ?>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row"><?php _e('Main selector', 'wppa'); ?></th>
            <td><input type="text" name="wppa_settings[main_selector]" value="<?php echo $main_selector; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Paging class name', 'wppa'); ?></th>
            <td><input type="text" name="wppa_settings[paging_class_name]" value="<?php echo $paging_class_name; ?>">
            </td>
        </tr>
        </tbody>
    </table>
    <?php


}


function wppa_options_page()
{

    ?>
    <form action='options.php' method='post'>

        <h2><?php _e('WP Paging Ajax', 'wppa'); ?></h2>

        <?php
        settings_fields('pluginPage');
        wppa_settings_fields();
        submit_button();
        ?>

    </form>
    <?php

}