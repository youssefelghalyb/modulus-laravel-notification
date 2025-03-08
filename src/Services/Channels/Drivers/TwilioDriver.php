<?php

namespace Modulus\Notification\Services\Channels\Drivers;

use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class TwilioDriver
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
     * TwilioDriver constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $sid = config('notification.sms.drivers.twilio.sid');
        $token = config('notification.sms.drivers.twilio.auth_token');
        $this->from = config('notification.sms.drivers.twilio.from');
        
        if (!$sid || !$token || !$this->from) {
            throw new Exception('Twilio configuration is incomplete');
        }
        
        $this->client = new Client($sid, $token);
    }

    /**
     * Send SMS via Twilio.
     *
     * @param string $to
     * @param string $message
     * @return string The message SID
     * @throws Exception
     */
    public function send(string $to, string $message)
    {
        try {
            $response = $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message
            ]);
            
            return $response->sid;
        } catch (Exception $e) {
            Log::error('Twilio SMS Error: ' . $e->getMessage());
            throw $e;
        }
    }
}