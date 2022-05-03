<?php

declare(strict_types=1);

namespace App\Models\Layouts;

use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Banner extends Model
{
    use HasFactory;

    public $relations = [];
    public $name = 'banner';
    protected $table = 'banner_home';

    protected static function newFactory()
    {
        return BannerFactory::new();
    }
}
