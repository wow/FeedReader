<?php

namespace Wow\FeedReader\Provider\Ebay;

use Wow\FeedReader\Provider\ProviderInterface;
use Wow\FeedReader\Provider\AbstractProvider;

/**
 * Class EbayProvider
 */
class EbayProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $endpoint = 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';

    /**
     * @var string
     */
    protected $appID = 'WandoInt-217b-42d8-a699-e79808dd505e';

    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @inheritdoc
     */
    public function searchByKeyword()
    {
        $options = $this->getOptions();
        $filters = $this->getFilters();
        $response = parent::sendRequest($options, $filters);

        if ($response->ack == "Success") {
            return $this->buildResponse($response);
        }

        return [];
    }

    /**
     * @return array
     */
    private function getOptions()
    {
        return [
            'OPERATION-NAME' => 'findItemsByKeywords',
            'SERVICE-VERSION' => '1.0.0',
            'SECURITY-APPNAME' => $this->appID,
            'RESPONSE-DATA-FORMAT' => 'XML',
            'REST-PAYLOAD' => null,
            'sortOrder' => $this->params['sorting'],
            'GLOBAL-ID' => 'EBAY-US',
            'paginationInput.entriesPerPage' => '100',
            'keywords' => $this->params['keywords'],
        ];
    }

    /**
     * @return string
     */
    private function getFilters()
    {
        $filters = [
            'itemFilter(0).name' => 'MinPrice',
            'itemFilter(0).value' => $this->params['price_min'],
            'itemFilter(0).paramName' => 'Currency',
            'itemFilter(0).paramValue' => 'USD',
            'itemFilter(1).name' => 'MaxPrice',
            'itemFilter(1).value' => $this->params['price_max'],
            'itemFilter(1).paramName' => 'Currency',
            'itemFilter(1).paramValue' => 'USD',
            'outputSelector(0)' => 'AspectHistogram',
        ];

        $urlFilter = null;
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $j => $content) {
                    $urlFilter .= "&$key=$content";
                }
            } elseif ($value != "") {
                $urlFilter .= "&$key=$value";
            }
        }

        return $urlFilter;
    }

    /**
     * @param object $response
     * @return array
     */
    private function buildResponse($response)
    {
        $data = [];
        foreach ($response->searchResult->item as $item)
        {
            $picture = $item->galleryURL ?? '';

            $data[] = [
                'provider' => $this->params['provider'],
                'item_id' => $item->itemId->__toString(),
                'click_out_link' => $item->viewItemURL->__toString(),
                'main_photo_url' => $picture,
                'price' => $item->sellingStatus->currentPrice->__toString(),
                'price_currency' => 'USD',
                'shipping_price' => $item->shippingInfo->shippingServiceCost->__toString(),
                'title' => $item->title->__toString(),
                'description' => '',
                'valid_until' => $item->listingInfo->endTime->__toString(),
                'brand' => '',
            ];
        }

        return $data;
    }
}