<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Category;
use App\Models\Message;
use App\Models\Product;

class SiteController extends Controller
{
    public function showCatalog($category = 1) {
        $categories = Category::all()->where("active", "=", true);
        $products = Product::all()->where("category_id", "=", $category)->where("active", "=", true)->take(12);

        $products = Product::getProductsWithImages($products);

        return view("catalog", ["categories" => $categories, "products" => $products]);
    }

    public function showProduct($productId) {
        $categories = Category::all()->where("active", "=", true);
        $product = Product::find($productId);

        $product = Product::getProductWithImages($product);

        return view("product", ["categories" => $categories, "product" => $product]);
    }

    public function showPartnership() {
        return view("partnership");
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
}
