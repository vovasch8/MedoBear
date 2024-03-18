<?php
namespace App\Class;

use App\Models\Image;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ImageContainer
{
    public function movePhoto($thisId, $leftId, $rightId = null) {
        $thisImage = ProductImage::find($thisId);
        $fatherImage = ProductImage::find($leftId);

        if ($rightId === null) {
            $thisImage->father_id = $fatherImage->father_id;
            $fatherImage->father_id = $thisId;
        } else {
            $childImage = ProductImage::find($rightId);
            $thisImage->father_id = $fatherImage->father_id;
            $fatherImage->father_id = $thisId;
            $childImage->father_id = $leftId;
            $childImage->save();
        }

        $fatherImage->save();
        $thisImage->save();

        return true;
    }

    public function addPhoto($productId, $productImages) {

        $firstElement = ProductImage::all()->where("product_id", "=", $productId)->where("father_id", "=", 0)->first();

        $prevProductImageId = "";

        foreach ($productImages as $index => $image) {
            $imageModel = new Image();
            $imageName = $index . time() . '.' . $image->extension();
            Storage::disk('public')->putFileAs('/products/' . $productId, $image, $imageName);
            $imageModel->image = $imageName;
            $imageModel->save();

            $productImageModel = new ProductImage();
            $productImageModel->image_id = $imageModel->id;
            $productImageModel->product_id = $productId;
            ($index === 0) ? $productImageModel->father_id = 0 : $productImageModel->father_id = $prevProductImageId;
            $productImageModel->save();
            $prevProductImageId = $productImageModel->id;
        }

        if($firstElement) {
            $firstElement->father_id = $prevProductImageId;
            $firstElement->save();
        }

        return true;
    }

    public function removePhoto($thisId, $leftId = null, $rightId = null) {
        $thisImage = ProductImage::find($thisId);

        if(Storage::disk('public')->exists('products/' . $thisImage->product_id)){
            $image = Image::find($thisImage->image_id);
            Storage::disk('public')->delete('products/' . $thisImage->product_id . "/" . $image->image);
            $image->delete();
        }

        if ($thisImage->father_id === 0 && $rightId !== null) {
            $childImage = ProductImage::find($rightId);

            $thisImage->delete();
            $childImage->father_id = 0;
            $childImage->save();
        }else if ($rightId === null) {
            $thisImage->delete();
        } else {
            $childImage = ProductImage::find($rightId);
            $fatherImage = ProductImage::find($leftId);

            $thisImage->delete();
            $childImage->father_id = $fatherImage->id;
            $childImage->save();
        }

        return true;
    }
}
