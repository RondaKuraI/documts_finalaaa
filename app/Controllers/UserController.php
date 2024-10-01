<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public $userModel;

    public function user_management()
    {
        $this->userModel = new UserModel();
        $data['users'] = $this->userModel->findAll();
        $data['isLoggedIn'] = session()->get('isLoggedIn'); // Get login status from session
        return view('dashboard/user_management', $data);
    }
}
