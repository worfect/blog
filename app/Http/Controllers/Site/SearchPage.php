<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FilterController;
use App\Http\Controllers\SearchController;

use App\Models\News;
use App\Models\Blog;
use App\Models\Photo;

use Illuminate\Http\Request;

class SearchPage extends BasePage
{
    protected $models = [];

    public function __construct(Request $request, News $news, Blog $blog, Photo $gallery)
    {
        parent::__construct($request);

        $this->template = 'search.index';

        $this->models = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
        ];
    }

    public function index()
    {
        $this->template = 'search.index';

        if($this->params){
            $resultExist = true;
            $this->selectModel($this->params['section']);
            foreach ($this->models as $name => $model){
                $config = config('site_settings.search.' . $name);

                $this->setBuilder($model, $config);

                $this->builder = (new FilterController($this->builder, $this->params))->getBuilder();
                $this->builder = (new SearchController($this->builder, $this->params))->getBuilder();

                $this->setCollection($config);
                if($this->collection == false or $this->collection->isEmpty()){
                    $resultExist = false;
                }else{
                    $this->parentFolder = 'search';
                    $this->addTemplateInData($this->collection, $model->name);
                }
            }
            if ($resultExist == false){
                notice()->warning('Nothing found')->session();
            }
        }

        return $this->renderOutput();
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
