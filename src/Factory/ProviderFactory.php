<?php

namespace Wow\FeedReader\Factory;

use Doctrine\Common\Inflector\Inflector;
use Wow\FeedReader\Exception\NotFoundResourceException;

/**
 * Class ProviderFactory
 */
class ProviderFactory implements ProviderFactoryInterface
{
    /**
     * @inheritdoc
     */
    public static function build($provider, array $params)
    {
        $providerName = Inflector::classify($provider);

        $class = 'Wow\\FeedReader\\Provider\\'.$providerName.'\\'.$providerName.'Provider';

        if (class_exists($class)) {
            return new $class($params);
        }

        throw new NotFoundResourceException(sprintf("Provider Class %s not found", $class));
    }
}
