<?php
defined('ABSPATH') or die;

/**
 * Plugin Name: Tiny Forms
 * Description: Contact Form By Tiny Forms is the advanced Contact form plugin with drag and drop, multi column supported form builder plugin
 * Version: 6.1.7
 * Author: Contact Form - WPManageNinja LLC
 * Author URI: https://fluentforms.com
 * Plugin URI: https://wpmanageninja.com/wp-fluent-form/
 * License: GPLv2 or later
 * Text Domain: fluentform
 * Domain Path: /resources/languages
 */

defined('ABSPATH') or die;
defined('FLUENTFORM') or define('FLUENTFORM', true);
define('FLUENTFORM_DIR_PATH', plugin_dir_path(__FILE__));
define('FLUENTFORM_FRAMEWORK_UPGRADE', '4.3.22');
defined('FLUENTFORM_VERSION') or define('FLUENTFORM_VERSION', '6.1.7');
defined('FLUENTFORM_MINIMUM_PRO_VERSION') or define('FLUENTFORM_MINIMUM_PRO_VERSION', '6.0.0');

if (!defined('FLUENTFORM_HAS_NIA')) {
    define('FLUENTFORM_HAS_NIA', true);
}

// Disable plugin updates and update notices
$plugin_basename = plugin_basename(__FILE__);

// Remove plugin from update transients to prevent WordPress from showing available updates
add_filter('site_transient_update_plugins', function($transient) use ($plugin_basename) {
    if (isset($transient->response[$plugin_basename])) {
        unset($transient->response[$plugin_basename]);
    }
    return $transient;
}, 10, 1);

// Filter out update checks before they're saved to prevent update checks from being stored
add_filter('pre_set_site_transient_update_plugins', function($transient) use ($plugin_basename) {
    if (isset($transient->response[$plugin_basename])) {
        unset($transient->response[$plugin_basename]);
    }
    return $transient;
}, 10, 1);

// Remove update notices from plugins page
add_action('admin_init', function() use ($plugin_basename) {
    remove_action("after_plugin_row_{$plugin_basename}", 'wp_plugin_update_row', 10);
}, 10);

// Disable auto-updates for this plugin
add_filter('auto_update_plugin', function($update, $item) use ($plugin_basename) {
    if (isset($item->plugin) && $item->plugin === $plugin_basename) {
        return false; // Disable auto-updates
    }
    return $update;
}, 10, 2);

// Remove auto-update UI from plugins page
add_filter('plugin_auto_update_setting_html', function($html, $plugin_file) use ($plugin_basename) {
    if ($plugin_file === $plugin_basename) {
        return ''; // Remove auto-update checkbox
    }
    return $html;
}, 10, 2);

require __DIR__.'/vendor/autoload.php';

call_user_func(function($bootstrap) {
    $bootstrap(__FILE__);
}, require(__DIR__.'/boot/app.php'));


