<?php

namespace RebelCode\Spotlight\Instagram\Modules;

use Dhii\Services\Factories\GlobalVar;
use Dhii\Services\Factories\Value;
use Psr\Container\ContainerInterface;
use RebelCode\Spotlight\Instagram\Module;
use RebelCode\Spotlight\Instagram\Utils\Arrays;
use RebelCode\Spotlight\Instagram\Wp\CronJob;
use RebelCode\Spotlight\Instagram\Wp\Menu;
use RebelCode\Spotlight\Instagram\Wp\PostType;
use RebelCode\Spotlight\Instagram\Wp\Shortcode;

/**
 * A module that contains services for various WordPress objects.
 *
 * @since 0.1
 */
class WordPressModule extends Module
{
    /**
     * @inheritDoc
     *
     * @since 0.1
     */
    public function getFactories() : array
    {
        return [
            'db' => new GlobalVar('wpdb'),
            'post_types' => new Value([]),
            'cron_jobs' => new Value([]),
            'shortcodes' => new Value([]),
            'widgets' => new Value([]),
            'menus' => new Value([]),
            'block_types' => new Value([]),
        ];
    }

    /**
     * @inheritDoc
     *
     * @since 0.1
     */
    public function getExtensions() : array
    {
        return [];
    }

    /**
     * @inheritDoc
     *
     * @since 0.1
     */
    public function run(ContainerInterface $c)
    {
        add_action('init', function () use ($c) {
            // Register the CPTs
            Arrays::each($c->get('post_types'), [PostType::class, 'register']);

            // Register the cron jobs
            Arrays::each($c->get('cron_jobs'), [CronJob::class, 'register']);

            // Register the shortcodes
            Arrays::each($c->get('shortcodes'), [Shortcode::class, 'register']);

            // Register the block types
            Arrays::each($c->get('block_types'), 'register_block_type');
        }, 0);

        // Registers the menus for the WP Admin sidebar
        add_action('admin_menu', function () use ($c) {
            Arrays::each($c->get('menus'), [Menu::class, 'register']);
        });

        // Registers the widget
        add_action('widgets_init', function () use ($c) {
            Arrays::each($c->get('widgets'), 'register_widget');
        });
    }
}
