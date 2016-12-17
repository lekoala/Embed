<?php

namespace Embed\Adapters;

use Embed\Http\Request;
use Embed\Utils;
use Embed\Providers\Api;

/**
 * Adapter to provide information from archive.org API.
 */
class Archive extends Webpage implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function check(Request $request)
    {
        $response = $request->getResponse();

        return $response->isValid() && $response->getUri()->match([
            'archive.org/details/*',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(Request $request, array $config = [])
    {
        parent::__construct($request, $config);

        $this->providers = ['archive' => new Api\Archive($this)] + $this->providers;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return Utils::iframe(str_replace('/details/', '/embed/', $this->url), $this->width, $this->height);
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return 640;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return 480;
    }
}
