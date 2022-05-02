<?php


namespace App\Models\Layouts;


use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
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
