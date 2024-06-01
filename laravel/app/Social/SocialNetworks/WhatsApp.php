<?php

namespace App\Social\SocialNetworks;

use App\Social\Notifications\WhatsAppNotification;
use Illuminate\Notifications\Notification;
use App\Social\SocialNetworks\SocialNetwork;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class WhatsApp implements SocialNetwork
{
    public function sendNotification($notification)
    {
        $data = $notification->getData();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($notification->getUrl(), $data);

        return $response;
    }

    public function generateNotification($message)
    {
        return new WhatsAppNotification($message);
    }

}
