<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{

    public function addSocialAccount($socialData, $user)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $socialData['provider'],
            'provider_id' => $socialData['provider_id'],
            'token' => $socialData['token'],
        ]);
    }


    protected $fillable = [
        'user_id', 'provider', 'provider_id', 'token'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
