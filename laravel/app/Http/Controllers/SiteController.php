<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function showCatalog($categoryId = 1) {

        $category = Category::find($categoryId);
        if (!$category) {
            return redirect("/404");
        }
        $orderModel = new Order();
        $categories = Category::all()->where("active", "=", true);
        $products = Product::all()->where("category_id", "=", $categoryId)->where("active", "=", true)->take(12);

        $products = Product::getProductsWithImages($products);
        $mostPopularProducts = $orderModel->getMostPopularProducts(3);
        $mostPopularProducts = Product::getProductsWithImages($mostPopularProducts);

        return view("catalog", ["categories" => $categories, "products" => $products, "mostPopularProducts" => $mostPopularProducts]);
    }

    public function showProduct($productId) {
        $product = Product::find($productId);
        if (!$product) {
            return redirect("/404");
        }

        $categories = Category::all()->where("active", "=", true);
        $product = Product::getProductWithImages($product);

        return view("product", ["categories" => $categories, "product" => $product]);
    }

    public function showDelivery() {
        return view("delivery");
    }

    public function showContacts() {
        return view("contacts");
    }

    public function sendMessage(MessageRequest $request) {
        $messageModel = new Message();

        $messageModel->name = strval($request->name);
        $messageModel->subject = strval($request->subject);
        $messageModel->text = strval($request->text);
        $messageModel->phone = strval($request->phone);

        $messageModel->save();

        return redirect()->route("site.contacts")->with('result', "Звернення успішно відправлено!");
    }

    public function showAbout() {
        return view("about");
    }

    public function applyFilters(Request $request) {
        $type = "name";
        $direct = "asc";

        if ($request->sort == "alpha-up") {
            $type = "name";
            $direct = "desc";
        } elseif ($request->sort == "alpha-down") {
            $type = "name";
            $direct = "asc";
        } elseif ($request->sort == "price-up") {
            $type = "price";
            $direct = "desc";
        } elseif ($request->sort == "price-down") {
            $type = "price";
            $direct = "asc";
        }

        ;
        $products = DB::table("products")
            ->where("name", "like", "%" . $request->search . "%")
            ->whereBetween('price', [intval($request->price[0]), intval($request->price[1])])
            ->orderBy($type, $direct)->get();

        $products = Product::getProductsWithImages(collect($products));

        return view("layouts.products-content", ["products" => $products]);
    }
}
