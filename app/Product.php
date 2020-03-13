<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Traits\Translatable;

class Product extends Model
{
    use Translatable;
    protected $translatable = ['desc', 'name', 'url', 'page_description'];
    protected $fillable = ['desc', 'name', 'images', 'main_image', 'orders_count','views_count', 'data', 'external_id', 'short_desc', 'url', 'page_title', 'page_description', 'price', 'price_sellout', 'active', 'is_new', 'attachments', 'stock', 'sku', 'country', 'sku_parrent', 'weight', 'in_package', 'baselinker_id'];
    protected $table = 'products';
    public $appends = ['calculated', 'design_price', 'link', 'is_customizable', 'all_images'];
    protected $sortable = ['created_at', 'price', 'name', 'is_new'];
    use SoftDeletes;

    public function getAllImagesAttribute(){
        $collect = collect();
        if($this->images){
            $collect->push($this->images);
        }
        $collect->prepend($this->main_image);
        return $collect;
    }
    public function getIsCustomizableAttribute(){
        if($this->data == null || $this->data == '' || $this->data == '[]') return false;
        try{
            $data = json_decode($this->data);
            if(is_array($data)){
                $check = false;
                foreach ($data as $item){
                    if($item->text->type == 'image' || $item->text->type == 'text') $check = true;
                }
                return $check;
            }else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }
    public function getData(){
        return json_decode($this->data);
    }
    public function getCustomizableItems(){
        $collect = collect();
        foreach ($this->getData() as $item){
            if($item->text->type == 'image' || $item->text->type == 'text'){
                $item->text->id = $item->id;
                $item->text->field_name = $item->field_name;
                $collect->push($item->text);
            }
        }
        return $collect;
    }
    public function getCalculatedAttribute()
    {
        if($this->price_sellout && $this->price_sellout < $this->price){
            return number_format($this->price_sellout, 2);
        }
        return number_format($this->price, 2);
    }
    public function getLinkAttribute(){
        return $this->getLink();
    }
    public function getDesignPriceAttribute()
    {
        return 25;
    }
    public function tags(){
        return $this->hasMany('App\relations\Tag', 'foreign_key')->where('type', 'product');
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'product_categories');
    }
    public function attributes(){
        return $this->hasMany('App\Relations\ProductAttribute', 'product_id')->with('attribute');
    }
    public function delete()
    {
        DB::table('product_categories')->where('product_id', $this->id)->delete();
        $this->attributes()->delete();
        return parent::delete(); // TODO: Change the autogenerated stub
    }
    public function getPrice(){
        return $this->price;
    }
    public function getImages(){
        $images = collect();
        if($this->images && $this->images != ''){
            $tmp = json_decode($this->images);
            foreach ($tmp as $t){
                $images->push($t);
            }
        }
        if($this->main_image){
            $images->prepend($this->main_image);
        }
        $images = $images->unique();
        if(count($images) == 0){
            $images->push('/products/default.jpg');
        }
        return $images;
    }
    public function getLink(){
        return url('/produkt/'.$this->url);
    }

}
