<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Promocode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Order $order, public $products = 0)
    {
        $products = DB::table('products')
            ->join('order_products', 'products.id', '=', 'order_products.product_id')
            ->select('products.id', 'products.name', 'order_products.size', 'order_products.price', 'order_products.count as product_count')
            ->where('order_products.order_id', $this->order->id)
            ->get();
        $this->products = $products;
        if ($this->order->promocode) {
            $this->order->discount = Promocode::getDiscount($this->order->promocode);
        }
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address(env("MAIL_FROM_ADDRESS"), "Medobear"),
            subject: 'Замовлення на сайті',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
