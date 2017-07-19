<?php

namespace Wow\FeedReader\Validation;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wow\FeedReader\FeedReader;

/**
 * Class KeywordValidation
 */
class KeywordValidation
{
    /**
     * @param array $params
     * @return array
     */
    public function validateParams(array $params)
    {
        $resolver = new OptionsResolver();
        $this->validate($resolver);

        return $resolver->resolve($params);
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function validate(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'price_min' => 10,
            'price_max' => 100000000,
            'sorting' => 'BestMatch',
        ]);

        $resolver->setRequired([
            'keywords',
            'provider',
        ]);

        $resolver->setAllowedValues('provider', FeedReader::PROVIDERS);
    }
}