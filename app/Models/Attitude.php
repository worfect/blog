<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attitude extends Model
{
    use SoftDeletes;

    public $name = 'attitude';
    public $timestamps = false;


    public function attitudeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
