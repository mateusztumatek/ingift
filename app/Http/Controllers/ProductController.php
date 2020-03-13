<?php

namespace App\Http\Controllers;

use App\Product;
use App\Relations\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    public function show(Request $request, $slug){
        $product = Product::where('url', $slug)->first();
        $product = $product->translate(App::getLocale(), 'pl');
        $attributes = ProductAttribute::where('product_id', $product->id)->whereHas('attribute', function ($q){
            $q->where('selectable', 1);
        })->get();
        $attributes = $attributes->groupBy('attribute_id');
        if(!$product) return back()->with(['message' => 'Produkt nie istnieje']);
        return view('products.single', compact('product', 'attributes'));
    }
}
