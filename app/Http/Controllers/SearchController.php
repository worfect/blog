<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{

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

}
