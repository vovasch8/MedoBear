<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function addProduct(Request $request) {
        $productModel = new Product();

        $productModel->name = strval($request->product_name);
        $productModel->description = strval($request->product_description);
        $productModel->active = ($request->product_active === "true") ? 1 : 0;
        $productModel->category_id = intval($request->product_category_id);
        $productModel->price = intval($request->product_price);
        $productModel->count = strval($request->product_count);

        $productModel->save();
        $product = Product::find($productModel->id);

        $path = public_path('products/' . $product->id);

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $index = 0;
        foreach ($request->product_images as $image) {
            $imageModel = new Image();
            $imageName = $index . time() . '.' . $image->extension();
            Storage::disk('public')->putFileAs('/products/' . $product->id, $image, $imageName);
            $imageModel->image = $imageName;
            $imageModel->save();

            $productImageModel = new ProductImage();
            $productImageModel->image_id = $imageModel->id;
            $productImageModel->product_id = $product->id;
            $productImageModel->save();
            $index++;
        }

        return $product;
    }

    public function changeProductStatus(Request $request) {
        $id = intval($request->id);
        $product = Product::find($id);

        $product->active = intval($request->value);
        $product->save();

        return true;
    }
}
