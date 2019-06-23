<?php

namespace App\Shipping\Types;

use App\Shipping\Contracts\ShippingMethod;
use App\Http\Resources\ShippingResource;
use GuzzleHttp\Client;
use App\Shipping\ShippingTraits;

/**
 *
 */
class International extends ShippingMethod
{
    use ShippingTraits;

    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Default is nuLL
     * param 'id' is Region ID (OPTIONAL)
     * param 'province' is province ID (OPTIONAL)
     * @param array
     * @return json
     */
    public function getOrigin(array $data = [])
    {
        $query = [
          'query' => [
            'key' => config('shipping.key')
          ]
        ];

        if (!empty($data['id'])) {
            $query['query']['id'] = $data['id'];
        }

        if (!empty($data['province'])) {
            $query['query']['province'] = $data['province'];
        }

        $response = $this->client->request('GET', 'https://pro.rajaongkir.com/api/v2/internationalOrigin', $query);

        return json_decode($response->getBody(), true);
    }

    /**
     * Default is nuLL
     * param 'id' is ID Country (OPTIONAL)
     * @param array
     * @return json
     */
    public function getDestination(array $data = [])
    {
        $query = [
          'query' => [
            'key' => config('shipping.key')
          ]
        ];

        if (!empty($data['id'])) {
            $query['query']['id'] = $data['id'];
        }

        $response = $this->client->request('GET', 'https://pro.rajaongkir.com/api/v2/internationalDestination', $query);

        return json_decode($response->getBody(), true);
    }

    public function getCost(array $data)
    {
        $query = [
          'form_params' => [
            'key' => config('shipping.key'),
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'courier' => config('shipping.international_courier'),
            'weight' => $data['weight']
          ]
        ];

        if (!empty($data['length'])) {
            $query['form_params']['length'] = $data['length'];
        }

        if (!empty($data['width'])) {
            $query['form_params']['width'] = $data['width'];
        }

        if (!empty($data['height'])) {
            $query['form_params']['height'] = $data['height'];
        }

        $response = $this->client->request('POST', 'https://pro.rajaongkir.com/api/v2/internationalCost', $query);

        return json_decode($response->getBody(), true);
    }
}
