<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CopyService extends Model
{
    public function copy($model, array $relations){
        $model->load($relations);
        $new_model = $model->replicate();
        $model_name = get_class($new_model);

        if($new_model->url){
            $check = false;
            $int = 0;
            while (!$check){
                $url = $new_model->url.'_'.$int;
                if(!$model_name::where('url',$url)->withTrashed()->first()){
                    $check = true;
                }
                $int++;
            }
            $new_model->url = $url;
        }
        $new_model->save();
    }
}
