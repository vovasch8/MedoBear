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
            'categories' => Category::pluck("updated_at", "id"),
            'products' => Product::pluck("updated_at", "id")
        ])->header("Content-Type", "text/xml");
    }
}
