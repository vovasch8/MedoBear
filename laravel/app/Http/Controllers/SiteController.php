<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function showCatalog($category = 1) {
        $categories = Category::all()->where("active", "=", true);
        $products = Product::all()->where("category_id", "=", $category)->take(12);

        $products = Product::getProductsWithImages($products);

        return view("catalog", ["categories" => $categories, "products" => $products]);
    }

    public function showProduct($productId) {
        $categories = Category::all()->where("active", "=", true);
        $product = Product::find($productId);

        $product = Product::getProductWithImages($product);

        return view("product", ["categories" => $categories, "product" => $product]);
    }
}
