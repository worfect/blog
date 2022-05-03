<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Status extends Model
{
    public $timestamps = false;

    public const WAIT = 1;
    public const ACTIVE = 2;
    public const BANNED = 3;
    public const DELETED = 4;


    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
