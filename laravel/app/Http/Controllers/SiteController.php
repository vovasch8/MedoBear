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
//        session()->forget("products");
        $category = Category::find($categoryId);
        if (!$category) {
            return redirect("/404");
        } if (isset($_GET['partner'])) {
            $link = strtok(urldecode(\Request::fullUrl()),'?');
            if (mb_substr($link, -1) == "/") {
                $link = mb_substr($link, 0, -1);
            }
            session(['partner' => intval($_GET['partner']), 'link' => $link]);
        }
        $orderModel = new Order();
        $categories = Category::all()->where("active", "=", true);
        $products = Product::all()->where("category_id", "=", $categoryId)->where("active", "=", true)->take(12);

        $products = Product::getProductsWithImages($products);
        $mostPopularProducts = $orderModel->getMostPopularProducts(6);
        $mostPopularProducts = Product::getProductsWithImages($mostPopularProducts);

        return view("catalog", ["categories" => $categories, "products" => $products, "mostPopularProducts" => $mostPopularProducts, 'activeCategory' => $category]);
    }

    public function showProduct($productId, $size) {
        $product = Product::find($productId);
        if (!$product || !Product::checkSize($product, $size)) {
            return redirect("/404");
        } if (isset($_GET['partner'])) {
            $link = strtok(urldecode(\Request::fullUrl()),'?');
            if (mb_substr($link, -1) == "/") {
                $link = mb_substr($link, 0, -1);
            }
            session(['partner' => intval($_GET['partner']), 'link' => $link]);
        }

        $categories = Category::all()->where("active", "=", true);
        $product = Product::getProductWithImages($product);

        return view("product", ["categories" => $categories, "product" => $product, 'size' => $size, "activeCategory" => Category::find($product->category_id)]);
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

        $min = intval($request->price[0]);
        $max = intval($request->price[1]);
        $query = DB::table("products");

        $query = Product::where(function ($query) use ($request) {
            if (strval($request->search) != "") {
                return $query->where("name", "like", "%" . strval($request->search) . "%");
            } else {
                return $query->where("category_id", "=", intval($request->category_id));
            }
        })->where(function ($query) use ($min, $max) {
            return $query->whereBetween('price', [$min, $max])
                ->orWhereBetween('price2', [$min, $max])
                ->orWhereBetween('price3', [$min, $max])
                ->orWhereBetween('price4', [$min, $max]);
        });

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

    public function seoMap() {
        $data = [];
        $categories = Category::all();
        $data[] = ["group" => 1, "id" => "MedoBear", "name" => "MedoBear", "link" => route("site.catalog"), "size" => 25, "color" => "green"];
        $links = [];
        $data[] = ["group" => 2, "id" => "Про нас", "name" => "Про нас", "link" => route("site.about_us"), "size" => 12, "color" => "red"];
        $links[] = ["source"=> "Про нас", "target"=> "MedoBear"];
        $data[] = ["group" => 2, "id" => "Контакти", "name" => "Контакти", "link" => route("site.contacts"), "size" => 12, "color" => "red"];
        $links[] = ["source"=> "Контакти", "target"=> "MedoBear"];
        $data[] = ["group" => 2, "id" => "Доставка", "name" => "Доставка", "link" => route("site.delivery"), "size" => 12, "color" => "red"];
        $links[] = ["source"=> "Доставка", "target"=> "MedoBear"];

        foreach ($categories as $category) {
            $products = Product::all()->where("category_id", "=", $category->id);
            $data[] = ["group" => 2, "id" => $category->name, "name" => $category->name, "link" => route("site.current_catalog", $category->id), "size" => 12, "color" => "red"];
            $links[] = ["source"=> "MedoBear", "target"=> $category->name];
            $keywords = explode(", ", $category->keywords);
            if ($keywords[0] != "") {
                foreach ($keywords as $keyword) {
                    $data[] = ["group" => 10, "id" => $category->name . $keyword, "name" => $keyword, "link" => route("site.current_catalog", $category->id), "size" => 1, "color" => "yellow"];
                    $links[] = ["source" => $category->name, "target" => $category->name . $keyword];
                }
            }
            foreach ($products as $product) {
                $sizes = 0;
                $nameSizes = [];
                if ($product->count) {
                    $sizes++;
                    $nameSizes[] = $product->count;
                } if ($product->count2) {
                    $sizes++;
                    $nameSizes[] = $product->count2;
                } if($product->count3) {
                    $sizes++;
                    $nameSizes[] = $product->count3;
                } if ($product->count4) {
                    $sizes++;
                    $nameSizes[] = $product->count4;
                }
                $data[] = ["group" => 3, "id" => $product->name, "name" => $product->name, "link" => route("site.product", [$product->id, $product->count]), "size" => 10, "color" => "blue"];
                $links[] = ["source"=> $category->name, "target"=> $product->name];
                $keywords = explode(", ", $product->keywords);
                if ($keywords[0] != "") {
                    foreach ($keywords as $keyword) {
                        $data[] = ["group" => 10, "id" => $keyword, "name" => $keyword, "link" => route("site.product", [$product->id, $product->count]), "size" => 1, "color" => "yellow"];
                        $links[] = ["source" => $product->name, "target" => $keyword];
                    }
                }
                foreach ( $nameSizes as $size) {
                    $data[] = ["group" => 4, "id" => $product . $size, "name" => $size, "link" => route("site.product", [$product->id, $size]), "size" => 5, "color" => "black", "non_show" => true];
                    $links[] = ["source"=> $product->name, "target"=> $product . $size];

                }
            }
        }

        return view("seo-map", ["data" => json_encode($data), "links" => json_encode($links)]);
    }
}
