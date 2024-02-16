<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $products = Product::all()->sortByDesc("id")->take(5);
        $categories = Category::all()->sortByDesc("id")->take(5);
        $orders = Order::all()->sortByDesc("id");
        $lastOrders = $orders->slice(0,5);

        return view("admin.index", ["products" => $products, "categories" => $categories, "orders" => $orders, "lastOrders" => $lastOrders]);
    }

    public function charts() {

        return view("admin.charts");
    }

    public function tables() {
        $orders = Order::all()->sortByDesc("id");

        return view("admin.tables", ["orders" => $orders]);
    }
}
