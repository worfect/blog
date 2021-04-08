<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Http\Request;


class SearchController extends ContentController
{

    protected $params;

    protected function search($builder, $query)
    {
        $this->builder = $builder;
        $this->params = $query;

        $section = $this->checkParams('section');
        if($section == 'gallery' or 'news' or 'blog') {
            $this->contentSearch();
        }

        return $this->builder;
    }

    public function index(NewsController $news, BlogController $blog,
                                        GalleryController $gallery, Request $request)
    {
        if($request->query()){
            $units = [
                'blog' => $blog,
                'news' => $news,
                'gallery' => $gallery,
            ];
            foreach ($units as $name => $controller){
                $collection = $controller->collection(config('site_settings.search.' . $name))
                                                        ->withSearch($request->query())
                                                        ->withFilter($request->query())
                                                        ->get();
                if($collection->isNotEmpty()){
                    $this->collections[$name] = $collection;
                }
            }
            if($this->collections === []){
                notice()->warning('Nothing found')->session();
            }
        }
        return $this->renderOutput('search.index');
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
//            Да, ничего умнее я не придумал
            $query = '!#%&(@$^*)';
        }
            $searchTerm = '%' .  $query . '%';
            $this->builder->where('title','like', $searchTerm);
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



    public function quickSearch()
    {
        $controller = $this->getController(request()->get('section'));
        if ($controller == false){
            return false;
        }

        $searchTerm = '%' .  request()->get('query') . '%';
        return $controller->collection()->builder()
                                        ->where('title','like', $searchTerm)
                                        ->get();
    }

    /**
     *
     * @param $section
     * @return BlogController|GalleryController|NewsController
     */
    protected function getController($section)
    {
        if($section == 'gallery'){
            return new GalleryController(new Gallery);
        }
        if($section == 'blog'){
            return  new BlogController(new Blog);
        }
        if($section == 'news'){
            return new NewsController(new News);
        }
    }


}
