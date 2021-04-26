<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('layouts.app');
    }
}
