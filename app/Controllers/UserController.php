<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function dashboard()
    {
        return view('user_dashboard/dashboard');
    }

    public function compose()
    {
        return view('user_dashboard/compose');
    }

    public function incoming()
    {
        return view('user_dashboard/incoming');
    }

    public function outgoing()
    {
        return view('user_dashboard/outgoing');
    }
}
