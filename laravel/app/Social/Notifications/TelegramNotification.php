<?php

namespace App\Social\Notifications;

use App\Social\Notifications\Notification;
/**
 * Class for Telegram notifications
 */
class TelegramNotification implements Notification
{
    /**
     * @var string
     */
    protected $apiUrl = "https://api.telegram.org";

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $data;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }


    /**
     * @param $message
     */
    public function __construct($message, $typeNotification, $chat)
    {
        $url = $this->apiUrl . "/bot" . config("social.telegram_bot_token") . "/sendMessage";
        $this->url = $url;
        $this->data = $this->generateNotification($message, $typeNotification, $chat);
    }

    /**
     * @param string $message
     * @param bool $typeNotification
     * @param bool $chat
     * @return array
     */
    public function generateNotification($message, $typeNotification = false, $chat = false)
    {
        if ($typeNotification == "site_notification") {
            $chat = config('social.telegram_chat_id');
        }

        $data = [];
        if ($chat) {
            $data['chat_id'] = $chat;
            $data['text'] = $message;
        }

        return $data;
    }
}
