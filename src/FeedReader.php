<?php

namespace Wow\FeedReader;

use Wow\FeedReader\Factory\ProviderFactory;
use Wow\FeedReader\Validation\KeywordValidation;

/**
 * Class FeedReader
 */
class FeedReader extends AbstractFeedReader
{
    /**
     * This data can come with some other implementations
     *
     * @var array
     */
    const PROVIDERS = ['ebay'];

    /**
     * @var KeywordValidation
     */
    private $validator;

    /**
     * FeedReader constructor.
     */
    public function __construct()
    {
        $this->validator = new KeywordValidation();
    }

    /**
     * @param array $params
     * @return array
     */
    public function searchByKeyword(array $params)
    {
        $response = [];
        foreach (self::PROVIDERS as $provider) {
            $params['provider'] = $provider;
            $params['keywords'] = urlencode($params['keywords']);

            $params = $this->validator->validateParams($params);

            $provider = ProviderFactory::build($provider, $params);
            $result = $provider->searchByKeyword();

            $response = array_merge($response, $result);
        }

        return $response;
    }
}