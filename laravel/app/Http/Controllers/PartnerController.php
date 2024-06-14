<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PartnerOrders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function partner() {
        $this->authorize("view-user", Auth::user());

        $categories = Category::all()->where("active", true);
        foreach ($categories as $category) {
            $category->products = Product::all()->where("category_id", $category->id);
        }

        $user_id = Auth::user()->id;
        if (Auth::user()->role == "admin" && isset($_GET['partner_id'])) {
            $user_id = intval($_GET['partner_id']);
        }

        $partnerOrders = DB::table("orders")
            ->join("partner_orders", "orders.id", "=", "partner_orders.order_id")
            ->where("partner_id", "=", $user_id)
            ->orderBy("orders.id", "desc")
            ->simplePaginate(5);

        foreach ($partnerOrders as $order) {
            $products = DB::table('products')
                ->join("order_products", "products.id", "=", "order_products.product_id")
                ->where("order_products.order_id", "=", $order->order_id)
                ->select("products.id as id", "products.name", "order_products.price", "products.category_id", "order_products.order_id", "order_products.product_id", "order_products.count", "order_products.size")
                ->get();
            $order->products = Product::getProductsWithImages($products);
        }

        $links = self::getListOfPartnerLink();
        $statLinks = [];
        $statLinks['all_price'] = 0;
        $statLinks['payments'] = 0;
        $statLinks['count'] = 0;
        $statLinks['paid_out'] = 0;
        $statLinks['count_products'] = 0;
        $statLinks['links'] = [];
        $account = 0;
        foreach ($links as $key => $link) {
            $statLinks['links'][$key]['all_price'] = 0;
            $statLinks['links'][$key]['payments'] = 0;
            $statLinks['links'][$key]['count'] = 0;
            $statLinks['links'][$key]['paid_all_price'] = 0;
            $statLinks['links'][$key]['paid_payments'] = 0;
            $statLinks['links'][$key]['paid_count'] = 0;
        }

        foreach ($partnerOrders as $order) {
            foreach ($links as $key => $link) {
                if ($order->link == $link['link'].'/') {
                    $statLinks['links'][$key]['all_price'] += $order->price;
                    $statLinks['links'][$key]['payments'] += intval(round($order->price * 0.3));
                    $statLinks['links'][$key]['count']++;
                    if (!$order->paid_out) {
                        $statLinks['links'][$key]['paid_all_price'] += $order->price;
                        $statLinks['links'][$key]['paid_payments'] += intval(round($order->price * 0.3));
                        $statLinks['links'][$key]['paid_count']++;
                        $account += intval(round($order->price * 0.3));
                    }
                }
            }
            foreach ($order->products as $product) {
                $statLinks['count_products'] += $product->count;
            }
            $statLinks['all_price'] += $order->price;
            $statLinks['payments'] += intval(round($order->price * 0.3));
            $statLinks['count']++;
        }
        $statLinks['paid_out'] = $statLinks['payments'] - $account;

        return view("partner", ["orders" => $partnerOrders, "categories" => $categories, 'links' => $links, 'statLinks' => $statLinks, 'account' => $account, "user" => User::find($user_id)]);
    }

    public function saveCard(Request $request) {
        $card = strval($request->card);
        $user = Auth::user();

        $user->card = $card;
        $user->save();

        return true;
    }

    public function getPartnerOrders() {
        $partnerOrders = DB::table("orders")
            ->join("partner_orders", "orders.id", "=", "partner_orders.order_id")
            ->where("partner_id", "=", Auth::user()->id)
            ->orderBy("orders.id", "desc")
            ->get();

        return $partnerOrders;
    }

    public static function getListOfPartnerLink() {
        $partnerLink = [];
        $categories = Category::all()->where("active", true);
        foreach ($categories as $category) {
            $category->products = Product::all()->where("category_id", $category->id);
        }

        $partnerLink[] = ["link" => route("site.catalog") , "value" => 'Каталог'];
        foreach($categories as $category) {
            $partnerLink[] = ["link" => route('site.current_catalog', [$category->id]), 'value' => $category->name];
        }

        foreach($categories as $category) {
            foreach ($category->products as $product) {
                if ($product->count) {
                    $partnerLink[] = ["link" => urldecode(route("site.product", [$product->id, $product->count])), 'value' => $product->name . ' - ' . $product->count . ' - ' . $product->price . 'грн.'];
                } if ($product->count2) {
                    $partnerLink[] = ["link" => urldecode(route("site.product", [$product->id, $product->count2])), 'value' => $product->name . ' - ' . $product->count2 . ' - ' . $product->price2 . 'грн.'];
                } if ($product->count3) {
                    $partnerLink[] = ["link" => urldecode(route("site.product", [$product->id, $product->count3])), 'value' => $product->name . ' - ' . $product->count3 . ' - ' . $product->price3 . 'грн.'];
                } if ($product->count4) {
                    $partnerLink[] = ["link" => urldecode(route("site.product", [$product->id, $product->count4])), 'value' => $product->name . ' - ' . $product->count4 . ' - ' . $product->price4 . 'грн.'];
                }
            }
        }

        return $partnerLink;
    }

    public function pay(Request $request) {
        $id_partner = intval($request->id_partner);

        $partnerOrders = DB::table('partner_orders')->where("partner_id", "=", $id_partner)->where("paid_out", "=", false)->get();

        foreach ($partnerOrders as $relation) {
            $partnerOrder = PartnerOrders::find($relation->id);
            $partnerOrder->paid_out = true;
            $partnerOrder->save();
        }

        return true;
    }
}
