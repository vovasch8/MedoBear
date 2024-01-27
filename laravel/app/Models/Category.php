<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function getNameCategoryById($id) {
        $category = Category::find($id);

        return $category->name;
    }
}
