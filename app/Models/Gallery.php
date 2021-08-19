<?php


namespace App\Models;


use App\Events\ContentDeleted;
use App\Events\ContentRestored;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{

    Use SoftDeletes;

    public $relations = ['user', 'comments', 'categories', 'attitude'];
    public $name = 'gallery';

    protected $dispatchesEvents = [
        'deleted' => ContentDeleted::class,
        'restored' => ContentRestored::class,
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
