<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;


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

    }

    public function blockUser($id)
    {

    }

    public function unblockUser($id)
    {

    }
    public function activateUser($id)
    {


    }
    public function deactivateUser($id)
    {


    }
}
