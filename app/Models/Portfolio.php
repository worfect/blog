<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Portfolio extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $relations = [];
    public $name = 'portfolio';
}
