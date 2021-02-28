<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchController extends Controller
{

    protected $params;
    protected $model;
    protected $builder;

    /**
     * Принимает QueryBuilder и параметры поиска.
     * За раз поиск производится по одной модели.
     * Возвращает QueryBuilder.
     *
     * @param $builder
     * @param $params
     */
    public function __construct(Builder $builder, array $params)
    {
        $this->params = $params;
        $this->builder = $builder;

        $this->initializationSearch();
    }

    /**
     * Вызов необходимого метода в зависимости от объекта поиска.
     *
     * @return void
     */
    protected function initializationSearch()
    {
        $section = $this->checkParams('section');
        if($section == 'gallery' or 'news' or 'blog') {
            $this->contentSearch();
        }
    }


    /**
     * Поиск контента по заголовкам.
     *
     * @return void
     */
    public function contentSearch()
    {
        $query = $this->checkParams('search-query');
        if($query == ''){
            $this->builder = false;
        }else{
            $searchTerm = '%' .  $query . '%';
            $this->builder->where('title','like', $searchTerm);
        }

    }


    /**
     * Возвращает построитель запросов.
     *
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Возвращает коллекцию.
     *
     * @return Collection
     */
    public function getCollection()
    {
        return $this->builder->get();
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
