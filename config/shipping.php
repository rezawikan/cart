<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shipping
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    /**
    * Denpasar => 114
    */
    'international_origin_city_id' => env('APP_INTERNATIONAL_ORIGIN', 114),

    /**
    * pos, tiki, jne, slis, expedito
    */
    // 'international_courier' => 'pos:tiki:jne:slis:expedito',

    /**
    * Denpasar Barat => 114
    */
    'national_subdistrict_id' => env('APP_NATIONAL_ORIGIN', 1573),

    /**
    * jne, pos, tiki,
    * rpx, esl, pcp,
    * pandu, wahana, sicepat,
    * jnt, pahala, cahaya,
    * sap, jet, indah,
    * dse, slis, first,
    * ncs, star, ninja, lion, idl
    */
    // 'national_courier' => 'jne:post:tiki:jnt',

    'key' => 'da06ea1541fd27c887829f63b8a05fba'
];
