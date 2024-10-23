<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegisterModel;

class RegisterController extends BaseController
{
    public $registerModel;
    public $session;
    public $email;
    public function __construct()
    {
        helper("form");
        helper("date");
        $this->registerModel = new RegisterModel();
        $this->session = \Config\Services::session();
        $this->email =  \Config\Services::email();
    }
    public function index()
    {
        $data = [];
        $data['validation'] = null;
        $rules = [
            'name' => 'required|min_length[4]|max_length[20]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'role' => 'required',
            'brgy' => 'required',
            'password' => 'required|min_length[6]|max_length[16]',
            'confirmpassword' => 'required|matches[password]'
        ];

        if ($this->request->getMethod() === 'post') {
            if ($this->validate($rules)) {
                $uniid = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));
                $userdata = [
                    'name' => $this->request->getVar('name'),
                    'email' => $this->request->getVar('email'),
                    'role' => $this->request->getVar('role'),
                    'brgy' => $this->request->getVar('brgy'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'uniid' => $uniid,
                    'activation_date' => date("Y-m-d h:i:s")
                ];
                if ($this->registerModel->createUser($userdata)) {

                    $to = $this->request->getVar('email');
                    $subject = 'Account Activation Link - E-Governance Portal';
                    $message = 'Hi ' .  $this->request->getVar('name') . "<br><br>Thanks. Your account was created successfully. Please click the link below to activate your account<br><br>" . "<a href = '" . base_url() . "activate/" . $uniid . "' target = '_blank'>Activate Now</a><br><br>Thanks<br>Team";

                    $this->email = \Config\Services::email();
                    $this->email->setTo($to);
                    $this->email->setFrom('yukinon@gmail.com', 'Info');
                    $this->email->setSubject($subject);
                    $this->email->setMessage($message);

                    if ($this->email->send()) {
                        $this->session->setTempdata('success', 'Account Created Successfully. Please activate your account.', 10);
                        return redirect()->to(current_url());
                    } else {
                        $this->session->setTempdata('error', 'Account Created Successfully. Sorry! Unable to send activation link', 10);
                        // return redirect()->to(current_url());
                        return redirect()->to('/register');
                    }
                } else {
                    $this->session->setTempdata('error', 'Sorry! Unable to create an account. Try Again', 3);
                    // return redirect()->to(current_url());
                    return redirect()->to('/register');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('auth/register', $data);
    }

    public function activate($uniid = null)
{
    $data = [];
    if (!empty($uniid)) {
        $userdata = $this->registerModel->verifyUniid($uniid);
        if ($userdata) {
            // Remove this condition to skip expiry check
            // if ($this->verifyExpiryTime($userdata->activation_date)) {
                if ($userdata->status == 'inactive') {
                    $status = $this->registerModel->updateStatus($uniid);
                    if ($status == true) {
                        $data['success'] = 'Account Activated Successfully';
                    }
                } else {
                    $data['success'] = 'Your account is already activated';
                }
            // } else {
            //     $data['error'] = 'Sorry! Activation link was expired';
            // }
        } else {
            $data['error'] = 'Sorry! We are unable to find your account';
        }
    } else {
        $data['error'] = 'Sorry! Unable to process your request.';
    }
    return view("auth/activate_view", $data);
}

    public function verifyExpiryTime($regTime)
    {
        $currTime = strtotime(now()); // Current time as Unix timestamp
        $regTime = strtotime($regTime); // Convert the registration time to Unix timestamp
        $diffTime = $currTime - $regTime;

        // Set expiration period to 1 hour (3600 seconds)
        if ($diffTime < 7200) {
            return true; // Still valid
        } else {
            return false; // Expired
        }
    }
}
