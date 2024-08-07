<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserDBController extends BaseController
{
    public function dashboard()
    {
        return view('dashboard/dashboard');
    }

    public function compose()
    {
        $userModel = new UserModel();
        // Fetch all users to be used as both senders and recipients
        $users = $userModel->findAll();
        return view('user_dashboard/compose', ['users' => $users]);
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
