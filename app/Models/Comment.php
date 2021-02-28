<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $relations = ['blog', 'gallery', 'news', 'user'];
    public $name = 'comment';

    public function blog()
    {
        return $this->morphedByMany('App\Models\Blog', 'commentable');
    }
    public function gallery()
    {
        return $this->morphedByMany('App\Models\Gallery', 'commentable');
    }
    public function news()
    {
        return $this->morphedByMany('App\Models\News', 'commentable');
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
