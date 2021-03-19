<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FilterController;
use App\Http\Controllers\SearchController;

use App\Models\News;
use App\Models\Blog;
use App\Models\Gallery;

use Illuminate\Http\Request;

class SearchPage extends BasePage
{
    public function __construct(News $news, Blog $blog, Gallery $gallery)
    {

        $this->models = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
        ];
    }

    public function index(Request $request)
    {
        if($request->query()){
            $this->selectModel($request->query('section'));

            foreach ($this->models as $name => $model){
                $this->config = config('site_settings.search.' . $name);
                $this->setBuilder($model);

                $this->builder = (new FilterController($this->builder, $request->query()))->getBuilder();
                $this->builder = (new SearchController($this->builder, $request->query()))->getBuilder();
                if($this->builder){
                    $this->addCollection($name);
                }
            }

            if($this->collections === []){
                notice()->warning('Nothing found')->session();
            }
        }

        return $this->renderOutput('search.search');
    }

    protected function selectModel ($name)
    {
        if($name != 'content' and isset($this->models[$name]) ){
            foreach ($this->models as $section => $model){
                if($section != $name){
                    unset($this->models[$section]);
                }
            }
        }
    }
}
