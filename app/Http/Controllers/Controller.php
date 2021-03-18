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

    protected $params;
    protected $model;
    protected $builder;
    protected $config = null;

    public function collection($config = null)
    {
        $this->config = $config;
        $this->builder = $this->model->with($this->model->relations);

        if(isset($this->config)){
            $this->builder->select($config['select']);
        }else{
            $this->builder;
        }
    }

    public function byId($id){
        $this->builder->where('id', $id);
    }

    public function withSearch($query)
    {
        $this->builder = (new SearchController($this->builder, $query))->builder();
    }

    public function withFilter($query)
    {
        $this->builder = (new FilterController($this->builder, $query))->builder();
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

    /**
     * Возвращает построитель запросов.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return $this->builder;
    }

    /**
     * Проверяет наличие поля в параметрах.
     *
     * @param $param
     * @return string
     */
    protected function checkParams($param)
    {
        return isset($this->params[$param]) ? $this->params[$param] : false;
    }


}
