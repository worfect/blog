<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attitude extends Model
{
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
