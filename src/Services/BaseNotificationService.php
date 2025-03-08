<?php

namespace Modulus\Notification\Services;

use Modulus\Notification\Contracts\NotificationServiceInterface;

abstract class BaseNotificationService implements NotificationServiceInterface
{
    protected static array $channels = [];

    /**
     * Validate and normalize recipients.
     *
     * @param string|array $recipients
     * @return array
     */
    protected static function validateRecipients(string|array $recipients): array
    {
        return is_array($recipients) ? $recipients : [$recipients];
    }

    /**
     * Normalize image URL.
     *
     * @param string|null $image
     * @return string|null
     */
    protected static function normalizeImage(?string $image): ?string
    {
        if (!$image) return null;
        // Add any image validation/processing logic here
        return $image;
    }

    /**
     * Normalize button data.
     *
     * @param array|null $button
     * @return array|null
     */
    protected static function normalizeButton(?array $button): ?array
    {
        if (!$button) return null;
        // Ensure button has required properties
        return array_merge([
            'text' => 'Click here',
            'url' => '#'
        ], $button);
    }
}