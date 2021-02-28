<?php

namespace App\Http\Controllers\Site;

use App\Models\User;

class ProfilePage extends BasePage
{

    public function index($id)
    {
        $user = User::where('id', $id)->first();


        return view('profile.home', compact("user"));
    }

}
