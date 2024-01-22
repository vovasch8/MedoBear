<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function showCatalog($category = 1) {
        $categories = Category::all();
        $products = Product::all()->where("category_id", "=", $category)->take(12);

        return view("catalog", ["categories" => $categories, "products" => $products]);
    }

    public function showProduct($productId) {
        $categories = Category::all();
        $product = Product::find($productId);

        return view("product", ["categories" => $categories, "product" => $product]);
    }
}
