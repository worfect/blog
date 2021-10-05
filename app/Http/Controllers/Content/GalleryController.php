<?php


namespace App\Http\Controllers\Content;

use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Models\Gallery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends ContentController
{
    public function __construct(Gallery $gallery)
    {
        $this->model = $gallery;
    }

    public function index(GalleryController $gallery, CategoryController $category, Request $request)
    {
        $units = [
            'gallery' => $gallery,
            'category' => $category,
        ];

        foreach ($units as $name => $controller){
            $config = config('site_settings.gallery.' . $name);

            if($name == 'gallery' and $request->query()) {
                $this->collections[$name] = $controller->collection($config)
                                                        ->withFilter($request->query())
                                                        ->get();
            }else{
                $this->collections[$name] = $controller->collection($config)->get();
            }
        }
        return $this->renderOutput('gallery.gallery');
    }



    public function show(CommentController $comment, Request $request)
    {
        $this->increaseViewsCount($request->get('id'));

        $this->collections['gallery'] = $this->collection()
                                                ->byId($request->get('id'))
                                                ->get();
        $this->collections['comments'] = $comment->collection()
                                                        ->builder()
                                                        ->whereHasMorph('commentable', [Gallery::class], function (Builder $query) use ($request) {
                                                            $query->where('id', $request->get('id'));
                                                        })
                                                        ->get();

        return $this->renderOutput('gallery.show');
    }


    public function create(CategoryController $category)
    {
        try {
            $this->authorize('create', Gallery::class);
        } catch (AuthorizationException $e) {
            return notice()->warning("Only verified users can add content")->html();
        }

        $this->collections['categories'] = $category->collection()->builder()
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

        $post = $this->model;
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
     * @param GalleryController $gallery
     * @param CategoryController $category
     * @param Request $request
     * @return array|mixed|string
     */
    public function edit(GalleryController $gallery, CategoryController $category, Request $request)
    {
        try {
            $this->authorize('update', $this->model::find($request->get('id')));
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        $this->collections['post'] = $gallery->collection()
                                                ->byId( $request->get('id'))
                                                ->get();
        $this->collections['categories'] = $category->collection()
                                                    ->builder()
                                                    ->orderBy('name')
                                                    ->get();

        return $this->renderOutput('gallery.edit');
    }

    /**
     * @param ImageUpdateRequest $request
     * @return mixed
     */
    public function update(ImageUpdateRequest $request)
    {
        $post = $this->model::find($request->get('id'));

        try {
            $this->authorize('update',  $post);
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->json();
        }

        $post->title = $request->title;
        $post->text = $request->text;

        $post->categories()->detach();
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
            $this->authorize('delete', $this->model::find($request->get('id')));
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        $this->model::find($request->get('id'))->delete();

        if(!is_null($this->model::find($request->get('id')))){
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
        $post = $this->model::withTrashed()->find($request->get('id'));
        try {
            $this->authorize('restore', $post);
        } catch (AuthorizationException $e) {
            return notice()->warning("You do not have enough rights to perform this operation")->html();
        }

        $post->restore();

        if(is_null($this->model::find($request->get('id')))){
            return notice()->warning("Something went wrong")->html();
        }
    }

    public function refresh(GalleryController $gallery)
    {
        $config = config('site_settings.gallery.gallery');
        $this->collections['gallery'] = $gallery->collection($config)
                                                    ->builder()
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate($config['amount'])
                                                    ->appends(request()->query());
        return $this->renderOutput('gallery.content');
    }
}
