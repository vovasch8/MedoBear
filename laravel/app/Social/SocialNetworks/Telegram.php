<?php

namespace App\Social\SocialNetworks;

use App\Http\Controllers\PartnerController;
use App\Models\Product;
use App\Models\Promocode;
use App\Social\SocialNetworks\SocialNetwork;
use App\Social\Notifications\TelegramNotification;
use Illuminate\Support\Facades\DB;
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
    public function generateNotification($message, $typeNotification = false, $chat = false) {
        return new TelegramNotification($message, $typeNotification, $chat);
    }

    /**
     * @param $order
     * @return string
     */
    public function generateOrderNotification($order) {
        $promocode = "";
        if($order->promocode) {
            $promocode = "\n👑Промокод: " . $order->promocode . "\n🔖Знижка: " . Promocode::getDiscount($order->promocode) . "%";
        }

        // Generate poshta info
        $typePoshta = "";
        if ($order->type_poshta == "Нова Пошта") {
            $typePoshta .= "✉Пошта: Нова пошта";
            if ($order->courier) {
                $typePoshta .= "\n--Відправити кур'єром по адресу--\n" .
                    "📌Населений пункт: " . $order->nova_city .
                    "\n⬆Вулиця: " . $order->street .
                    "\n🏡Будинок: " . $order->house;
                if ($order->room) {
                    $typePoshta .= "\n🏨Квартира: " . $order->room;
                }
            } else {
                $typePoshta .= "\n--Відправити у відділення--\n".
                    "📌Населений пункт: " . $order->nova_city .
                    "\n🚪Відділення: " . $order->nova_warehouse;
            }
        } else {
            $typePoshta .= "✉Пошта: Укр пошта";
            if ($order->courier) {
                $typePoshta .= "\n--Відправити кур'єром по адресу--\n" .
                    "📌Населений пункт: " . $order->ukr_city .
                    "\n⬆Вулиця: " . $order->street .
                    "\n🏡Будинок: " . $order->house;
                if ($order->room) {
                    $typePoshta .= "\n🏨Квартира: " . $order->room;
                }
            }
            else {
                $typePoshta .= "\n--Відправити у відділення--\n" .
                    "📌Населений пункт: " . $order->ukr_city .
                    "\n🚪Відділення: " . $order->ukr_post_office;
            }
        }

        // Get Products from order
        $products =  DB::table('products')
            ->join('order_products', 'products.id', '=', 'order_products.product_id')
            ->select('products.id', 'products.name', 'order_products.size', 'order_products.price', 'order_products.count as product_count')
            ->where('order_products.order_id', $order->id)
            ->get();
        $products = Product::getProductsWithImages($products);

        // Generate products info
        $orderProducts = "";
        foreach($products as $index => $product) {
            $orderProducts .= '📦️' . $product->name . " - "
                . $product->size
                . " - " . $product->product_count . "шт. по "
                . $product->price . "грн.шт.\n"
                . urldecode(route("site.product", [$product->id, $product->size])) . "\n";
        }

        // Generate all message for notification
        return "🎯Нове замовлення #$order->id на сайті Medobear\n\n--Контакти покупця--\n😀Покупець: " . $order->pip .
            "\n📞Телефон: " . $order->phone .
            $promocode .
            "\n\n--Відправка--\n" .
            $typePoshta .
            "\n\n💰️Ціна замовлення: " . $order->price . "грн.\n" .
            "\n--Замовлені Товари--\n" .
            $orderProducts .
            "\n💎Подивитись на замовлення в адмін панелі: " . route("admin.admin");
    }

    public function generatePartnerOrderNotification($order, $partner) {
        $partnerController = new PartnerController();
        $balance = $partnerController->getAccountBalance($partner);
        $promocode = "";
        if($order->promocode) {
            $promocode = "\n👑Промокод: " . $order->promocode . "\n🔖Знижка: " . Promocode::getDiscount($order->promocode) . "%";
        }

        // Get Products from order
        $products =  DB::table('products')
            ->join('order_products', 'products.id', '=', 'order_products.product_id')
            ->select('products.id', 'products.name', 'order_products.size', 'order_products.price', 'order_products.count as product_count')
            ->where('order_products.order_id', $order->id)
            ->get();
        $products = Product::getProductsWithImages($products);

        // Generate products info
        $orderProducts = "";
        foreach($products as $index => $product) {
            $orderProducts .= '📦️' . $product->name . " - "
                . $product->size
                . " - " . $product->product_count . "шт. по "
                . $product->price . "грн.шт.\n"
                . urldecode(route("site.product", [$product->id, $product->size])) . "\n";
        }

        return "🎯Нове замовлення #$order->id на сайті Medobear\n\n--Інформація покупця--\n😀Покупець: " . $order->pip .
        $promocode .
        "\n\n💰️Ціна замовлення: " . $order->price . "грн.\n" .
        "💰️Нараховано: " . intval(round($order->price * 0.3)) . "грн.\n" .
        "💰️Загальний баланс: " . $balance . "грн.\n" .
        "\n--Замовлені Товари--\n" .
        $orderProducts .
        "\n💎Подивитись на замовлення в партнерці: " . route("partner.partner");
    }
}
