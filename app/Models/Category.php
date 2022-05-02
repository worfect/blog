<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $relations = ['blog', 'news', 'gallery'];
    public $name = 'category';

    public function blog()
    {
        return $this->morphedByMany('App\Models\Blog', 'categoryable');
    }
    public function gallery()
    {
        return $this->morphedByMany('App\Models\Gallery', 'categoryable');
    }
    public function news()
    {
        return $this->morphedByMany('App\Models\News', 'categoryable');
    }
}
