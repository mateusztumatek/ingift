<?php

namespace App\Services;

use App\Category;

class AppService{
    public static function getCategories(){
        $categories = Category::where('active', 1)->where('parent_id', null)->with('childrens')->get();
        $categories = $categories->groupBy('type');
        return $categories;
    }
}
