<?php


namespace App\Http\Controllers;

use App\Events\RequestVerification;
use App\Http\Requests\UserDataUpdateRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;

class ProfileController extends Controller
{
    public function index($id)
    {
        return view('profile.profile', ['user' =>  User::with('blog', 'gallery', 'comment', 'attitude')
                                                            ->where('id', $id)
                                                            ->get()]);
    }

    public function edit($id)
    {
        try {
            $this->authorize('update', [User::class, $id]);
        } catch (AuthorizationException $e) {
            abort(403);
        }

        return view('profile.edit', ['user' =>  User::get()->where('id', $id)]);
    }

    public function update($id, UserDataUpdateRequest $request)
    {
        try {
            $this->authorize('update', [User::class, $id]);
        } catch (AuthorizationException $e) {
            abort(403);
        }

        $user = User::findOrFail($id);
        if($email = $request->get('email')){
            $user->updateEmail($email);
        }
        if($phone = $request->get('phone')){
            $user->updatePhone($phone);
        }
        if($name = $request->get('screen_name')){
            $user->screen_name = $name;
            $user->save();
        }

        if(!$user->emailConfirmed() and !$user->phoneConfirmed()){
            $user->unverified();
        }

        notice("User data update", 'success');
        return redirect()->back();
    }

    public function verifyRequest($id, $source)
    {
        $user = User::findOrFail($id);

        if($source == 'email' and $user->hasEmail() and !$user->emailConfirmed()){
            event(new RequestVerification($user, 'email'));
            return redirect(RouteServiceProvider::VERIFY)->withCookie('id', $user->id, 10);
        }elseif($source == 'phone' and $user->hasPhone() and !$user->phoneConfirmed()){
            event(new RequestVerification($user, 'phone'));
            return redirect(RouteServiceProvider::VERIFY)->withCookie('id', $user->id, 10);
        }else{
            notice('Something went wrong', 'danger');
            return redirect()->back();
        }
    }

    public function multiFactorRequest($id, $action)
    {
        $user = User::findOrFail($id);

        if($action == 'enable'){
            $user->enableMultiFactor();
            notice('Multi-factor auth ON', 'success');
        }elseif ($action == 'disable'){
            $user->disableMultiFactor();
            notice('Multi-factor auth OFF', 'warning');
        }
        return redirect()->route('profile.edit', ['id' => $id]);
    }

    public function refresh($id)
    {
        return view('profile.editForm', ['user' =>  User::get()->where('id', $id)]);
    }
}
