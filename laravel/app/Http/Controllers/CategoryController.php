<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function addCategory(Request $request) {
        $categoryModel = new Category();

        $categoryModel->name = strval($request->category_name);
        $categoryModel->active = ($request->category_active === "true") ? 1 : 0;
        $imageName = time() . '.' . $request->category_image->extension();
        Storage::disk('public')->putFileAs('/icons', $request->category_image, $imageName);
        $categoryModel->image = $imageName;

        $categoryModel->save();

        return Category::find($categoryModel->id);
    }

    public function updateCategory(Request $request) {
        $category = Category::find(intval($request->id));
        $category->name = strval($request->name);
        $category->image = strval($request->image);

        $category->save();

        return $category;
    }

    public function deleteCategory(Request $request) {
        $category = Category::find(intval($request->id));
        $category->delete();

        return true;
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
}
