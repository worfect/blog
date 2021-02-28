<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $relations = ['user', 'comments', 'categories'];
    public $name = 'blog';


    public function comments()
    {
        return $this->morphToMany('App\Models\Comment', 'commentable');
    }

    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categoryable');
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
