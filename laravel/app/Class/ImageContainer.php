<?php
namespace App\Class;

use App\Models\Image;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Storage;

/**
 * Class for control image in container
 * (move, add, remove)
 */
class ImageContainer
{
    /**
     * Move photo in container
     * @param $thisId
     * @param $leftId
     * @param null $rightId
     * @return bool
     */
    public function movePhoto($thisId, $leftId, $rightId = null) {
        $thisImage = ProductImages::find($thisId);
        $fatherImage = ProductImages::find($leftId);

        if ($rightId === null) {
            $thisImage->father_id = $fatherImage->father_id;
            $fatherImage->father_id = $thisId;
        } else {
            $childImage = ProductImages::find($rightId);
            $thisImage->father_id = $fatherImage->father_id;
            $fatherImage->father_id = $thisId;
            $childImage->father_id = $leftId;
            $childImage->save();
        }

        $fatherImage->save();
        $thisImage->save();

        return true;
    }

    /**
     * Add photo in container
     * @param $productId
     * @param $productImages
     * @return bool
     */
    public function addPhoto($productId, $productImages) {

        $firstElement = ProductImages::all()->where("product_id", "=", $productId)->where("father_id", "=", 0)->first();

        $prevProductImagesId = "";

        foreach ($productImages as $index => $image) {
            $imageModel = new Image();
            $imageName = $index . time() . '.' . $image->extension();
            Storage::disk('public')->putFileAs('/products/' . $productId, $image, $imageName);
            $imageModel->image = $imageName;
            $imageModel->save();

            $productImagesModel = new ProductImages();
            $productImagesModel->image_id = $imageModel->id;
            $productImagesModel->product_id = $productId;
            ($index === 0) ? $productImagesModel->father_id = 0 : $productImagesModel->father_id = $prevProductImagesId;
            $productImagesModel->save();
            $prevProductImagesId = $productImagesModel->id;
        }

        if($firstElement) {
            $firstElement->father_id = $prevProductImagesId;
            $firstElement->save();
        }

        return true;
    }

    /**
     * Remove photo from container
     * @param $thisId
     * @param null $leftId
     * @param null $rightId
     * @return bool
     */
    public function removePhoto($thisId, $leftId = null, $rightId = null) {
        $thisImage = ProductImages::find($thisId);

        if(Storage::disk('public')->exists('products/' . $thisImage->product_id)){
            $image = Image::find($thisImage->image_id);
            Storage::disk('public')->delete('products/' . $thisImage->product_id . "/" . $image->image);
            $image->delete();
        }

        if ($thisImage->father_id === 0 && $rightId !== null) {
            $childImage = ProductImages::find($rightId);

            $thisImage->delete();
            $childImage->father_id = 0;
            $childImage->save();
        }else if ($rightId === null) {
            $thisImage->delete();
        } else {
            $childImage = ProductImages::find($rightId);
            $fatherImage = ProductImages::find($leftId);

            $thisImage->delete();
            $childImage->father_id = $fatherImage->id;
            $childImage->save();
        }

        return true;
    }
}
