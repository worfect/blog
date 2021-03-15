<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Layouts\Banner;
use Illuminate\Http\Request;

class HomePage extends BasePage
{
    public function __construct(Request $request, Banner $banner, News $news, Blog $blog,
                                Portfolio $portfolio, Gallery $gallery)
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
        foreach ($this->models as $name => $model){
            $this->config = config('site_settings.home.' . $name);
            $this->setBuilder($model);

            $this->addCollection($name);
        }
        return $this->renderOutput('home.home');
    }
}
