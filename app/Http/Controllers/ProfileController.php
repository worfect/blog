<?php


namespace App\Http\Controllers;


class ProfileController extends PageController
{
    public function index()
    {
        return $this->renderOutput('profile.home');
    }
}
