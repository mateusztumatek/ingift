<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
/*    use Translatable;*/
    protected $fillable = ['name', 'url', 'desc', 'page_title', 'page_description', 'images', 'active', 'parent_id', 'type'];
    protected $table = 'categories';
/*    protected $translatable = ['name', 'desc', 'page_title', 'page_description'];*/

    public static function all($columns = ['*'])
    {
        $categories = Category::where('active', 1)->get();
        return $categories;
    }
    public function childrens(){
        return $this->hasMany('App\Category', 'parent_id')->with('childrens');
    }

    public function getImage(){
        $arr = array();

        if($this->images == '' && $this->images == null){
            $arr = ['default/brak_zdjecia.png'];

        }else{
            $arr = json_decode($this->images);
            if(count($arr) == 0) $arr = ['default/brak_zdjecia.png'];
        }
        return json_encode($arr);
    }
    public function getLink(){
        return url('/kategoria/'.$this->url);
    }
    public function delete()
    {
        return parent::delete(); // TODO: Change the autogenerated stub
    }
    public function products(){
        return $this->hasMany('App\Product');
    }
    public function getHeader(){
        $term = '';
        $term = $term.$this->page_title;
        return $term;
    }
    public function getUrl(){
        $url = route('category', ['slug' => $this->url]);
        return $url;
    }
}
