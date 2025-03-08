<?php

namespace Modulus\Notification\Services\Channels;

use Exception;
use Illuminate\Support\Facades\Log;
use Modulus\Notification\Services\Channels\Drivers\TwilioDriver;
use Modulus\Notification\Services\Channels\Drivers\VonageDriver;

class SmsChannel
{
    /**
     * @var TwilioDriver|VonageDriver
     */
    protected $driver;

    /**
     * SmsChannel constructor.
     */
    public function __construct()
    {
        $this->driver = $this->resolveDriver();
    }

    /**
     * Resolve the SMS driver based on configuration.
     *
     * @return TwilioDriver|VonageDriver
     * @throws Exception
     */
    protected function resolveDriver()
    {
        $driver = config('notification.sms.default', 'twilio');

        return match($driver) {
            'twilio' => new TwilioDriver(),
            'vonage' => new VonageDriver(),
            default => throw new Exception("Unsupported SMS driver: {$driver}")
        };
    }

    /**
     * Send an SMS notification.
     *
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool
    {
        try {
            if (empty($data['to'])) {
                throw new Exception('Recipient is required');
            }

            $message = $this->formatMessage($data);

            foreach ((array)$data['to'] as $recipient) {
                $this->driver->send($recipient, $message);
            }

            return true;
        } catch (Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format the message with title and body.
     *
     * @param array $data
     * @return string
     */
    protected function formatMessage(array $data): string
    {
        $message = '';
        
        if (!empty($data['title'])) {
            $message .= $data['title'] . "\n\n";
        }
        
        $message .= $data['body'];
        
        return $message;
    }
}