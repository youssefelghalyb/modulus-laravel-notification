<?php

namespace Modulus\Notification\Services\Channels;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailChannel
{
    /**
     * Send an email notification.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function send(array $data): bool
    {
        try {
            foreach ($data['to'] as $recipient) {
                Mail::send($data['template'], [
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'image' => $data['image'] ?? null,
                    'button' => $data['button'] ?? null,
                    'additional_data' => $data['data'] ?? []
                ], function($message) use ($data, $recipient) {
                    $message->to($recipient)
                           ->subject($data['title']);
                           
                    // Set from if configured
                    if (config('notification.email.from.address')) {
                        $message->from(
                            config('notification.email.from.address'),
                            config('notification.email.from.name')
                        );
                    }
                });
            }
            return true;
        } catch (Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            throw $e;
        }
    }
}