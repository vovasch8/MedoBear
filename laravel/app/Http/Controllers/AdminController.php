<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
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
        $categories = Category::all()->sortByDesc("id")->take(5);
        $orders = Order::all()->sortByDesc("id");
        $lastOrders = $orders->slice(0,5);
        $messages = Message::all()->sortByDesc("id")->take(5);
        $countOrdersThisMonth = $orderModel->getOrdersByMonth();
        $countOrdersBy6Month = $orderModel->getOrdersBy6Month();

        return view("admin.index", ["products" => $products, "categories" => $categories, "orders" => $orders, "lastOrders" => $lastOrders, "messages" => $messages, "countOrdersThisMonth" => $countOrdersThisMonth, "countOrdersBy6Month" => $countOrdersBy6Month]);
    }

    public function charts() {
        $this->authorize("view-manager", Auth::user());
        $orderModel = new Order();

        $countOrdersThisMonth = $orderModel->getOrdersByMonth();
        $countOrdersBy6Month = $orderModel->getOrdersBy6Month();
        $mostPopularProducts = $orderModel->getMostPopularProducts();

        return view("admin.charts", ["countOrdersThisMonth" => $countOrdersThisMonth, "countOrdersBy6Month" => $countOrdersBy6Month, "mostPopularProducts" => $mostPopularProducts]);
    }

    public function tables() {
        $this->authorize("view-manager", Auth::user());
        $orders = Order::all()->sortByDesc("id");

        return view("admin.tables", ["orders" => $orders, 'typeTable' => "orders", 'editedColumns' => [1, 2, 5]]);
    }

    public function categoriesTable() {
        $this->authorize("view-admin", Auth::user());
        $categories = Category::all()->sortByDesc("id");

        return view("admin.categories-table", ["categories" => $categories, 'typeTable' => "categories", "editedColumns" => [1]]);
    }

    public function usersTable() {
        $this->authorize("view-admin", Auth::user());
        $users = User::all()->sortByDesc("id");

        return view("admin.users-table", ["users" => $users, 'typeTable' => "users", "editedColumns" => [1, 2]]);
    }

    public function productsTable() {
        $this->authorize("view-manager", Auth::user());
        $products = Product::all()->sortByDesc("id");
        $products = Product::getProductsWithImages($products);

        return view("admin.products-table", ["products" => $products, 'typeTable' => "products", "editedColumns" => [1, 2, 3, 4]]);
    }

    public function messagesTable() {
        $this->authorize("view-manager", Auth::user());
        $messages = Message::all()->sortByDesc("id");

        return view("admin.messages-table", ["messages" => $messages, 'typeTable' => "messages", "editedColumns" => [1, 2, 3, 4]]);
    }

    public function editColumnTable(Request $request) {
        $table = strval($request->table);
        $id = intval($request->id);
        $columnNumber = intval($request->column);
        $value = $request->value;
        $editedColumns['orders'] = [1 => "pip", 2 => "phone", 5 => "price"];
        $editedColumns['products'] = [1 => "name", 2 => "description", 3 => "price", 4 => "count"];
        $editedColumns['messages']= [1 => "name", 2 => "subject", 3 => "text", 4 => "phone"];
        $editedColumns['categories'] = [1 => "name"];
        $editedColumns['users'] = [1 => "name", 2 => "email"];

        $entity = match($table) {
            "orders" => isset($editedColumns['orders'][$columnNumber]) ? Order::find($id) : null,
            "products" => isset($editedColumns['products'][$columnNumber]) ? Product::find($id) : null,
            "messages" => isset($editedColumns['messages'][$columnNumber]) ? Message::find($id) : null,
            "categories" => isset($editedColumns['categories'][$columnNumber]) ? Category::find($id) : null,
            "users" => isset($editedColumns['users'][$columnNumber]) ? User::find($id) : null
        };

        $column = $editedColumns[$table][$columnNumber];
        $entity->$column = $value;
        $entity->save();

        return $value;
    }
}
