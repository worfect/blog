<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FilterController;
use App\Http\Requests\StoreImageRequest;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryPage extends BasePage
{
    public function __construct(Request $request, Photo $gallery)
    {
        parent::__construct($request);

        $this->models = [
            'gallery' => $gallery,
        ];
    }

    public function index()
    {
        $this->template = 'gallery.index';

        foreach ($this->models as $name => $model){
            $config = config('site_settings.gallery.' . $name);

            $this->setBuilder($model, $config);

            if($name == 'gallery' and $this->params) {
                $this->builder = (new FilterController($this->builder, $this->params))->getBuilder();
            }

            $this->setCollection($config);
            if($this->collection == false or $this->collection->isEmpty()){
                $this->addNotFoundMessage();
            }else{
                $this->parentFolder = 'gallery';
                $this->addTemplateInData($this->collection, $model->name);
            }
        }
        return $this->renderOutput();
    }

    public function show()
    {
        $id = $this->params['id'];
        $this->collection = $this->getById($this->models['gallery'], $id);

        $this->parentFolder = 'gallery';
        $this->template = 'gallery.show';

        return $this->getTemplate($this->collection, 'show');
    }

    public function create()
    {
        $this->collection = (new Category())->get('name');

        $this->parentFolder = 'gallery';
        $this->template = 'gallery.create';
        return $this->getTemplate($this->collection, 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreImageRequest $request

     */
    public function store(StoreImageRequest $request)
    {
        flash('Added')->success()->overlay();

        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);
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
