<?php

namespace App\Social\Notifications;

use App\Social\Notifications\Notification;

class WhatsAppNotification implements Notification
{

    protected $apiUrl = "https://graph.facebook.com/v18.0/";

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

    public function __construct($message)
    {
        $url = $this->apiUrl . config("social.whatsapp_app_id") . "/messages?access_token=" . config("social.api_key_whatsapp");
        $this->url = $url;
        $this->data = $this->generateNotification($message);
    }

    public function generateNotification($message)
    {
        $data = [];
        $data['messaging_product'] = "whatsapp";
        $data['to'] = "380960808353";
        $data['type'] = "template";
        $data['template'] = [
            "name" => "hello_world",
            "language" => [
                "code" => "en_US"
            ]
        ];

        return $data;
    }

}
