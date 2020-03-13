<?php

namespace App\Http\Controllers;

use App\Services\Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class BreadController extends Controller
{
    public function store(Request $request, $model){
        if($model != 'Setting'){
            ($request->model_name)? $model = $request->model_name : null;
        }
        if(Auth::id()){
            $request->request->set('user_id', Auth::id());
        }

        $model_name = Help::getClassName($model);
        $model = App::make($model_name);
        if(method_exists($model_name, 'additionalCreateFields')){
            $add_fields = $model_name::additionalCreateFields();
            $request->merge($add_fields);
        }
        (method_exists($model_name, 'storeValidations'))? $validations = $model_name::storeValidations() : $validations = [];
        $request->validate($validations);
        (method_exists($model_name, 'beforeStore'))? $model_name::beforeStore($request) : null;
        $model = $model_name::create($request->all());

        return response()->json($model);
    }
    public function index(Request $request, $model){
        ($request->model_name)? $model = $request->model_name : null;
        if($request->user('api') && \request()->route()->getPrefix() != '/admin'){
            $request->request->set('user_id', $request->user('api')->id);
        }

        $model_name = Help::getClassName($model);
        $model = App::make($model_name);
        $models = $model_name::where('id', '>', 0)->filter();
        if($request->relations){
            $models->with($request->relations);
        }
        $models = $models->paginate(($request->per_page)? $request->per_page : 25);
        return response()->json($models);
    }
    public function show(Request $request, $model, $id){
        ($request->model_name)? $model = $request->model_name : null;
        if($request->user('api')){
            $request->request->set('user_id', $request->user('api')->id);
        }

        $model_name = Help::getClassName($model);
        $model = App::make($model_name);

        $model = $model_name::where(($request->getBy)? $request->getBy : 'id', $id);
        if($request->relations){
            $model = $model->with($request->relations);
        }
        $model = $model->first();
        if($model){
            if(method_exists($model, 'hasProperty') && $model->hasProperty('user_id')){
                if($model->user_id != $request->user_id) throw new UnauthorizedException();
            }
        }else{
            throw new \Exception('Brak elementu');
        }
        return response()->json($model);
    }
    public function update(Request $request, $model, $id){
        if($request->model_name) $model = $request->model_name;
        $request->request->set('user_id', $request->user('api')->id);
        $model_name = Help::getClassName($model);
        $model = $model_name::where('id', $id)->first();
        if(!$model) throw new \Exception('Brak elementu');
        (method_exists($model_name, 'updateValidations'))? $validations = $model_name::updateValidations() : $validations = [];
        $request->validate($validations);
        (method_exists($model_name, 'beforeUpdate'))? $model_name::beforeUpdate($request, $model) : null;
        $model->update($request->all());
        foreach ($request->all() as $key => $element){
            if(is_array($element)){
                if($model->hasRelationship($key)){
                    $model->$key()->delete();
                    foreach ($element as $data){
                        $model->$key()->create($data);
                    }
                }
            }
        }
        return response()->json($model);
    }
    public function destroy(Request $request, $model, $id){
        ($request->model_name)? $model = $request->model_name : null;
        $request->request->set('user_id', $request->user('api')->id);
        $model_name = Help::getClassName($model);
        $model = $model_name::where('id', $id)->first();
        $model->delete();
        return response()->json(true);
    }
}
