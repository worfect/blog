<?php


namespace App\Models;


use App\Listeners\ContentDeletedListener;
use App\Listeners\ContentRestoredListener;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    public $relations = ['user', 'comments', 'categories', 'attitude'];
    public $name = 'news';

    protected $dispatchesEvents = [
        'deleted' => ContentDeletedListener::class,
        'restored' => ContentRestoredListener::class,
    ];

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categoryable');
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function attitude()
    {
        return $this->morphMany('App\Models\Attitude', 'attitudeable');
    }
}
