<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\PartnerOrders;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\User;
use App\Models\UserOrders;
use App\Social\SocialNetworks\Telegram;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProducts;
use Illuminate\Support\Facades\Auth;
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
                foreach ($quantity['sizes'] as $size => $count) {
                    $orderProductsModel = new OrderProducts();
                    $orderProductsModel->order_id = $orderId;
                    $orderProductsModel->product_id = $id;
                    $orderProductsModel->size = $size;
                    $orderProductsModel->price = CartController::getPriceOfProductSize(Product::find($id), $size);
                    $orderProductsModel->count = $count;
                    $orderProductsModel->save();
                }
            }

            $order = Order::find($orderId);
            $telegram = new Telegram();
            $orderNotification = $telegram->generateOrderNotification($order);
            $telegram->sendNotification($telegram->generateNotification($orderNotification, "site_notification"));
            Mail::to(config("mail.mail_for_order"))->send(new OrderMail($order));
            if (\Auth::check()) {
                $userOrder = new UserOrders();
                $userOrder->user_id = Auth::user()->id;
                $userOrder->order_id = $orderId;

                $userOrder->save();
            } if (session()->has("partner") && session()->has("link") && ((auth()->check() && (intval(session('partner')) != Auth::user()->id) || !auth()->check()))) {
                $link = session('link');
                $id_user = intval(session('partner'));
                $partner = User::find($id_user);

                if ($partner) {
                    $partnerOrder = new PartnerOrders();

                    $partnerOrder->partner_id = intval($id_user);
                    $partnerOrder->order_id = $orderId;
                    $partnerOrder->link = $link;
                    $partnerOrder->price = $order->price;
                    $partnerOrder->payments = round(intval($order->price) * 0.3);
                    $partnerOrder->paid_out = false;

                    $partnerOrder->save();
                    session()->forget("partner");
                    session()->forget("link");
                    if ($partner->telegram_group) {
                        $partnerOrderNotification = $telegram->generatePartnerOrderNotification($order, $partner);
                        $telegram->sendNotification($telegram->generateNotification($partnerOrderNotification, "partner_notification", $partner->telegram_group));
                    }
                }
            }
            CartController::clearCart();
        }


        return route("site.catalog");
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
        $size = strval($request->count_substance);
        $product = DB::table('order_products')->where('order_id', '=', $idOrder)->where("product_id", "=", $idProduct)->where("size", "=", $size)->first();

        if (!empty($product)) {
            DB::table('order_products')->where('order_id', '=', $idOrder)->where("product_id", "=", $idProduct)->where("size", "=", $size)->delete();

            return $this->updateTotalPrice(Order::find($idOrder));
        }

        return false;
    }

    public function getOrderProducts(Request $request) {
        $orderId = intval($request->id_order);
        $products = [];

        if ($orderId) {
            $products = DB::table("products")->join("order_products", "products.id", "=", "product_id")->where("order_id", "=", $orderId)->select("products.id", "products.name", "order_products.price", "order_products.order_id", "order_products.count as count", "order_products.size AS count_substance")->get();
        }

        return Product::getProductsWithImages($products);
    }

    public function deleteOrder(Request $request) {
        $id = intval($request->id);

        $orderProducts = OrderProducts::all()->where("order_id", "=", $id);
        foreach ($orderProducts as $productRelation) {
            $productRelation->delete();
        }
        $partnerOrders = PartnerOrders::all()->where("order_id", "=", $id);
        foreach ($partnerOrders as $partnerRelation) {
            $partnerRelation->delete();
        }
        $userOrders = UserOrders::all()->where("order_id", "=", $id);
        foreach ($userOrders as $userRelation) {
            $userRelation->delete();
        }

        $order = Order::find($id);
        $order->delete();

        return true;
    }

    public function getOrderCart(Request $request) {
        $products = $this->getOrderProducts($request);

        return view("layouts.admin-order-products", ['products' => $products]);
    }

    public function updateTotalPrice($order) {
        $products = OrderProducts::all()->where("order_id", "=", $order->id);
        $totalPrice = 0;

        if ($products) {
            foreach ($products as $product) {
                $totalPrice += $product->count * $product->price;
            }
        }

        if ($order->promocode) {
            $promocode = Promocode::all()->where("promocode", "=", $order->promocode)->first();
            $totalPrice = round($totalPrice - ($promocode['discount'] * $totalPrice / 100));
        }

        $order->price = $totalPrice;
        $order->save();

        return $totalPrice;
    }

    public function updateOrder(Request $request) {
        $id_product = intval($request->id_product);
        $id_order = intval($request->id_order);
        $size = strval($request->size);
        $count = intval($request->count);

        $orderProduct = OrderProducts::all()->where('product_id', $id_product)->where('order_id', $id_order)->where('size', $size)->first();

        if ($orderProduct) {
            $orderProduct->count = $count;
            $orderProduct->save();

            return $this->updateTotalPrice(Order::find($id_order));
        }

        return false;
    }
}
