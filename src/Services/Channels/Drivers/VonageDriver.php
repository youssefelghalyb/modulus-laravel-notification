<?php

namespace Modulus\Notification\Services\Channels\Drivers;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use Exception;
use Illuminate\Support\Facades\Log;

class VonageDriver
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $from;

    /**
     * VonageDriver constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $apiKey = config('notification.sms.drivers.vonage.api_key');
        $apiSecret = config('notification.sms.drivers.vonage.api_secret');
        $this->from = config('notification.sms.drivers.vonage.from');
        
        if (!$apiKey || !$apiSecret || !$this->from) {
            throw new Exception('Vonage configuration is incomplete');
        }
        
        $this->client = new Client(
            new Basic($apiKey, $apiSecret)
        );
    }

    /**
     * Send SMS via Vonage.
     *
     * @param string $to
     * @param string $message
     * @return string The message ID
     * @throws Exception
     */
    public function send(string $to, string $message)
    {
        try {
            $response = $this->client->sms()->send(
                new SMS($to, $this->from, $message)
            );
            
            $sent = $response->current();
            
            if ($sent->getStatus() == 0) {
                return $sent->getMessageId();
            }
            
            throw new Exception('SMS not sent. Status: ' . $sent->getStatus());
        } catch (Exception $e) {
            Log::error('Vonage SMS Error: ' . $e->getMessage());
            throw $e;
        }
    }
}