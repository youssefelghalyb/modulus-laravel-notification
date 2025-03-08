<?php

namespace Modulus\Notification\Facades;

use Illuminate\Support\Facades\Facade;
use Modulus\Notification\Contracts\NotificationServiceInterface;

/**
 * @method static bool email(string|array $to, string $title, string $body, ?string $image = null, ?array $button = null)
 * @method static bool sms(string|array $to, string $title, string $body)
 * @method static bool realtime(string|array $fcm, string $title, string $body, ?string $image = null)
 * @method static bool emailCustom(string $template, string|array $to, string $title, string $body, array $additional_data = [])
 *
 * @see \Modulus\Notification\Services\NotificationService
 */
class Notification extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NotificationServiceInterface::class;
    }
}