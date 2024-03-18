<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    public static function getProductsWithImages($products) {
        foreach ($products as $product) {
            $images = DB::table('product_images')->select("product_images.id", "product_images.father_id", "product_images.image_id", "images.image")
                ->where('product_images.product_id', $product->id)
                ->join('images', 'images.id', '=', 'product_images.image_id')->orderBy('product_images.id')->get();
            $images = self::orderByFather($images);
            $product->images = $images;
        }

        return $products;
    }

    public static function getProductWithImages($product) {
        $images = DB::table('product_images')->select("product_images.id", "product_images.father_id", "product_images.image_id", "images.image")
            ->where('product_images.product_id', $product->id)
            ->join('images', 'images.id', '=', 'product_images.image_id')->orderBy('product_images.id')->get();
        $images = self::orderByFather($images);
        $product->images = $images;

        return $product;
    }

    public static function orderByFather($images) {
        $sortArr = [];
        $father = $images->where("father_id", "=", 0)->first();
        while (!empty($father)) {
            $sortArr[] = $father;
            $father = $images->where("father_id", "=", $father->id)->first();
        }

        return $sortArr;
    }
}
