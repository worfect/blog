<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class FilterController extends Controller
{

    /**
     * Принимает QueryBuilder и параметры фильтрации.
     * За раз фильтрация производится по одной модели.
     * Возвращает QueryBuilder.
     *
     * @param $builder
     * @param $params
     */
    public function __construct(Builder $builder, array $params)
    {
        $this->params = $params;
        $this->builder = $builder;

        $this->initializationFilter();
    }

    /**
     * Вызов необходимого метода в зависимости от объекта фильтрации.
     *
     * @return void
     */
    protected function initializationFilter()
    {
        $section = $this->checkParams('section');
        if($section == 'gallery' or 'news' or 'blog') {
            $this->contentFilter();
        }
    }

    /**
     * Фильтр контента.
     *
     * @return void
     */
    protected function contentFilter()
    {
        $method = $this->checkParams('method');
        switch ($method){
            case 'new':
                $this->builder->orderBy('updated_at', 'desc');
                break;
            case 'old':
                $this->builder->orderBy('updated_at', 'asc');
                break;
            case 'best':
                $this->selectionByCriterion();
                break;
        }
    }

    protected function selectionByCriterion()
    {
        $criterion = $this->checkParams('criterion');
        switch ($criterion){
            case 'views':
                $this->builder->orderBy('views', 'desc');
                break;
            case 'rating':
                $this->builder->orderBy('rating', 'desc');
                break;
            case 'comments':

                $this->builder->withCount('comments')->orderBy('comments_count', 'desc');


                break;
        }
       $this->selectionByDate();
    }

    protected function selectionByDate()
    {
        $date = $this->checkParams('date');
        switch ($date) {
            case 'all':
                break;
            case '1':
                $this->builder->where('updated_at', '>', Carbon::now()->subDay());
                break;
            case '3':
                $this->builder->where('updated_at', '>', Carbon::now()->subDays(3));
                break;
            case '7':
                $this->builder->where('updated_at', '>', Carbon::now()->subDays(7));
                break;
            case '30':
                $this->builder->where('updated_at', '>', Carbon::now()->subDays(30));
                break;
            case 'year':
                $this->builder->where('updated_at', '>', Carbon::now()->subYear());
                break;
        }
    }

}
