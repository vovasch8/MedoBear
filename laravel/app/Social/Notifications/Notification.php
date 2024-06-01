<?php

namespace App\Social\Notifications;

use Illuminate\Support\Facades\Http;

interface Notification
{
    public function generateNotification($data);
}
