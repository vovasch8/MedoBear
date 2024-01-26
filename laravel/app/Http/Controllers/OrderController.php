<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProducts;
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
                $orderProductsModel->orderId = $orderId;
                $orderProductsModel->productId = $id;
                $orderProductsModel->count = $quantity;
                $orderProductsModel->save();
            }

            Mail::to(config("mail.mail_for_order"))->send(new OrderMail(Order::find($orderId)));
        }

        return true;
    }
}
