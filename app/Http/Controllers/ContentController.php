<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;

class ContentController extends Controller
{
    public $model;
    protected $builder;
    protected $config = null;
    protected $collections = [];

    public function collection($config = null): ContentController
    {
        $this->config = $config;
        $this->builder = $this->model->with($this->model->relations);

        if(isset($this->config)) {
            $this->builder->select($config['select']);
        }

        return $this;
    }

    public function byId($id): ContentController
    {
        $this->builder->where('id', $id);
        return $this;
    }

    public function withSearch($query): ContentController
    {
        $this->builder = (new SearchController())->search($this->builder, $query);
        return $this;
    }

    public function withFilter($query): ContentController
    {
        $this->builder = (new FilterController())->filter($this->builder, $query);
        return $this;
    }

    public function get()
    {
        if($this->config == false){
            return $this->builder->get();
        }elseif($this->config['paginate'] == true) {
            return $this->builder->paginate($this->config['amount'])
                ->appends(request()->query());
        }else{
            return $this->builder->take($this->config['amount'])
                ->get();
        }
    }


    public function builder(): Builder
    {
        return $this->builder;
    }

    protected function renderOutput($template)
    {
        return view($template, $this->collections)->render();
    }

    protected function increaseViewsCount($id)
    {
        $post = $this->model::find($id);
        $post->views = ++$post->views;
        $post->save();
    }
}
