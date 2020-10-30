<?php

namespace RebelCode\Spotlight\Instagram\RestApi\EndPoints\Media;

use Dhii\Transformer\TransformerInterface;
use RebelCode\Spotlight\Instagram\Feeds\Feed;
use RebelCode\Spotlight\Instagram\MediaStore\MediaStore;
use RebelCode\Spotlight\Instagram\RestApi\EndPoints\AbstractEndpointHandler;
use WP_REST_Request;
use WP_REST_Response;

/**
 * The handler for the endpoint that fetches media from Instagram.
 *
 * @since 0.1
 */
class FetchMediaEndPoint extends AbstractEndpointHandler
{
    /**
     * @since 0.1
     *
     * @var MediaStore
     */
    protected $store;

    /**
     * @since 0.1
     *
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * Constructor.
     *
     * @since 0.1
     *
     * @param MediaStore           $store
     * @param TransformerInterface $transformer
     */
    public function __construct(MediaStore $store, TransformerInterface $transformer)
    {
        $this->store = $store;
        $this->transformer = $transformer;
    }

    /**
     * @inheritDoc
     *
     * @since 0.1
     */
    protected function handle(WP_REST_Request $request)
    {
        $options = $request->get_param('options');
        $feed = Feed::fromArray(['options' => $options]);

        $from = $request->get_param('from');
        $num = $request->get_param('num');
        $num = ($num === null) ? $feed->getOption('numPosts')['desktop'] : $num;

        [$media, $stories] = $this->store->getFeedMedia($feed, $num, $from);
        $total = $this->store->getNumMedia();

        $media = array_map([$this->transformer, 'transform'], $media);
        $stories = array_map([$this->transformer, 'transform'], $stories);

        $response = [
            'media' => $media,
            'stories' => $stories,
            'total' => $total,
        ];

        return new WP_REST_Response($response);
    }
}
