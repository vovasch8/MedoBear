<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $this->authorize("view-manager", Auth::user());
        $orderModel = new Order();
        $products = Product::all()->sortByDesc("id")->take(5);
        $categories = Category::all()->sortByDesc("id");
        $lastCategories = Category::all()->sortByDesc("id")->take(5);
        $orders = Order::all()->sortByDesc("id");
        $lastOrders = $orders->slice(0,5);
        $messages = Message::all()->sortByDesc("id")->take(5);
        $countOrdersThisMonth = $orderModel->getOrdersByMonth();
        $countOrdersBy6Month = $orderModel->getOrdersBy6Month();

        return view("admin.index", ["products" => $products, "lastCategories" => $lastCategories, "categories" => $categories, "orders" => $orders, "lastOrders" => $lastOrders, "messages" => $messages, "countOrdersThisMonth" => $countOrdersThisMonth, "countOrdersBy6Month" => $countOrdersBy6Month]);
    }

    public function showCharts() {
        $this->authorize("view-manager", Auth::user());
        $orderModel = new Order();

        $countOrdersThisMonth = $orderModel->getOrdersByMonth();
        $countOrdersBy6Month = $orderModel->getOrdersBy6Month();
        $mostPopularProducts = $orderModel->getMostPopularProducts();

        return view("admin.charts", ["countOrdersThisMonth" => $countOrdersThisMonth, "countOrdersBy6Month" => $countOrdersBy6Month, "mostPopularProducts" => $mostPopularProducts]);
    }

    public function showStatistics() {
        $this->authorize("view-manager", Auth::user());

        $ordersStat = DB::table("orders")->select(DB::raw("count(*) as count_orders"))->first();
        $ordersWithPromocodeStat = DB::table("orders")->select(DB::raw("count(*) as count_orders_with_promocode"))->where("promocode","!=", null)->first();
        $productsStat =  DB::table("orders")->join("order_products", "orders.id", "=", "order_products.order_id")->join("products", "products.id", "=", "order_products.product_id")->select( "products.name", "order_products.product_id", "order_products.size", DB::raw("sum(order_products.count) as count_products"), DB::raw("sum(order_products.price) as count_price"))->groupBy("order_products.product_id", "order_products.size")->get();
        $userStat = DB::table("users")->select(DB::raw("count(*) as count_users"))->first();
        $partnerOrdersStatPaid = DB::table("orders")->join("partner_orders", "orders.id", "=", "partner_orders.order_id")->select(DB::raw("sum(partner_orders.payments) as total_price"))->where("partner_orders.paid_out", "=", 1)->first();
        $partnerOrdersStatNonPaid = DB::table("orders")->join("partner_orders", "orders.id", "=", "partner_orders.order_id")->select(DB::raw("sum(partner_orders.payments) as total_price"))->where("partner_orders.paid_out", "=", 0)->first();
        $partnerStat = DB::table("orders")->join("partner_orders", "orders.id", "=", "partner_orders.order_id")->select(DB::raw("count(*) as count_orders"), DB::raw("sum(partner_orders.price) as total_price"), DB::raw("sum(partner_orders.payments) as total_payments_price"))->groupBy("partner_id")->get();
        $partnerOrdersWithPromocodeStat = DB::table("orders")->join("partner_orders", "orders.id", "=", "partner_orders.order_id")->select(DB::raw("count(*) as count_orders_with_promocode"))->where("promocode","!=", null)->first();
        $userOrdersStat = DB::table("orders")->join("user_orders", "orders.id", "=", "user_orders.order_id")->select(DB::raw("count(*) as count_orders"))->first();
        $partnerProducts = DB::table("orders")->join("partner_orders", "orders.id", "=", "partner_orders.order_id")->join("order_products", "partner_orders.order_id", "=", "order_products.order_id")->select(DB::raw("sum(order_products.count) as total_count_products"))->first();

        $stats['count_products'] = 0;
        $stats['total_price'] = 0;
        $stats['partner_orders'] = 0;
        $stats['partner_price'] = 0;
        $stats['partner_non_payment'] = 0;
        $stats['count_partner_orders'] = 0;
        $stats['partner_total_price'] = 0;
        $stats['partner_payments_total_price'] = 0;
        $stats['count_orders'] = $ordersStat->count_orders;
        $stats['count_orders_with_promocode'] = $ordersWithPromocodeStat->count_orders_with_promocode;
        $stats['count_users'] = $userStat->count_users;
        $stats["stats_products"] = [];
        foreach ($productsStat as $product) {
            $stats['count_products'] += $product->count_products;
            $stats['total_price'] += $product->count_price;
        }

        $stats["count_user_orders"] = $userOrdersStat->count_orders;
        $stats['count_partners'] = count($partnerStat);
        foreach ($partnerStat as $partner) {
            $stats["count_partner_orders"] += $partner->count_orders;
            $stats['partner_total_price'] += $partner->total_price;
            $stats['partner_payments_total_price'] += $partner->total_payments_price;
        }
        $stats['partner_done_payments'] = intval($partnerOrdersStatPaid->total_price);
        $stats['partner_none_payments'] = intval($partnerOrdersStatNonPaid->total_price);
        $stats['partner_count_products'] = intval($partnerProducts->total_count_products);
        $stats['partner_count_orders_with_promocode'] = intval($partnerOrdersWithPromocodeStat->count_orders_with_promocode);

        return view("admin.all-statistics", ["stats" => $stats]);
    }

    public function showProductsStatistics(Request $request)
    {
        $this->authorize("view-manager", Auth::user());
        $productsStat =  DB::table("orders")->join("order_products", "orders.id", "=", "order_products.order_id")->join("products", "products.id", "=", "order_products.product_id")->select( "products.name", "order_products.product_id", "order_products.size", DB::raw("sum(order_products.count) as count_products"), DB::raw("sum(order_products.price) as count_price"))->groupBy("order_products.product_id", "order_products.size")->get();

        foreach ($productsStat as $product) {
            $stats["stats_products"][$product->product_id]["sizes"][] = ["name" => $product->name, "size" => $product->size, "count_products" => $product->count_products, "total_price" => $product->count_price];
            if (!isset($stats["stats_products"][$product->product_id]["total_count_products"])) {
                $stats["stats_products"][$product->product_id]["total_count_products"] = 0;
            }if (!isset($stats["stats_products"][$product->product_id]["total_price"])) {
                $stats["stats_products"][$product->product_id]["total_price"] = 0;
            }
            $stats["stats_products"][$product->product_id]["total_count_products"] += $product->count_products;
            $stats["stats_products"][$product->product_id]["total_price"] += $product->count_price;
        }

        uasort($stats["stats_products"], function ($a, $b) {
           return $b['total_price'] <=> $a['total_price'];
        });

        return view("admin.product-statistics", ['stats' => $stats]);
    }

    public function showTables() {
        $this->authorize("view-manager", Auth::user());
        $orders = Order::all()->sortByDesc("id");

        return view("admin.tables", ["orders" => $orders, 'typeTable' => "orders", 'editedColumns' => [1, 2, 5]]);
    }

    public function showCategories() {
        $this->authorize("view-admin", Auth::user());
        $categories = Category::all()->sortByDesc("id");

        return view("admin.categories-table", ["categories" => $categories, 'typeTable' => "categories", "editedColumns" => [1]]);
    }

    public function showUsers() {
        $this->authorize("view-admin", Auth::user());
        $users = User::all()->sortByDesc("id");

        return view("admin.users-table", ["users" => $users, 'typeTable' => "users", "editedColumns" => [1, 2]]);
    }

    public function showProducts() {
        $this->authorize("view-manager", Auth::user());
        $products = Product::all()->sortByDesc("id");
        $products = Product::getProductsWithImages($products);
        $categories = Category::all()->sortByDesc("id");

        return view("admin.products-table", ["products" => $products, 'typeTable' => "products", "categories" => $categories, "editedColumns" => [1, 4, 5, 6, 7, 8, 9, 10, 11]]);
    }

    public function showMessages() {
        $this->authorize("view-manager", Auth::user());
        $messages = Message::all()->sortByDesc("id");

        return view("admin.messages-table", ["messages" => $messages, 'typeTable' => "messages", "editedColumns" => [1, 2, 3, 4]]);
    }

    public function showPromocodes() {
        $this->authorize("view-manager", Auth::user());
        $promocodes = Promocode::all()->sortByDesc("id");

        return view("admin.promocodes-table", ["promocodes" => $promocodes, 'typeTable' => "promocodes", "editedColumns" => [1, 2, 3]]);
    }

    public function showPartners() {
        $this->authorize("view-manager", Auth::user());

        $partners = DB::table('users')
            ->join("partner_orders", "users.id", "=", "partner_orders.partner_id")
            ->select("users.id", "users.name", "users.email", "users.card", "users.created_at", DB::raw("SUM(partner_orders.price) as all_price"), DB::raw("SUM(partner_orders.payments) as all_payments"),  DB::raw("COUNT(*) as count"), "partner_orders.paid_out")
            ->groupBy("users.id", "partner_orders.paid_out")
            ->get();

        $partnersDetail = [];
        foreach ($partners as $key => $partner) {
            $partnersDetail[$partner->id]['non_price'] = 0;
            $partnersDetail[$partner->id]['non_payments'] = 0;
            $partnersDetail[$partner->id]['done_price'] = 0;
            $partnersDetail[$partner->id]['done_payments'] = 0;
            $partnersDetail[$partner->id]['count_orders'] = 0;
            $partnersDetail[$partner->id]['done_count_orders'] = 0;
        }
        foreach ($partners as $key => $partner) {
            $partnersDetail[$partner->id]['name'] = $partner->name;
            $partnersDetail[$partner->id]['email'] = $partner->email;
            $partnersDetail[$partner->id]['card'] = $partner->card;
            $partnersDetail[$partner->id]['count_orders'] += $partner->count;
            $partnersDetail[$partner->id]['created_at'] = $partner->created_at;
            if ($partner->paid_out == true) {
                $partnersDetail[$partner->id]['non_price'] = $partner->all_price;
                $partnersDetail[$partner->id]['non_payments'] = $partner->all_payments;
            } else {
                $partnersDetail[$partner->id]['done_price'] = $partner->all_price;
                $partnersDetail[$partner->id]['done_payments'] = $partner->all_payments;
                $partnersDetail[$partner->id]['done_count_orders'] += $partner->count;
            }
        }

        return view("admin.partners-table", ["partners" => collect($partnersDetail)->sortBy('non_price')->reverse()->toArray(), 'typeTable' => "partners", "editedColumns" => [1, 2, 3]]);
    }

    public function editColumnTable(Request $request) {
        $table = strval($request->table);
        $id = intval($request->id);
        $columnNumber = intval($request->column);
        $value = $request->value;
        $editedColumns['orders'] = [1 => "pip", 2 => "phone", 5 => "price"];
        $editedColumns['products'] = [1 => "name", 3 => "count", 4 => "price", 5 => "count2", 6 => "price2", 7 => "count3", 8 => "price3", 9 => "count4", 10 => "price4"];
        $editedColumns['messages']= [1 => "name", 2 => "subject", 3 => "text", 4 => "phone"];
        $editedColumns['promocodes']= [1 => "promocode", 2 => "discount", 3 => "active_to"];
        $editedColumns['categories'] = [1 => "name"];
        $editedColumns['users'] = [1 => "name", 2 => "email"];
        $editedColumns['partners'] = [1 => "name", 2 => "email", 3 => 'card'];

        $entity = match($table) {
            "orders" => isset($editedColumns['orders'][$columnNumber]) ? Order::find($id) : null,
            "products" => isset($editedColumns['products'][$columnNumber]) ? Product::find($id) : null,
            "messages" => isset($editedColumns['messages'][$columnNumber]) ? Message::find($id) : null,
            "promocodes" => isset($editedColumns['promocodes'][$columnNumber]) ? Promocode::find($id) : null,
            "categories" => isset($editedColumns['categories'][$columnNumber]) ? Category::find($id) : null,
            "users" => isset($editedColumns['users'][$columnNumber]) ? User::find($id) : null,
            "partners" => isset($editedColumns['partners'][$columnNumber]) ? User::find($id) : null
        };

        $column = $editedColumns[$table][$columnNumber];
        $entity->$column = $value;
        $entity->save();

        return $value;
    }

    public function addPromocode(Request $request) {
        $promocodeField = strval($request->promocode);
        $discountField = strval($request->discount);
        $endDateField = $request->end_date;

        $promocode = new Promocode();
        $promocode->promocode = $promocodeField;
        $promocode->discount = $discountField;
        $promocode->active_to = $endDateField;
        $promocode->save();

        return Promocode::find($promocode->id);
    }

    public function deletePromocode(Request $request) {
        $id = intval($request->id);

        $promocode = Promocode::find($id);
        $promocode->delete();

        return true;
    }
}
