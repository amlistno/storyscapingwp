<?php

namespace RebelCode\Spotlight\Instagram\Actions;

use RebelCode\Spotlight\Instagram\MediaStore\MediaStore;
use RebelCode\Spotlight\Instagram\PostTypes\FeedPostType;
use RebelCode\Spotlight\Instagram\Utils\Arrays;
use RebelCode\Spotlight\Instagram\Wp\PostType;
use WP_Post;

/**
 * The action that imports media for all saved accounts.
 *
 * @since 0.1
 */
class ImportMediaAction
{
    /**
     * @since 0.1
     *
     * @var PostType
     */
    protected $cpt;

    /**
     * @since 0.1
     *
     * @var MediaStore
     */
    protected $store;

    /**
     * Constructor.
     *
     * @since 0.1
     *
     * @param PostType   $cpt   The feeds post type.
     * @param MediaStore $store The media store.
     */
    public function __construct(PostType $cpt, MediaStore $store)
    {
        $this->cpt = $cpt;
        $this->store = $store;
    }

    /**
     * @since 0.1
     */
    public function __invoke()
    {
        $feeds = $this->cpt->query();

        Arrays::each($feeds, function (WP_Post $post) {
            $this->store->getFeedMedia(FeedPostType::fromWpPost($post));
        });
    }
}
