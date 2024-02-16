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
            $images = DB::table('product_images')->where('product_images.product_id', $product->id)
                ->join('images', 'images.id', '=', 'product_images.image_id')->orderBy('images.id')->pluck("image");
            $product->images = $images;
        }

        return $products;
    }

    public static function getProductWithImages($product) {
        $images = DB::table('product_images')->where('product_images.product_id', $product->id)
            ->join('images', 'images.id', '=', 'product_images.image_id')->orderBy('images.id')->pluck("image");
        $product->images = $images;

        return $product;
    }
}
