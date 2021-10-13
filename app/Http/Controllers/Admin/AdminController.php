<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showUsers()
    {
        return view('profile.admin.users.users', ['users' =>  User::withTrashed()->get()]);
    }

    public function showComments()
    {
        $comments = Comment::withTrashed()->with(
            ['user' => function ($q) {
                $q->withTrashed();
            }, 'commentable' => function ($q) {
                $q->withTrashed();
            }])->get();

        return view('profile.admin.comments', ['comments' => $comments]);
    }

    public function showEditUserForm($id)
    {
        return view('profile.admin.users.edit', ['user' =>  User::withTrashed()->where('id', $id)->get()]);
    }

    public function deleteUser($id)
    {
        if(Auth::id() != $id){
            User::destroy($id);
        }else{
            notice("You can't delete yourself", 'warning');
            return redirect()->back();
        }

        if(!is_null(User::find($id))){
            notice("Something went wrong", 'warning');
            return redirect()->back();
        }

        notice("User deleted", 'success');
        return redirect()->back();
    }

    public function restoreUser($id)
    {
        User::withTrashed()->find($id)->restore();

        if(!is_null(User::find($id))){
            notice("User restored", 'success');
            return redirect()->back();
        }
        notice("Something went wrong", 'warning');
        return redirect()->back();
    }

    public function blockUser($id)
    {
        if(Auth::id() != $id){
            User::findOrFail($id)->setBanned();
        }else{
            notice("You can't block yourself", 'warning');
            return redirect()->back();
        }

        notice("User blocked", 'success');
        return redirect()->back();
    }

    public function unblockUser($id)
    {
        User::findOrFail($id)->removeBanned();

        notice("User unblocked", 'success');
        return redirect()->back();
    }

    public function activateUser($id)
    {
        User::findOrFail($id)->setActive();

        notice("User activated", 'success');
        return redirect()->back();
    }
    public function deactivateUser($id)
    {
        User::findOrFail($id)->setWait();

        notice("User deactivated", 'success');
        return redirect()->back();
    }
}
