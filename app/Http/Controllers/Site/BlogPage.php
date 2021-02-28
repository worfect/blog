<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FilterController;
use App\Models\News;
use App\Models\Blog;
use App\Models\Photo;
use Illuminate\Http\Request;

class BlogPage extends BasePage
{

    public function __construct(Request $request, News $news, Blog $blog, Photo $gallery)
    {
        parent::__construct($request);

        $this->models = [
            'blog' => $blog,
            'news' => $news,
            'gallery' => $gallery,
        ];
    }

    public function index()
    {
        $this->template = 'blog.index';

        foreach ($this->models as $name => $model){
            $config = config('site_settings.blog.' . $name);

            $this->setBuilder($model, $config);

            if($name == 'blog' and $this->params) {
                $this->builder = (new FilterController($this->builder, $this->params))->getBuilder();
            }

            $this->setCollection($config);
            if($this->collection == false or $this->collection->isEmpty()){
                $this->addNotFoundMessage();
            }else{
                $this->parentFolder = 'blog';
                $this->addTemplateInData($this->collection, $model->name);
            }
        }

        return $this->renderOutput();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->template = 'blog.edit';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->template = 'blog.show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->template = 'blog.edit';
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
