<?php

namespace App\Http\Controllers;

use App\Class\ImageContainer;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImages;
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
        $productModel->keywords = strval($request->product_keywords);
        $productModel->price = intval($request->product_price);
        $productModel->count = strval($request->product_count);
        if (intval($request->product_price2) && strval($request->product_count2)) {
            $productModel->price2 = intval($request->product_price2);
            $productModel->count2 = strval($request->product_count2);
        }
        if (intval($request->product_price3) && strval($request->product_count3)) {
            $productModel->price3 = intval($request->product_price3);
            $productModel->count3 = strval($request->product_count3);
        }
        if (intval($request->product_price4) && strval($request->product_count4)) {
            $productModel->price4 = intval($request->product_price4);
            $productModel->count4 = strval($request->product_count4);
        }

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

            $productImagesModel = new ProductImages();
            $productImagesModel->image_id = $imageModel->id;
            $productImagesModel->product_id = $product->id;
            ($index === 0) ? $productImagesModel->father_id = 0 : $productImagesModel->father_id = $prevProductImagesId;
            $productImagesModel->save();
            $prevProductImagesId = $productImagesModel->id;
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

    public function changeProductCategory(Request $request) {
        $id = intval($request->id);
        $product = Product::find($id);

        $product->category_id = intval($request->value);
        $product->save();

        return true;
    }

    public function movePhotoProduct(Request $request) {
        $imageContainer = new ImageContainer();
        $idProduct = intval($request->product_id);
        $thisId = intval($request->this_id);
        $fatherId = $request->father_id == null ? null : intval($request->father_id);
        $childId = $request->child_id == null ? null : intval($request->child_id);
        $direction = $request->direction;

        $imageContainer->movePhoto($thisId, $fatherId, $childId, $direction);

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

    public function deleteProduct(Request $request) {
        $id = intval($request->id);

        $product = Product::find($id);

        $productImages = ProductImages::where("product_id", "=", $id)->get();
        foreach ($productImages as $image) {
            $image->delete();
        }
        $product->delete();
        Storage::disk('public')->deleteDirectory("products/" . $id);

        return true;
    }

    public function editDescription(Request $request) {
        $idProduct = intval($request->id);
        $content = strval($request->input("content"));

        $product = Product::find($idProduct);
        $product->description = $content;
        $product->save();

        return redirect()->back();
    }

    public function editKeywords(Request $request) {
        $idProduct = intval($request->id);
        $keywords = strval($request->keywords);

        $product = Product::find($idProduct);
        $product->keywords = $keywords;
        $product->save();

        return redirect()->back();
    }
}
