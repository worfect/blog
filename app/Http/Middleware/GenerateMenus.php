<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class GenerateMenus
{
    public function handle(Request $request, Closure $next): mixed
    {
        \Menu::make('NavBar', function ($menu) {
            $menu->add('Home', ['route'  => 'home']);
            $menu->add('News');
            $menu->add('Blog', ['route'  => 'blog.index']);
            $menu->add('Gallery', ['route'  => 'gallery.index']);
            $menu->add('Portfolios');
            $menu->add('Categories');
            $menu->add('Users');

            $menu->news->add('Breaking news');
            $menu->news->add('Popular news');

            $menu->blog->add('Best posts');
            $menu->blog->add('New posts');
            $menu->blog->add('Create posts');

            $menu->gallery->add('Best photos', 'gallery?section=content&method=best&criterion=rating&date=all');
            $menu->gallery->add('New photos', 'gallery?section=content&method=new');
            $menu->gallery->add('Add photo', ['class' => 'create-gallery-item']);
        });

        return $next($request);
    }
}
