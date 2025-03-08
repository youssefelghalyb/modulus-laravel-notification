<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for email templates and other email-related settings
    |
    */
    'email' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SMS providers
    |
    */
    'sms' => [
        'default' => env('SMS_DRIVER', 'twilio'),
        
        'drivers' => [
            'twilio' => [
                'sid' => env('TWILIO_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_FROM_NUMBER'),
            ],
            
            'vonage' => [
                'api_key' => env('VONAGE_API_KEY'),
                'api_secret' => env('VONAGE_API_SECRET'),
                'from' => env('VONAGE_FROM_NUMBER', 'VONAGE'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Push Notification Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for push notification providers
    |
    */
    'push' => [
        'fcm' => [
            'server_key' => env('FCM_SERVER_KEY'),
        ],
    ],
];