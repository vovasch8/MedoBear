<?php

namespace App\Social\SocialNetworks;

use Illuminate\Notifications\Notification;

/**
 *  Abstract class for social network
 */
interface SocialNetwork
{

    public function sendNotification($notification);

    public function generateNotification($message);
}
