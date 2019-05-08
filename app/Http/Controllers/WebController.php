<?php

namespace App\Http\Controllers;


class WebController extends Controller
{
    public function register()
    {
        $invite_id = request('invite_id',0);
        return view('web.register',compact('invite_id'));
    }
}
