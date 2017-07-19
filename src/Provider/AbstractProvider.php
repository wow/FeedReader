<?php

namespace Wow\FeedReader\Provider;

/**
 * Class AbstractProvider
 */
abstract class AbstractProvider
{
    protected $endpoint = '';
    protected $appID = '';

    /**
     * @param array $options
     * @return string
     */
    protected function sendRequest(array $options = [], $filters)
    {
        return simplexml_load_file($this->endpoint.'?'.http_build_query($options).$filters);
    }
}