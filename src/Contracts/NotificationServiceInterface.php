<?php

namespace Modulus\Notification\Contracts;

interface NotificationServiceInterface
{
    /**
     * Send email notification
     */
    public static function email(
        string|array $to,
        string $title,
        string $body,
        ?string $image = null,
        ?array $button = null
    ): bool;

    /**
     * Send SMS notification
     */
    public static function sms(
        string|array $to,
        string $title,
        string $body
    ): bool;

    /**
     * Send realtime notification (FCM)
     */
    public static function realtime(
        string|array $fcm,
        string $title,
        string $body,
        ?string $image = null
    ): bool;

    /**
     * Send custom email notification
     */
    public static function emailCustom(
        string $template,
        string|array $to,
        string $title,
        string $body,
        array $additional_data = []
    ): bool;
}