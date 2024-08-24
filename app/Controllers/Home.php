<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        // return view('welcome_message');
        return view('dashboard/dashboard');
    }

    // public function compose(){
    //     $userModel = new UserModel();
    //     // Fetch all users to be used as both senders and recipients
    //     $users = $userModel->findAll();
    //     return view('dashboard/compose', ['users' => $users]);
    // }

    public function incoming(){
        return view('dashboard/incoming');
    }

    public function outgoing(){
        return view('dashboard/outgoing');
    }
    
    public function maintenance(){
        return view('dashboard/maintenance');
    }

    public function reports(){
        return view('dashboard/reports');
    }

    public function user_management(){
        return view('dashboard/user_management');
    }
}
