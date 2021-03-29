<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $model;
    protected $builder;
    protected $config = null;
    protected $collections = [];

    public function collection($config = null): Controller
    {
        $this->config = $config;
        $this->builder = $this->model->with($this->model->relations);

        if(isset($this->config)){
            $this->builder->select($config['select']);
        }else{
            $this->builder;
        }

        return $this;
    }

    public function byId($id): Controller
    {
        $this->builder->where('id', $id);
        return $this;
    }

    public function withSearch($query): Controller
    {
        $this->builder = (new SearchController())->search($this->builder, $query);
        return $this;
    }

    public function withFilter($query): Controller
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

    protected function renderOutput($template){
        return view($template, $this->collections)->render();
    }
}
