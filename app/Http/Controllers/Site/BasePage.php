<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


abstract class BasePage extends Controller
{
    protected $units = [];
    protected $collections = [];

    protected function renderOutput($template){
       return view($template, $this->collections)->render();
    }

    public function refreshContent(Request $request)
    {

    }
}
