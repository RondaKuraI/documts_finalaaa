<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;


class SigninController extends Controller
{
    public function index()
    {
        helper(['form']);
        echo view('auth/login');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verify password
            $authenticatePassword = password_verify($password, $user['password']);

            if ($authenticatePassword) {
                // Set session data
                $ses_data = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'], // Assuming you have a 'role' column in your database
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);

                // Redirect based on role
                if ($user['role'] == 'admin') {
                    return redirect()->to('/dashboard');
                } else {
                    // return redirect()->to('/user_dashboard');
                    return redirect()->to('/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/login');
        }
    }

    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('msg', 'You have successfully logged out.');
    }
}
