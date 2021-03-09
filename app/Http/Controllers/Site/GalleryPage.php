<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FilterController;
use App\Http\Requests\StoreImageRequest;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryPage extends BasePage
{
    public function __construct(Request $request, Gallery $gallery)
    {
        parent::__construct($request);

        $this->models = [
            'gallery' => $gallery
        ];
    }

    public function index()
    {
        foreach ($this->models as $name => $model){
            $config = config('site_settings.gallery.' . $name);

            $this->setBuilder($model, $config);
            if($name == 'gallery' and $this->params) {
                $this->builder = (new FilterController($this->builder, $this->params))->getBuilder();
            }

            $this->addCollection($name, $config);
        }
        return $this->renderOutput('gallery.gallery');
    }

    public function show()
    {
        $this->setBuilder($this->models['gallery'], $this->params['id']);
        $this->addCollection('gallery');
        return $this->renderOutput('gallery.show');
    }

    public function create()
    {
        if(Auth::user()){
            $this->collection = (new Category())
                ->select('name', 'id')
                ->orderBy('name')
                ->get();

            $this->parentFolder = 'gallery';
            $this->template = 'gallery.create';
            return $this->getTemplate($this->collection, 'create');
        }
        return notice()->warning("Log in to add an image")->html();
    }

    /**
     *
     *
     * @param StoreImageRequest $request
     * @return mixed
     */
    public function store(StoreImageRequest $request)
    {
        $url = str_replace('public/', '', $request->image->store('public/images'));

        $post = new Gallery;
        $post->image = asset("storage/". $url);
        $post->title = $request->title;
        $post->text = $request->text;
        $post->user_id = Auth::id();

        $post->categories()->attach($request->get('categories'));

        if (Storage::disk('public')->missing($url)) {
            return notice()->danger("Something went wrong. Image not loaded")->json();
        }

        $post->save();

        return notice()->success("Image added")->json();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->template = 'gallery.edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
