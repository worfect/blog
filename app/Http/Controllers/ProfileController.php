<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends ContentController
{

    public function index($id, BannerController $banner, BlogController $blog,
                          CommentController $comment, GalleryController $gallery)
    {
        $units = [
            'blog' => $blog,
            'gallery' => $gallery,
            'comment' => $comment,
            'banner' => $banner
        ];

        foreach ($units as $name => $controller){
            $config = config('site_settings.profile.' . $name);

            if($name == 'banner'){
                $this->collections[$name] = $controller->collection($config)->get();
            }else{
                $this->collections[$name] = $controller->collection($config)
                                                        ->builder()
                                                        ->where('user_id', $id)
                                                        ->get();
            }
        }
        return $this->renderOutput('profile.profile');
    }
}
