<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifMessageController extends Controller
{
    public function index()
    {
        return view('message');
    }

    public function message()
    {
        return redirect('/message')->with(['success' => 'Data is changed.']);
    }
}
