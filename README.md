# Laravel Notification Package

A comprehensive Laravel package for sending notifications via Email, SMS (Twilio, Vonage), and push notifications (Firebase Cloud Messaging).

## Features

- Email notifications with customizable templates
- SMS notifications via Twilio or Vonage
- Push notifications via Firebase Cloud Messaging (FCM)
- Simple, clean API
- Customizable and extendable
- Laravel integration with config publishing

## Installation

You can install the package via composer:

```bash
composer require modulus/laravel-notification
```

### Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Modulus\Notification\Providers\NotificationServiceProvider" --tag="notification-config"
```

Optionally, you can publish the views:

```bash
php artisan vendor:publish --provider="Modulus\Notification\Providers\NotificationServiceProvider" --tag="notification-views"
```

### Environment Configuration

Add the following variables to your `.env` file and set as needed:

```
# Email Configuration (Using Laravel's mail configuration)
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="Your Name"

# SMS Configuration - Twilio
SMS_DRIVER=twilio
TWILIO_SID=your-twilio-sid
TWILIO_AUTH_TOKEN=your-twilio-auth-token
TWILIO_FROM_NUMBER=your-twilio-phone-number

# SMS Configuration - Vonage
# SMS_DRIVER=vonage
VONAGE_API_KEY=your-vonage-api-key
VONAGE_API_SECRET=your-vonage-api-secret
VONAGE_FROM_NUMBER=your-vonage-phone-number

# Push Notification - Firebase Cloud Messaging
FCM_SERVER_KEY=your-fcm-server-key
```

## Usage

### Send an Email

```php
use Modulus\Notification\Facades\Notification;

// Basic email
Notification::email(
    'recipient@example.com',  
    'Welcome!',
    'Welcome to our platform',
    'https://example.com/path/to/image.jpg', // Optional image
    [                    
        'text' => 'Verify Email',  // Button text
        'url' => 'https://example.com/verify'  // Button URL
    ]  // Optional button
);

// Multiple recipients
Notification::email(
    ['user1@example.com', 'user2@example.com'],
    'Team Update',
    'Important update for the team',
);

// Custom email template
Notification::emailCustom(
    'notification::emails.order-confirmation', 
    'customer@example.com',                    
    'Order Confirmation - #12345',           
    'Thank you for your order! Here are your order details:', 
    [
        'company_logo' => 'https://yourcompany.com/logo.png',
        'company_name' => 'Your Company',
        'company_email' => 'support@yourcompany.com',
        'company_phone' => '+1 (555) 123-4567',
        'order_url' => 'https://yourcompany.com/orders/12345',
        'order' => [
            'number' => '12345',
            'items' => [
                [
                    'name' => 'Product 1',
                    'quantity' => 2,
                    'price' => 29.99
                ],
                [
                    'name' => 'Product 2',
                    'quantity' => 1,
                    'price' => 49.99
                ]
            ],
            'total' => 109.97,
            'shipping_address' => [
                'street' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'country' => 'United States'
            ]
        ]
    ]
);
```

### Send an SMS

```php
use Modulus\Notification\Facades\Notification;

// Send SMS to a single recipient
Notification::sms(
    '+1234567890',
    'OTP Code',
    'Your verification code is: 123456'
);

// Send to multiple recipients
Notification::sms(
    ['+1234567890', '+0987654321'],
    'Sale Alert',
    'Our annual sale starts tomorrow! Use code SUMMER20 for 20% off.'
);
```

### Send a Push Notification

```php
use Modulus\Notification\Facades\Notification;

// Send FCM notification to a single device
Notification::realtime(
    'fcm-device-token-here',
    'New Message',
    'You have received a new message from John',
    'https://example.com/path/to/image.jpg' // Optional image
);

// Send to multiple devices
Notification::realtime(
    ['device-token-1', 'device-token-2'],
    'Breaking News',
    'Check out the latest updates on our platform'
);
```

## Creating Custom Email Templates

1. Publish the package views
2. Create a new Blade template in `resources/views/vendor/notification/emails/`
3. Use the template in your code:

```php
Notification::emailCustom(
    'notification::emails.your-custom-template',
    'recipient@example.com',
    'Email Subject',
    'Email Body',
    [
        // Additional data that will be available in your template
    ]
);
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.