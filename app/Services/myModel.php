<?php
namespace App\Services;

use App\Triats\FilterTrait;
use Illuminate\Database\Eloquent\Model;

class myModel extends Model{
    use FilterTrait;
    public function hasProperty($property){
        $item = array_search($property, $this->fillable);
        return $item != false;
    }
    public function hasRelationship($name){
        return method_exists($this, $name);
    }
}
