<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class ProductAttribute extends Model
{
    use Translatable;
    protected $fillable = ['product_id', 'attribute_id', 'value'];
    public function attribute(){
        return $this->belongsTo('App\Attribute');
    }
    protected $translatable = ['value'];
}
