<?php

namespace App\Payment\Gateway;

use XenditCtPHPClient;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 *
 */
class Xendit
{
    protected $xendit;

    public function __construct()
    {
        $this->client = new Client([
          // Base URI is used with relative requests
          'base_uri' => config('payments.url'),
          // You can set any number of default request options.
          'timeout'  => 500,

          // HeaderSecurity
          'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ]
        ]);
    }

    public function createInvoice($id, $amount)
    {
        $query = [
        'auth'=> [config('payments.dev.secret_key'),'password'],
        'json' => [
            'external_id' => $id,
            'amount'  => $amount,
            'payer_email' => auth()->user()->email,
            'description' => 'Invoice - '.$id
        ]
      ];

         $response = $this->client->request('POST', 'v2/invoices', $query);

        return json_decode($response->getBody(), true);
    }
}
