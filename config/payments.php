<?php

return [
    'default' => env('DEFAULT_PAYMENT', 'xendit'),
    'url' => env('URL_XENDIT'),
    'dev' => [
      'public_key' => env('PUBLIC_KEY_XENDIT_DEV'),
      'secret_key' => env('SECRET_KEY_XENDIT_DEV'),
      'validation_token' => env('VALIDATION_TOKEN_XENDIT_DEV'),
    ],
    'live' => [
      'public_key' => env('PUBLIC_KEY_XENDIT_DEV'),
      'secret_key' => env('SECRET_KEY_XENDIT_DEV'),
      'validation_token' => env('VALIDATION_TOKEN_XENDIT_DEV'),
    ]
];
