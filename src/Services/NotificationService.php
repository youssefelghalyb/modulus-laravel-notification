<?php

namespace Modulus\Notification\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Modulus\Notification\Services\Channels\EmailChannel;
use Modulus\Notification\Services\Channels\SmsChannel;
use Modulus\Notification\Services\Channels\RealtimeChannel;

class NotificationService extends BaseNotificationService
{
    /**
     * Send email notification.
     *
     * @param string|array $to
     * @param string $title
     * @param string $body
     * @param string|null $image
     * @param array|null $button
     * @return bool
     */
    public static function email(
        string|array $to,
        string $title,
        string $body,
        ?string $image = null,
        ?array $button = null
    ): bool {
        try {
            $recipients = self::validateRecipients($to);
            $normalizedImage = self::normalizeImage($image);
            $normalizedButton = self::normalizeButton($button);

            return (new EmailChannel())->send([
                'to' => $recipients,
                'title' => $title,
                'body' => $body,
                'image' => $normalizedImage,
                'button' => $normalizedButton,
                'template' => 'notification::emails.default'
            ]);
        } catch (Exception $e) {
            Log::error('Email notification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send SMS notification.
     *
     * @param string|array $to
     * @param string $title
     * @param string $body
     * @return bool
     */
    public static function sms(
        string|array $to,
        string $title,
        string $body
    ): bool {
        try {
            $recipients = self::validateRecipients($to);

            return (new SmsChannel())->send([
                'to' => $recipients,
                'title' => $title,
                'body' => $body
            ]);
        } catch (Exception $e) {
            Log::error('SMS notification failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send realtime notification (FCM).
     *
     * @param string|array $fcm
     * @param string $title
     * @param string $body
     * @param string|null $image
     * @return bool
     */
    public static function realtime(
        string|array $fcm,
        string $title,
        string $body,
        ?string $image = null
    ): bool {
        try {
            $tokens = self::validateRecipients($fcm);
            $normalizedImage = self::normalizeImage($image);

            return (new RealtimeChannel())->send([
                'tokens' => $tokens,
                'title' => $title,
                'body' => $body,
                'image' => $normalizedImage
            ]);
        } catch (Exception $e) {
            Log::error('Realtime notification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send custom email notification.
     *
     * @param string $template
     * @param string|array $to
     * @param string $title
     * @param string $body
     * @param array $additional_data
     * @return bool
     */
    public static function emailCustom(
        string $template,
        string|array $to,
        string $title,
        string $body,
        array $additional_data = []
    ): bool {
        try {
            $recipients = self::validateRecipients($to);
            return (new EmailChannel())->send([
                'to' => $recipients,
                'title' => $title,
                'body' => $body,
                'template' => $template,
                'data' => array_merge([
                    'title' => $title,
                    'body' => $body
                ], $additional_data)
            ]);
        } catch (Exception $e) {
            Log::error('Custom email notification failed: ' . $e->getMessage());
            return false;
        }
    }
}