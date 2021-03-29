<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentAddRequest;
use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentAddRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentAddRequest $request)
    {
        try {
            $this->authorize('create', Comment::class);
        } catch (AuthorizationException $e) {
            return notice()->warning("Only verified users can add comments")->json();
        }

        $comment = new Comment;
        $comment->text = $request->text;
        $comment->user_id = Auth::id();

        $comment->save();

        $comment->gallery()->attach($request->id);

        return notice()->success("Comment added")->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function refresh(CommentController $comment, Request $request)
    {
        $this->collections['comments'] = $comment->collection()
                                                    ->builder()
                                                    ->whereHas($request->get("type"), function (Builder $query) use ($request) {
                                                        $query->where('id', '=', $request->get('id'));
                                                    })
                                                    ->get();
        return $this->renderOutput($request->get("type") . ".comments");
    }
}
