<?php

namespace App\Http\Controllers;

use App\Models\Attitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RatingController extends Controller
{
    protected $newAttitude;
    protected $targetPost;
    protected $postId;

    public function __construct(Request $request)
    {
        $this->checkPost($request->get('type'),$request->get('id'));
        $this->newAttitude = $request->get('attitude');
        $this->postId = $request->get('id');
    }

    protected function checkPost($type, $id)
    {
        $canAttitude = ['Gallery', 'Comment', 'Blog', 'News'];

        $modelName = 'App\\Models\\' . ucfirst($type);

        if(in_array(ucfirst($type), $canAttitude) and class_exists($modelName)){
           $this->targetPost = (new $modelName())->find($id);
        }
    }

    public function index()
    {
        if($this->targetPost){
            $this->addAttitude();
            $this->updatePostRating();

            return $this->response();
        }
    }


    protected function getOldAttitude()
    {
        return (new Attitude())->select('*')
                                        ->where('user_id', Auth::id())
                                        ->where('attitudeable_type', get_class($this->targetPost))
                                        ->where('attitudeable_id', $this->postId)
                                        ->get()
                                        ->first();
    }

    protected function addAttitude()
    {
        $oldAttitude = $this->getOldAttitude();

        if($oldAttitude){
            if($this->newAttitude == -1 or $this->newAttitude == 1){
                if($oldAttitude->attitude != $this->newAttitude){
                    (new Attitude())->where('id', $oldAttitude->id)->delete();
                }
            }
        }else{
            $attitude = new Attitude();
            $attitude->user_id = Auth::id();
            $attitude->attitudeable_id = $this->postId;
            $attitude->attitudeable_type = get_class($this->targetPost);
            if($this->newAttitude == -1){
                $attitude->attitude = -1;
            }elseif($this->newAttitude == 1){
                $attitude->attitude = 1;
            }

            $attitude->save();
        }
    }

    protected function updatePostRating()
    {
        $this->targetPost->rating = $this->rating();
        $this->targetPost->save();
    }

    protected function response()
    {
        return response()->json([
            "attitude" =>  $this->attitude(),
            "rating" => $this->targetPost->rating
        ]);
    }

    protected function rating()
    {
       return  (new Attitude())->where('attitudeable_id', $this->postId)
                                ->where('attitudeable_type', get_class($this->targetPost))
                                ->sum('attitude');
    }

    protected function attitude()
    {
        $attitude = (new Attitude())->select('attitude')
                                ->where('user_id', Auth::id())
                                ->where('attitudeable_id', $this->postId)
                                ->where('attitudeable_type', get_class($this->targetPost))
                                ->get()
                                ->first();
        return $attitude['attitude'];
    }

}
