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
}
