<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortfolioController;


class HomePage extends BasePage
{
    public function __construct(BannerController $banner, NewsController $news, BlogController $blog,
                                PortfolioController $portfolio, GalleryController $gallery)
    {
        $this->units = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
            'banner' => $banner,
            'portfolio' => $portfolio,
        ];
    }

    public function index()
    {
        foreach ($this->units as $name => $controller){
            $this->collections[$name] = $controller->collection(config('site_settings.home.' . $name))->get();
        }
        return $this->renderOutput('home.home');
    }
}
