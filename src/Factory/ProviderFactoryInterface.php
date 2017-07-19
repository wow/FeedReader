<?php

namespace Wow\FeedReader\Factory;

use Wow\FeedReader\Provider\ProviderInterface;

/**
 * Interface ProviderFactoryInterface
 */
interface ProviderFactoryInterface
{
    /**
     * @param string $provider
     *
     * @param array $params
     * @return ProviderInterface
     */
    public static function build($provider,array $params);
}
