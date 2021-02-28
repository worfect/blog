<?php


namespace App\Models\Layouts;


use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $relations = [];
    public $name = 'banner';
    protected $table = 'banner_home';
}
