<?php

namespace App\Social;

use Illuminate\Support\Facades\Date;
use App\Social\SocialNetworks\Telegram;
use App\Social\SocialNetworks\Viber;
use App\Social\SocialNetworks\WhatsApp;
use App\Social\SocialNetworks\Facebook;

class SocialManager
{
    protected $planner;

    protected $socialArrays = [
        'telegram' => Telegram::class,
        'whatsapp' => WhatsApp::class
    ];

    public function __construct()
    {
        $this->planner = new SocialPlanner();
    }

    public function sendNotification($socialName, $message, $date = "") {
        if (!$date) {
            $date = Date::now(config("timezone"))->format("Y-m-d H:i");
        }

        $socialNetwork = new $this->socialArrays[$socialName];
        $notification = $socialNetwork->generateNotification($message);

        $response = $socialNetwork->sendNotification($notification);

        return $response;
    }
}
