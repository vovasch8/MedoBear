<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function sendMessage(Request $request) {
        $messageModel = new Message();
        $name = strval($request->name);
        $subject = strval($request->subject);
        $text = strval($request->text);
        $phone = strval($request->phone);

        $messageModel->name = $name;
        $messageModel->subject = $subject;
        $messageModel->text = $text;
        $messageModel->phone = $phone;

        $messageModel->save();

        return redirect()->route("contacts")->with('result', "Звернення успішно відправлено!");
    }
}
