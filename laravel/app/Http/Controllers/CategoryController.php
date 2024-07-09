<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function addCategory(Request $request) {
        $categoryModel = new Category();

        $categoryModel->name = strval($request->category_name);
        $categoryModel->active = ($request->category_active === "true") ? 1 : 0;
        $categoryModel->keywords = strval($request->category_keywords);
        $imageName = time() . '.' . $request->category_image->extension();
        Storage::disk('public')->putFileAs('/icons', $request->category_image, $imageName);
        $categoryModel->image = $imageName;

        $categoryModel->save();

        return Category::find($categoryModel->id);
    }

    public function updateCategory(Request $request) {
        $category = Category::find(intval($request->id));
        $category->name = strval($request->name);
        $category->keywords = strval($request->keywords);
        $category->image = strval($request->image);

        $category->save();

        return $category;
    }

    public function deleteCategory(Request $request) {
        $products = Product::all()->where("category_id", "=", intval($request->id));
        if (!count($products)) {
            $category = Category::find(intval($request->id));
            $category->delete();

            return true;
        }

        return "В категорії не повинно бути товарів!";
    }

    public function changeCategoryStatus(Request $request) {
        $id = intval($request->id);
        $category = Category::find($id);

        $category->active = intval($request->value);
        $category->save();

        return true;
    }

    public function updateCategoryImage(Request $request) {
        $category = Category::find(intval($request->id));
        $imageName = time() . '.' . $request->category_image->extension();
        if(Storage::disk('public')->exists('icons/' . $category->image)){
            Storage::disk('public')->delete('icons/' . $category->image);
        }
        Storage::disk('public')->putFileAs('/icons', $request->category_image, $imageName);
        $category->image = $imageName;

        $category->save();

        $newCategory = Category::find($category->id);
        return asset("storage") . "/icons/" . $newCategory->image;
    }

    public function editKeywords(Request $request) {
        $idCategory = intval($request->id);
        $keywords = strval($request->keywords);

        $category = Category::find($idCategory);
        $category->keywords = $keywords;
        $category->save();

        return redirect()->back();
    }
}
