<?php

namespace App\Http\Controllers\Site;


use App\Models\News;
use App\Models\Blog;
use App\Models\Photo;
use App\Models\Portfolio;
use App\Models\Layouts\Banner;
use Illuminate\Http\Request;

class HomePage extends BasePage
{
    public function __construct(Request $request, Banner $banner, News $news, Blog $blog,
                                Portfolio $portfolio, Photo $gallery)
    {
        parent::__construct($request);

        $this->models = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
            'banner' => $banner,
            'portfolio' => $portfolio,
        ];
    }

    public function index()
    {
        $this->template = 'home.home';
        notice('hi');
        foreach ($this->models as $name => $model){
            $config = config('site_settings.home.' . $name);

            $this->setBuilder($model, $config);

            $this->setCollection($config);
            if($this->collection == false or $this->collection->isEmpty()){
                $this->addNotFoundMessage();
            }else{
                $this->parentFolder = 'home';
                $this->addTemplateInData($this->collection, $model->name);
            }
        }
        return $this->renderOutput();
    }
}
