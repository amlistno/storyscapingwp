<?php

/*
 * @wordpress-plugin
 *
 * Plugin Name: Spotlight - Social Media Feeds
 * Description: Easily embed beautiful Instagram feeds on your WordPress site.
 * Version: 0.4.1
 * Author: RebelCode
 * Plugin URI: https://spotlightwp.com
 * Author URI: https://rebelcode.com
 * Requires at least: 5.0
 * Requires PHP: 7.1
 *
   */

use RebelCode\Spotlight\Instagram\Plugin;

// If not running within a WordPress context, or the plugin is already running, stop
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/init.php';

slInstaRunPlugin(__FILE__, function (SlInstaRuntime $sli) {
    // Define plugin constants, if not already defined
    if (!defined('SL_INSTA')) {
        // Used to detect the plugin
        define('SL_INSTA', true);
        // The plugin name
        define('SL_INSTA_NAME', 'Spotlight - Social Media Feeds');
        // The plugin version
        define('SL_INSTA_VERSION', '0.4.1');
        // The path to the plugin's main file
        define('SL_INSTA_FILE', __FILE__);
        // The dir to the plugin's directory
        define('SL_INSTA_DIR', __DIR__);
        // The minimum required PHP version
        define('SL_INSTA_PLUGIN_NAME', 'Spotlight - Social Media Feeds');
        // The minimum required PHP version
        define('SL_INSTA_MIN_PHP_VERSION', '7.1');
        // The minimum required WordPress version
        define('SL_INSTA_MIN_WP_VERSION', '5.0');

        // Dev mode constant that controls whether development tools are enabled
        if (!defined('SL_INSTA_DEV')) {
            define('SL_INSTA_DEV', false);
        }
    }

    // If a PRO version is running and the free version is not, show a notice
    if ($sli->isProActive && !$sli->isFreeActive) {
        add_action('admin_notices', 'slInstaRequireFreeNotice');

        return;
    }

    if ($sli->isFreeActive && $sli->isProActive && version_compare($sli->freeVersion, $sli->proVersion, '!=')) {
        add_action('admin_notices', 'slInstaVersionMismatch');

        return;
    }

    // Stop if dependencies aren't satisfied
    if (!slInstaDepsSatisfied()) {
        return;
    }

    // Load the autoloader - loaders all the way down!
    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require __DIR__ . '/vendor/autoload.php';
    }

    // Load Freemius
    if (function_exists('sliFreemius')) {
        sliFreemius()->set_basename(true, __FILE__);
    } else {
        require_once __DIR__ . '/freemius.php';
    }

    // Load the PRO script, if it exists
    if (file_exists(__DIR__ . '/includes/pro.php')) {
        require_once __DIR__ . '/includes/pro.php';
    }

    /**
     * Retrieves the plugin instance.
     *
     * @since 0.2
     *
     * @return Plugin
     */
    function spotlightInsta()
    {
        static $instance = null;

        return ($instance === null)
            ? $instance = new Plugin(__FILE__)
            : $instance;
    }

    // Run the plugin
    add_action('plugins_loaded', function () {
        try {
            spotlightInsta()->run();
        } catch (Throwable $exception) {
            wp_die(
                $exception->getMessage() . "\n<pre>" . $exception->getTraceAsString() . '</pre>',
                SL_INSTA_PLUGIN_NAME . ' | Error',
                [
                    'back_link' => true,
                ]
            );
        }
    });
});
