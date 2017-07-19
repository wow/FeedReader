<?php

namespace Wow\FeedReader;

/**
 * Class AbstractFeedReader
 */
abstract class AbstractFeedReader
{
    /**
     * @param array $params
     * @return array
     */
    abstract public function searchByKeyword(array $params);
}