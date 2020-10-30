<?php

namespace RebelCode\Spotlight\Instagram\RestApi\EndPoints\Media;

use RebelCode\Spotlight\Instagram\IgApi\IgMedia;
use RebelCode\Spotlight\Instagram\PostTypes\MediaPostType;
use RebelCode\Spotlight\Instagram\RestApi\EndPoints\AbstractEndpointHandler;
use RebelCode\Spotlight\Instagram\Wp\PostType;
use WP_REST_Request;
use WP_REST_Response;

/**
 * The handler for the endpoint that provides media objects.
 *
 * @since 0.1
 */
class GetMediaEndPoint extends AbstractEndpointHandler
{
    /**
     * @since 0.1
     *
     * @var PostType
     */
    protected $mediaCpt;

    /**
     * Constructor.
     *
     * @since 0.1
     *
     * @param PostType $mediaCpt
     */
    public function __construct(PostType $mediaCpt)
    {
        $this->mediaCpt = $mediaCpt;
    }

    /**
     * @inheritDoc
     *
     * @since 0.1
     */
    protected function handle(WP_REST_Request $request)
    {
        $media = array_map([MediaPostType::class, 'fromWpPost'], $this->mediaCpt->query());

        usort($media, function (IgMedia $a, IgMedia $b) {
            $aTs = $a->timestamp;
            $bTs = $b->timestamp;

            if ($aTs == $bTs) {
                return 0;
            }

            if ($aTs === null) {
                return 1;
            }

            if ($bTs === null) {
                return -1;
            }

            return $aTs < $bTs ? 1 : -1;
        });

        return new WP_REST_Response(array_map([$this, 'postToResponse'], $media));
    }

    /**
     * Transforms an Ig Media instance into a response array
     *
     * @since 0.1
     *
     * @param IgMedia $media
     *
     * @return array
     */
    protected function postToResponse(IgMedia $media)
    {
        return [
            'id' => $media->id,
            'username' => $media->username,
            'caption' => $media->caption,
            'timestamp' => $media->timestamp,
            'type' => $media->type,
            'url' => $media->url,
            'permalink' => $media->permalink,
            'thumbnailUrl' => $media->thumbnail,
        ];
    }
}
