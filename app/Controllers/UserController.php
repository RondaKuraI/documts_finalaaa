<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function show($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        // return view('partials/user_sidebar', ['user' => $user]);

        // Debugging: check if user data is retrieved
        if ($user) {
            echo '<pre>';
            print_r($user);
            echo '</pre>';
        } else {
            echo 'User not found';
        }
    }
}
