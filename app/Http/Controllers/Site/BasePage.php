<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;


abstract class BasePage extends Controller
{
    protected $models = [];
    protected $params;
    protected $builder;
    protected $collection;

    protected $template;
    protected $parentFolder;
    protected $data = [];


    public function __construct(Request $request)
    {
        $this->params = $request->all();
    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->data);
    }

    /**
     *
     * @param $key
     * @param $data
     * @return void
     */
    protected function insertData($key, $data)
    {
        $this->data = Arr::add($this->data, $key, $data);
    }

    protected function getTemplate($items, $name){
       return view($this->parentFolder . '.' . $name, compact("items"))->render();
    }

    protected function addTemplateInData($items, $name)
    {
        $template = $this->getTemplate($items, $name);
        $this->insertData($name, $template);
    }

    public function setCollection($config)
    {
        if($this->builder == false) {
            $this->collection = false;
        }else{
            if($config['paginate'] == true ){
                $this->collection = $this->builder->paginate($config['amount']);
            }else{
                $this->collection =  $this->builder->take($config['amount'])->get();
            }
        }
    }

    /**
     *
     * @param $model
     * @param $id
     * @return Response
     */
    protected function getById($model, $id)
    {
        $builder = $model->with($model->relations);
        return $builder->where('id', $id)->get();
    }

    protected function setBuilder($model, $config)
    {
        $model ?
            $this->builder = $model->with($model->relations)->select($config['select']) : $this->builder = false;
    }
}
