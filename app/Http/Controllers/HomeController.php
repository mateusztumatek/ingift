<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Services\AppService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $promotion = Product::find(2);
        return view('home', compact('promotion'));
    }
    public function previewIframe(){
        return view('vendor.voyager.products.products-settings');
    }
    public function categories(){
        $categories = AppService::getCategories();
        return response()->json($categories);
    }
}
