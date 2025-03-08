<?php

namespace Modulus\Notification\Services\Channels;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RealtimeChannel
{
    /**
     * Send a realtime notification via Firebase Cloud Messaging.
     *
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool
    {
        try {
            if (empty($data['tokens'])) {
                throw new Exception('FCM tokens are required');
            }

            $serverKey = config('notification.push.fcm.server_key');
            
            if (empty($serverKey)) {
                throw new Exception('FCM server key is not configured');
            }

            foreach ($data['tokens'] as $token) {
                $this->sendToToken($token, $data, $serverKey);
            }

            return true;
        } catch (Exception $e) {
            Log::error('FCM sending failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send notification to a specific FCM token.
     *
     * @param string $token
     * @param array $data
     * @param string $serverKey
     * @return void
     */
    protected function sendToToken(string $token, array $data, string $serverKey): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $token,
            'notification' => [
                'title' => $data['title'],
                'body' => $data['body'],
                'image' => $data['image'] ?? null,
                'sound' => 'default'
            ],
            'data' => [
                'title' => $data['title'],
                'body' => $data['body'],
                'image' => $data['image'] ?? null
            ]
        ]);

        if (!$response->successful()) {
            Log::warning('FCM notification failed for token ' . $token, [
                'response' => $response->json()
            ]);
        }
    }
}