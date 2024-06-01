<?php

namespace App\Social\SocialNetworks;

use App\Social\SocialNetworks\SocialNetwork;
use App\Social\Notifications\TelegramNotification;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class Telegram implements SocialNetwork
{

    /**
     * @param $notification
     * @return \Illuminate\Http\Client\Response
     */
    public function sendNotification($notification) {
        $response = Http::get($notification->getUrl(), $notification->getData());

        return $response;
    }

    /**
     * @param $message
     * @return TelegramNotification
     */
    public function generateNotification($message) {
        return new TelegramNotification($message);
    }
}
