<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectTo(){
        redirect()->back();
    }
}
