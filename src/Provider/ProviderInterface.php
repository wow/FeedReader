<?php


namespace Wow\FeedReader\Provider;

/**
 * Interface ProviderInterface
 */
interface ProviderInterface
{
    /**
     * @return array
     */
    public function searchByKeyword();
}