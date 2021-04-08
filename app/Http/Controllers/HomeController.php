<?php

namespace App\Http\Controllers;


class HomeController extends ContentController
{
    public function index(BannerController $banner, NewsController $news, BlogController $blog,
                                PortfolioController $portfolio, GalleryController $gallery)
    {
        $units = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
            'banner' => $banner,
            'portfolio' => $portfolio,
        ];

        foreach ($units as $name => $controller){
            $this->collections[$name] = $controller->collection(config('site_settings.home.' . $name))->get();
        }
        return $this->renderOutput('home.home');
    }
}
