<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserDataUpdateRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function index($id)
    {
        return view('profile.profile', ['user' =>  User::with('blog', 'gallery', 'comment')
                                                                ->get()
                                                                ->where('id', $id)]);
    }

    public function edit($id)
    {
        return view('profile.edit', ['user' =>  User::get()->where('id', $id)]);
    }


    public function update($id, UserDataUpdateRequest $request)
    {
        $user = User::findOrFail($id);
        if($email = $request->get('email')){
            $user->updateEmail($email);
        }
        if($phone = $request->get('phone')){
            $user->updatePhone($phone);
        }

        return notice()->success("User data update")->json();
    }

    public function refresh($id)
    {
        return view('profile.editForm', ['user' =>  User::get()->where('id', $id)]);
    }
}
