<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return view('welcome_message');
        return view('dashboard/dashboard');
    }

    public function compose(){
        return view('dashboard/compose');
    }

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
