<?php


namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Http\Request;

class QuickSearchController extends Controller
{
    /**
     * За раз поиск производится по одной модели.
     * Возвращает Collection.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->params = $request->all();
    }

    /**
     * Обрабатывает AJAX запрос.
     *
     * @return false or Collection
     */
    public function search()
    {
        $this->getModel();

        if ($this->model == false){
            return false;
        }

        $query= $this->checkParams('query');
        $searchTerm = '%' .  $query . '%';
        return $this->model->where('title','like', $searchTerm)->get();
    }

    /**
     * Запись необходимого объекта модели в свойство
     *
     */
    protected function getModel()
    {
        $section = $this->checkParams('section');
        if($section == 'gallery'){
            $this->model = new Gallery;
        }
        if($section == 'blog'){
            $this->model = new Blog;
        }
        if($section == 'news'){
            $this->model = new News;
        }
        if($section == 'all'){
            $this->model = new News;
        }
    }

}
