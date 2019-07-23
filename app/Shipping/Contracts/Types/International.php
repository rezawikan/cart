<?php

namespace App\Shipping\Types;

use App\Shipping\Contracts\ShippingMethod;
use App\Http\Resources\ShippingResource;
use GuzzleHttp\Client;

/**
 *
 */
class International extends ShippingMethod
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Default is nuLL
     * param 'id' is province ID (OPTIONAL)
     * @param array
     * @return json
     */
    public function getProvince(array $data = [])
    {
        $query = [
        'query' => [
          'key' => config('shipping.key')
        ]
      ];

        if (!empty($data['id'])) {
            $query['query']['id'] = $data['id'];
        }

        $response = $this->client->request('GET', 'https://pro.rajaongkir.com/api/province', $query);

        return json_decode($response->getBody(), true);
    }

    /**
     * Default is nuLL
     * param 'id' is Region ID (OPTIONAL)
     * param 'province' is province ID (OPTIONAL)
     * @param array
     * @return json
     */
    public function getCity(array $data = [])
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

        $response = $this->client->request('GET', 'https://pro.rajaongkir.com/api/city', $query);

        return json_decode($response->getBody(), true);
    }

    /**
     * Default is nuLL
     * param 'city' is Region ID (REQUIRED)
     * param 'id' is Subdistrict ID (OPTIONAL)
     * @param array
     * @return json
     */
    public function getSubdistrict(array $data = [])
    {
        $query = [
        'query' => [
          'key' => config('shipping.key'),
          'city' => $data['city']
        ]
      ];

        if (!empty($data['id'])) {
            $query['query']['id'] = $data['id'];
        }

        $response = $this->client->request('GET', 'https://pro.rajaongkir.com/api/subdistrict', $query);

        return json_decode($response->getBody(), true);
    }

    public function getCost(array $data)
    {
        $query = [
          'form_params' => [
            'key' => config('shipping.key'),
            'origin' => config('shipping.international_origin_city_id'),
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
