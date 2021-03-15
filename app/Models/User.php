<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerifyMail;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;


    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';




    protected $fillable = [
        'login', 'password', 'email', 'screen_name', 'verify_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function registerUser(array $data)
    {
        $user = new User;

        $user->login = ($data['login']);
        $user->screen_name = $user->login;
        $user->email = isset($data['email']) ? $data['email'] : null;
        $user->phone = isset($data['phone']) ? $data['phone'] : null;
        $user->password = bcrypt($data['password']);
        $user->verify_token = Str::random(32);
        $user->status = self::STATUS_WAIT;
        $user->role = self::ROLE_USER;

        $user->save();

        return $user;
    }

    public function socialRegisterUser(array $data)
    {
        $user = new User;
        $id = User::orderBy('id', 'desc')->first()->id;

        $user->login = 'id_' . ++$id;
        $user->screen_name = $user->login;
        $user->email = isset($data['email']) ? $data['email'] : null;
        $user->phone = isset($data['phone']) ? $data['phone'] : null;
        $user->password = bcrypt(Str::random(32));
        $user->status = self::STATUS_ACTIVE;
        $user->role = self::ROLE_USER;

        $user->save();

        return $user;
    }




    public function hasVerifiedEmail()
    {
        return $this->verified_at;
    }

    public function markEmailAsVerified()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->verify_token = null;
        return $this->save();
    }

    public function sendEmailVerificationNotification()
    {
        Mail::to($this->getEmailForVerification())->send(new VerifyMail($this->login, $this->verify_token));
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }


    public function isAdministrator(): bool
    {
        return $this->role == self::ROLE_ADMIN
                or $this->role == self::ROLE_MODERATOR;
    }

    public function isVerified(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
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
}
