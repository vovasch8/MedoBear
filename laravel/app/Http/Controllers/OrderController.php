<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Product;
use App\Social\SocialNetworks\Telegram;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProducts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function createOrder(Request $request) {
        $orderModel = new Order();

        $products = CartController::getProducts();

        if (!empty($products)) {
            $promocode = CartController::getPromocode();
            $totalPrice = CartController::getTotalPrice();

            $orderModel->pip = strval($request->pip);
            $orderModel->phone = strval($request->phone);

            if ($request->poshta['type_poshta'] === "novaPoshta") {
                    $orderModel->type_poshta = "Нова Пошта";
                if ($request->poshta['type_delivery'] === "courier") {
                    $orderModel->courier = true;
                    $orderModel->nova_city = $request->poshta['nova_city'];
                    $orderModel->street = $request->poshta['street'];
                    $orderModel->house = $request->poshta['house'];
                    $orderModel->room = $request->poshta['room'];
                } else {
                    $orderModel->courier = false;
                    $orderModel->nova_city = $request->poshta['nova_city'];
                    $orderModel->nova_warehouse = $request->poshta['nova_warehouse'];
                }
            } else {
                $orderModel->type_poshta = "Укр Пошта";
                if ($request->poshta['type_delivery'] === "courier") {
                    $orderModel->courier = true;
                    $orderModel->ukr_city = $request->poshta['ukr_city'];
                    $orderModel->street = $request->poshta['street'];
                    $orderModel->house = $request->poshta['house'];
                    $orderModel->room = $request->poshta['room'];
                } else {
                    $orderModel->courier = false;
                    $orderModel->ukr_city = $request->poshta['ukr_city'];
                    $orderModel->ukr_post_office = $request->poshta['ukr_post_office'];
                }
            }

            $orderModel->price = $totalPrice;
            if (!empty($promocode)) {
                $orderModel->promocode = $promocode["name"];
            }
            $orderModel->save();

            $orderId = $orderModel->id;

            foreach ($products as $id => $quantity) {
                $orderProductsModel = new OrderProducts();
                $orderProductsModel->order_id = $orderId;
                $orderProductsModel->product_id = $id;
                $orderProductsModel->count = $quantity;
                $orderProductsModel->save();
            }

            $order = Order::find($orderId);
            $telegram = new Telegram();
            $orderNotification = $telegram->generateOrderNotification($order);
            $telegram->sendNotification($telegram->generateNotification($orderNotification));
            Mail::to(config("mail.mail_for_order"))->send(new OrderMail($order));
        }

        return true;
    }

    public function addProductToOrder(Request $request) {
        $orderProductsModel = new OrderProducts();
        $idOrder = intval($request->id_order);
        $idProduct = intval($request->id_product);
        $count = intval($request->count);

        $productOfOrder = $orderProductsModel->all()->where("order_id", "=", $idOrder)->where("product_id", "=", $idProduct)->first();

        if (empty($productOfOrder)) {
            $orderProductsModel->order_id = $idOrder;
            $orderProductsModel->product_id = $idProduct;
            $orderProductsModel->count = $count;
            $orderProductsModel->save();

            $products = DB::table("products")->join("order_products", "products.id", "=", "product_id")->where("order_id", "=", $idOrder)->where("product_id", "=", $idProduct)->select("products.id", "products.name", "products.price", "order_products.order_id", "order_products.count", "products.count AS count_substance")->get();
            return Product::getProductsWithImages($products);
        } else {
            $productOfOrder->count = $count;
            $productOfOrder->save();

            $products = DB::table("products")->join("order_products", "products.id", "=", "product_id")->where("order_id", "=", $idOrder)->where("product_id", "=", $idProduct)->select("products.id", "products.name", "products.price", "order_products.order_id", "order_products.count", "products.count AS count_substance")->get();
            return Product::getProductsWithImages($products);
        }
    }

    public function removeProductFromOrder(Request $request) {
        $idOrder = intval($request->id_order);
        $idProduct = intval($request->id_product);
        $product = DB::table('order_products')->where('order_id', '=', $idOrder)->where("product_id", "=", $idProduct)->first();

        if (!empty($product)) {
            DB::table('order_products')->where('order_id', '=', $idOrder)->where("product_id", "=", $idProduct)->delete();

            return $idProduct;
        }

        return false;
    }

    public function getOrderProducts(Request $request) {
        $orderId = intval($request->id_order);
        $products = [];

        if ($orderId) {
            $products = DB::table("products")->join("order_products", "products.id", "=", "product_id")->where("order_id", "=", $orderId)->select("products.id", "products.name", "products.price", "order_products.order_id", "order_products.count", "products.count AS count_substance")->get();
        }

        return Product::getProductsWithImages($products);
    }

    public function deleteOrder(Request $request) {
        $id = intval($request->id);

        $orderProducts = OrderProducts::all()->where("order_id", "=", $id);
        foreach ($orderProducts as $productRelation) {
            $productRelation->delete();
        }

        $order = Order::find($id);
        $order->delete();

        return true;
    }
}
