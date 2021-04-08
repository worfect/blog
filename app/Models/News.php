<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $relations = ['user', 'comments', 'categories', 'attitude'];
    public $name = 'news';

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
