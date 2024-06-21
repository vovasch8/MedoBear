<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
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

//        dd($this->getAccountBalance(Auth::user()));

        $categories = Category::all()->where("active", true);
        foreach ($categories as $category) {
            $category->products = Product::all()->where("category_id", $category->id);
        }

        $user_id = Auth::user()->id;
        if (Auth::user()->role == "admin" && isset($_GET['partner_id'])) {
            $user_id = intval($_GET['partner_id']);
        }

        $partnerOrders = $this->getPartnerOrders($user_id);

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
                if ($order->link == $link['link']) {
                    $statLinks['links'][$key]['name'] = $link['value'];
                    $statLinks['links'][$key]['link'] = $link['link'];
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
        $standart = 6;
        $standartLinks = 5;

        uasort($statLinks['links'], function ($a, $b) {
            if ($a['count'] === $b['count']) {
                return $b['all_price'] <=> $a['all_price'];
            }
            return $a['count'] < $b['count'];
        });
        $statLinks["links"] = array_filter($statLinks['links'], function ($el) { return $el["count"] > 0;});
        $statLinks["links"] = array_slice($statLinks['links'], 0, $standartLinks);

        $statLinks['nextPage'] = count($statLinks['links']) == $standartLinks;

        return view("partner", ["orders" => $this->getPartnerOrders($user_id, $standart), "categories" => $categories, 'statLinks' => $statLinks, 'account' => $account, "user" => User::find($user_id), "standart" => $standart, "standartLinks" => $standartLinks]);
    }

    public function getAccountBalance($user) {
        $partnerOrders = $this->getPartnerOrders($user->id, false, 0, false, true);
        $balance = 0;
        foreach ($partnerOrders as $order) {
            $balance += intval(round($order->price * 0.3));
        }

        return $balance;
    }

    public function saveCard(Request $request) {
        $card = strval($request->card);
        $user = Auth::user();

        $user->card = $card;
        $user->save();

        return true;
    }

    public function saveGroup(Request $request) {
        $group = strval($request->group);
        $user = Auth::user();

        $user->telegram_group = $group;
        $user->save();

        return true;
    }

    public function getPartnerOrders($user_id, $count = false, $numberPage = 0, $link = false, $showLastOrders = false) {
        $query = DB::table("orders")
            ->join("partner_orders", "orders.id", "=", "partner_orders.order_id")
            ->where("partner_id", "=", $user_id);

        if ($link) {
            $query->where("link", "=", $link);
        } if($showLastOrders) {
            $query->where("paid_out", "=", false);
        } if ($count) {
            $query->skip($numberPage * $count)->take($count + 1);
        }

        $orders = $query->orderBy("orders.id", "desc")->get();

        foreach ($orders as $order) {
            $products = DB::table('products')
                ->join("order_products", "products.id", "=", "order_products.product_id")
                ->where("order_products.order_id", "=", $order->order_id)
                ->select("products.id as id", "products.name", "order_products.price", "products.category_id", "order_products.order_id", "order_products.product_id", "order_products.count", "order_products.size")
                ->get();
            $order->products = Product::getProductsWithImages($products);
        }

        $orders->nextPage = count($orders) > $count;

        if ($orders->nextPage) unset($orders[$count]);

        return $orders;
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

    public function showOrders(Request $request, $count = 6) {
        $numberPage = intval($request->numberPage);
        $link = strval($request->link);
        $lastOrders = $request->lastOrders == "true";

        $orders = $this->getPartnerOrders(Auth::user()->id, $count, $numberPage, $link, $lastOrders);

        return view("layouts.orders-content", ["orders" => $orders, "standart" => $count]);
    }

    public function showLinksStat(Request $request, $count = 5) {
        $numberPage = intval($request->numberPage);
        $user_id = Auth::user()->id;
        if (Auth::user()->role == "admin" && isset($_GET['partner_id'])) {
            $user_id = intval($_GET['partner_id']);
        }
        $partnerOrders = $this->getPartnerOrders($user_id);

        $links = self::getListOfPartnerLink();
        $statLinks = [];
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
                if ($order->link == $link['link']) {
                    $statLinks['links'][$key]['name'] = $link['value'];
                    $statLinks['links'][$key]['link'] = $link['link'];
                    $statLinks['links'][$key]['all_price'] += $order->price;
                    $statLinks['links'][$key]['payments'] += intval(round($order->price * 0.3));
                    $statLinks['links'][$key]['count']++;
                    if (!$order->paid_out) {
                        $statLinks['links'][$key]['paid_all_price'] += $order->price;
                        $statLinks['links'][$key]['paid_payments'] += intval(round($order->price * 0.3));
                        $statLinks['links'][$key]['paid_count']++;
                    }
                }
            }
        }
        uasort($statLinks['links'], function ($a, $b) {
            if ($a['count'] === $b['count']) {
                return $b['all_price'] <=> $a['all_price'];
            }
            return $a['count'] < $b['count'];
        });
        $statLinks["links"] = array_filter($statLinks['links'], function ($el) { return $el["count"] > 0;});
        $statLinks["links"] = array_slice($statLinks['links'], $numberPage * $count, $count);
        $statLinks['nextPage'] = count($statLinks['links']) == $count;

        return view("layouts.partner-links-content", ["statLinks" => $statLinks, "standartLinks" => $count]);
    }
}
