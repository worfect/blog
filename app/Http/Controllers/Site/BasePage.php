<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;


abstract class BasePage extends Controller
{
    protected $models = [];
    protected $collections = [];
    protected $config;
    protected $builder;

    public function __construct()
    {

    }

    protected function renderOutput($template){
       return view($template, $this->collections)->render();
    }



    protected function addCollection($name)
    {
        if($this->config == false){
            $collection = $this->builder->get();
        }elseif($this->config['paginate'] == true ){
            $collection = $this->builder->paginate($this->config['amount'])
                ->appends(request()->query());
        }else{
            $collection = $this->builder->take($this->config['amount'])
                ->get();
        }
        return $this->collections[$name] = $collection;
    }

    protected function setBuilder(Model $model)
    {
        if($this->config == false){
            $this->builder = $model->with($model->relations);
        } else{
            $this->builder = $model->with($model->relations)
                                    ->select($this->config['select']);
        }
        return $this->builder;
    }

    protected function setBuilderById(Model $model, $id){
        return $this->builder = $model->with($model->relations)
            ->where('id', $id);
    }
}
