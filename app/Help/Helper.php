<?php

namespace App\Help;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class Helper{
    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    public static function getChangeLangLink($locale){
        $segments = Request::segments();
        $params = Request::all();
        if(count($segments) > 0){
            if(in_array($segments[0], ['pl', 'en', 'de'])){
                array_splice($segments, 0, 1);
            }
        }else{
            $segments = array();
        }
        if($locale != 'pl'){
            array_unshift($segments, $locale);
        }
        $temp = implode('/', $segments);
        if(count($params) > 0){
            $temp_param = '?';
            $temp_param = $temp_param.http_build_query($params);
        }else{
            $temp_param = '';
        }
        $temp = $temp.$temp_param;
        return \url('/'.$temp);
    }
}
