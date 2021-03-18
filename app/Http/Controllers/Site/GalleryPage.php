<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageUpdateRequest;

use App\Models\Gallery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryPage extends BasePage
{
    public function __construct(GalleryController $gallery, CategoryController $category)
    {
        $this->units = [
            'gallery' => $gallery,
            'category' => $category,
        ];
    }

    public function index(Request $request)
    {
        foreach ($this->units as $name => $controller){
            $config = config('site_settings.gallery.' . $name);

            if($name == 'gallery' and $request->query()) {
                $this->collections[$name] = $controller->collection($config)
                                                            ->withFilter(request()->query())
                                                                ->get();
            }else{
                $this->collections[$name] = $controller->collection($config)->get();
            }
        }
        return $this->renderOutput('gallery.gallery');
    }



    public function show(Request $request)
    {
        $this->collections['gallery'] = $this->units['gallery']->collection()
                                                                    ->byId($request->get('id'))
                                                                        ->get();
        return $this->renderOutput('gallery.show');
    }


    public function create()
    {
        try {
            $this->authorize('create', Gallery::class);
        } catch (AuthorizationException $e) {
            return notice()->warning("Only verified users can add content")->html();
        }

        $this->collections['category'] = $this->units['category']->collection()->builder()
                                                                                ->select('name', 'id')
                                                                                ->orderBy('name')
                                                                                ->get();

        return $this->renderOutput('gallery.create');

    }

    /**
     *
     * @param ImageAddRequest $request
     * @return mixed
     */
    public function store(ImageAddRequest $request)
    {
        try {
            $this->authorize('create', Gallery::class);
        } catch (AuthorizationException $e) {
            return notice()->warning("Only verified users can add content")->html();
        }

        $url = str_replace('public/', '', $request->image->store('public/images'));

        $post = new Gallery;
        $post->image = asset("storage/". $url);
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = Auth::id();

        if (Storage::disk('public')->missing($url)) {
            return notice()->danger("Something went wrong. Image not loaded")->json();
        }

        $post->save();

        $post->categories()->attach($request->categories);

        return notice()->success("Image added")->json();
    }


    /**
     *
     * @param Request $request
     * @return array|mixed|string
     */
    public function edit(Request $request)
    {
        try {
            $this->authorize('update', Gallery::find($request->get('id')));
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        $this->setBuilderById($this->models['gallery'], $request->get('id'));
        $this->addCollection('post');

        $this->setBuilder($this->models['category'])->orderBy('name');
        $this->addCollection('categories');

        return $this->renderOutput('gallery.edit');
    }

    /**
     * @param ImageUpdateRequest $request
     */
    public function update(ImageUpdateRequest $request)
    {
        $post = Gallery::find($request->get('id'));
        try {
            $this->authorize('update',  $post);
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->json();
        }

        $post->title = $request->title;
        $post->text = $request->text;
        $post->categories()->attach($request->categories);

        $post->save();

        return notice()->success("Post updated")->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        try {
            $this->authorize('delete', Gallery::find($request->get('id')));
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        Gallery::destroy($request->get('id'));

        if(!is_null(Gallery::find($request->get('id')))){
            return notice()->warning("Something went wrong")->html();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function restore(Request $request)
    {
        $post = Gallery::withTrashed()->find($request->get('id'));
        try {
            $this->authorize('restore', $post);
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        $post->restore();

        if(is_null(Gallery::find($request->get('id')))){
            return notice()->warning("Something went wrong")->html();
        }
    }
}
