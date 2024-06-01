<?php

namespace App\Social;

use Illuminate\Support\Carbon;

/**
 * Class for planning notification
 */
class SocialPlanner
{
    /**
     * @var bool[]
     */
    protected $adminNotifications = [
        'orders' => true,
        'messages' => true,
        'statistics' => true,
    ];

    /**
     * @var bool[]
     */
    protected $userNotifications = [
        'propositions' => true,
        'promocodes' => true,
        'orders' => true,
    ];

    /**
     * @param Carbon $date
     */
    public function setDate($socialNetwork, $notification, $date = null) {

    }
}
