<?php

namespace App\Shipping;
/**
 *
 */
trait ShippingTraits
{
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
}
