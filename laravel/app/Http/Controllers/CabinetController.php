<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CabinetController extends Controller
{
    public function dashboard() {
        $this->authorize("view-user", Auth::user());

        $categories = Category::all()->where("active", true);
        foreach ($categories as $category) {
            $category->products = Product::all()->where("category_id", $category->id);
        }

        $userOrders = DB::table("orders")
            ->join("user_orders", "orders.id", "=", "user_orders.order_id")
            ->where("user_id", "=", Auth::user()->id)
            ->orderBy("orders.id", "desc")
            ->simplePaginate(9);

        foreach ($userOrders as $order) {
            $products = DB::table('products')
                ->join("order_products", "products.id", "=", "order_products.product_id")
                ->where("order_products.order_id", "=", $order->order_id)
                ->select("products.id as id", "products.name", "order_products.price", "products.category_id", "order_products.order_id", "order_products.product_id", "order_products.count", "order_products.size")
                ->get();
            $order->products = Product::getProductsWithImages($products);
        }

        return view("dashboard", ["orders" => $userOrders, "categories" => $categories]);
    }
}
