<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function showCatalog($categoryId = 1) {
//        session()->forget("products");
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

        return view("catalog", ["categories" => $categories, "products" => $products, "mostPopularProducts" => $mostPopularProducts, 'activeCategory' => $category]);
    }

    public function showProduct($productId, $size) {
        $product = Product::find($productId);
        if (!$product || !Product::checkSize($product, $size)) {
            return redirect("/404");
        }

        $categories = Category::all()->where("active", "=", true);
        $product = Product::getProductWithImages($product);

        return view("product", ["categories" => $categories, "product" => $product, 'size' => $size]);
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
        $search = strval($request->search);

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

        $min = intval($request->price[0]);
        $max = intval($request->price[1]);
        $query = DB::table("products");

        if ($search != "") {
            $query->where("name", "like", "%" . $request->search . "%");
        } else {
            $query->where("category_id", "=", intval($request->category_id));
        }

        $query->whereBetween('price', [$min, $max])
            ->orWhereBetween('price2', [$min, $max])
            ->orWhereBetween('price3', [$min, $max])
            ->orWhereBetween('price4', [$min, $max]);

        $products = $query->orderBy($type, $direct)->get();
        $products = Product::getProductsWithImages(collect($products));

        foreach ($products as $product) {
            if($product->price4 < $min || $product->price4 > $max) {
                $product->price4 = null;
                $product->count4 = null;
            } else {
                $product->startPrice = $product->price4;
                $product->startCount = $product->count4;
            } if($product->price3 < $min || $product->price3 > $max) {
                $product->price3 = null;
                $product->count3 = null;
            } else {
                $product->startPrice = $product->price3;
                $product->startCount = $product->count3;
            } if($product->price2 < $min || $product->price2 > $max) {
                $product->price2 = null;
                $product->count2 = null;
            } else {
                $product->startPrice = $product->price2;
                $product->startCount = $product->count2;
            } if ($product->price < $min || $product->price > $max) {
                $product->price = null;
                $product->count = null;
            } else{
                $product->startPrice = $product->price;
                $product->startCount = $product->count;
            }
        }

        return view("layouts.products-content", ["products" => $products]);
    }
}
