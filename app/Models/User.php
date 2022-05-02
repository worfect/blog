<?php

namespace App\Models;

use App\Contracts\HasEmail;
use App\Contracts\HasPhone;
use App\Contracts\HasVerifySource;
use App\Events\UserDeleting;
use App\Events\UserRestored;
use App\Traits\Email;
use App\Traits\Status;
use App\Traits\Phone;
use App\Traits\VerifySource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements HasVerifySource, HasEmail, HasPhone
{
    use HasFactory, Notifiable, SoftDeletes, VerifySource, Email, Phone, Status;

    protected $dispatchesEvents = [
        'restoring' => UserRestored::class,
        'deleting' => UserDeleting::class,
    ];

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';

    protected $hidden = ['password'];

    public function registerUser(array $data)
    {
        $user = new User;

        $user->login = ($data['login']);
        $user->screen_name = $user->login;
        $user->email = isset($data['email']) ? $data['email'] : null;
        $user->phone = isset($data['phone']) ? $data['phone'] : null;
        $user->password = bcrypt($data['password']);
        $user->role = self::ROLE_USER;

        $user->save();

        $user->setWait();

        return $user;
    }

    public function socialRegisterUser(array $data)
    {
        $user = new User;
        $id = User::orderBy('id', 'desc')->first()->id;
        $user->login = 'id_' . ++$id;
        $user->screen_name = $user->login;
        $user->email = $data['email'] ?? null;
        $user->phone = $data['phone'] ?? null;
        $user->password = bcrypt(Str::random(32));
        $user->role = self::ROLE_USER;
        $user->email_confirmed = isset($data['email']) ? 1 : 0;
        $user->phone_confirmed = isset($data['phone']) ? 1 : 0;

        $user->save();

        $user->setActive();

        return $user;
    }

    public function isAdministrator(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return  $this->role == self::ROLE_MODERATOR;
    }

    public function blog()
    {
        return $this->hasMany("App\Models\Blog");
    }
    public function gallery()
    {
        return $this->hasMany("App\Models\Gallery");
    }
    public function news()
    {
        return $this->hasMany("App\Models\News");
    }
    public function comments()
    {
        return $this->hasMany("App\Models\Comment");
    }

    public function attitude()
    {
        return $this->hasMany('App\Models\Attitude');
    }

    public function statuses()
    {
        return $this->belongsToMany(\App\Models\Status::class)->withPivot('expires');
    }
}
