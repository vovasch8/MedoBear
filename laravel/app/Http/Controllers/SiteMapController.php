<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function index()
    {
        return response()->view("sitemap", [
            'categories' => Category::pluck("updated_at", "id")->where("active", true),
            'products' => Product::all()->where("active", true)
        ])->header("Content-Type", "text/xml");
    }
}
