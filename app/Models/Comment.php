<?php

namespace App\Models;

use App\Events\ContentDeleted;
use App\Events\ContentRestored;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    public $relations = ['commentable', 'user', 'attitude'];
    public $name = 'comment';

    protected $dispatchesEvents = [
        'deleted' => ContentDeleted::class,
        'restored' => ContentRestored::class,
    ];

    public function commentable()
    {
        return $this->morphTo();
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
