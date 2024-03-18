<?php

namespace App\Http\Controllers;

use App\Class\ImageContainer;
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
        $productImages = $request->product_images;

        $productModel->save();
        $product = Product::find($productModel->id);

        $path = public_path('products/' . $product->id);

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        foreach ($productImages as $index => $image) {
            $imageModel = new Image();
            $imageName = $index . time() . '.' . $image->extension();
            Storage::disk('public')->putFileAs('/products/' . $product->id, $image, $imageName);
            $imageModel->image = $imageName;
            $imageModel->save();

            $productImageModel = new ProductImage();
            $productImageModel->image_id = $imageModel->id;
            $productImageModel->product_id = $product->id;
            ($index === 0) ? $productImageModel->father_id = 0 : $productImageModel->father_id = $prevProductImageId;
            $productImageModel->save();
            $prevProductImageId = $productImageModel->id;
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

    public function movePhotoProduct(Request $request) {
        $imageContainer = new ImageContainer();
        $idProduct = intval($request->product_id);
        $thisId = intval($request->this_id);
        $leftId = intval($request->left_id);
        $rightId = $request->right_id != null ? intval($request->right_id) : null;

        $imageContainer->movePhoto($thisId, $leftId, $rightId);

        $product = Product::getProductWithImages(Product::all()->where("id", "=", $idProduct)->first());

        return $product;
    }

    public function addPhotoProduct(Request $request) {
        $imageContainer = new ImageContainer();
        $idProduct = intval($request->product_id);
        $product_images = $request->product_images;

        $imageContainer->addPhoto($idProduct, $product_images);

        $product = Product::getProductWithImages(Product::all()->where("id", "=", $idProduct)->first());

        return $product;
    }

    public function removePhotoProduct(Request $request) {
        $imageContainer = new ImageContainer();
        $idProduct = intval($request->product_id);
        $thisId = intval($request->this_id);
        $leftId = ($request->left_id !== null) ? intval($request->left_id) : null;
        $rightId = ($request->right_id !== null) ? intval($request->right_id) : null;

        $imageContainer->removePhoto($thisId, $leftId, $rightId);

        $product = Product::getProductWithImages(Product::all()->where("id", "=", $idProduct)->first());

        return $product;
    }
}
