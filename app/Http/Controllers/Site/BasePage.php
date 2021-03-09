<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


abstract class BasePage extends Controller
{
    protected $models = [];
    protected $collections = [];
    protected $params;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->params = $request->all();
    }

    protected function renderOutput($template){
       return view($template, $this->collections)->render();
    }

    protected function addCollection($name, $config = false)
    {
        $this->collections[$name] = $this->getResultBuilder($config);
    }




    protected function setBuilder(Model $model, $config)
    {
        if(is_numeric($config)){
            $this->builder = $model->with($model->relations)
                                    ->where('id', $config);
        }else{
            $this->builder = $model->with($model->relations)
                                    ->select($config['select']);
        }
    }

    protected function getResultBuilder($config = false)
    {
        if($config == false){
            return $this->builder->get();
        }elseif($config['paginate'] == true ){
            return $this->builder->paginate($config['amount'])
                                    ->appends(request()->query());
        }else{
            return $this->builder->take($config['amount'])
                                    ->get();
        }
    }
}
