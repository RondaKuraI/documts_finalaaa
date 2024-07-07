<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FetchFileModel;

class FetchFileController extends BaseController
{
    // public function index()
    // {
    //     // Load the model
    //     $userModel = new FetchFileModel();
    //     $id = 1;
    //     $userData = $userModel->find($id);

    //     // Pass the user's name to the view
    //     $data['user_name'] = $userData['name'];

    //     // Load the view with the user data
    //     return view('partials/user_sidebar', $data);
    // }

    public function index()
    {
        $fetchFileModel = new FetchFileModel();
        $data['files'] = $fetchFileModel->findAll();
        print_r($data['files']);

        return view('user_dashboard/incoming', $data);
    }
}
