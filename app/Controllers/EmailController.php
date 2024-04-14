<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EmailController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function compose()
    {
        return view('dashboard/compose');
    }

    public function sendEmail(){
        $inputs = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please enter your email address.',
                    'valid_email' => 'Please enter a valid email address.'
                ]
            ],
            'subject' => [
                'label' => 'Subject',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Please enter a subject.',
                    'valid_email' => 'Please enter a subject with at least 5 characters.'
                ]
            ],
            'message' => [
                'label' => 'Message',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Please enter a message.',
                    'valid_email' => 'Please enter a message with at least 10 characters.'
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|max_size[file,100000]|is_image[file]',
                'errors' => [
                    'uploaded' => 'Please select a file.',
                    'max_size' => 'The file size should be less or equal to 1 mb.',
                    'is_image' => 'Only image type is allowed.',
                ]
            ]
        ]);

        if(!$inputs){
            return view('dashboard/compose', [
                'validation' => $this->validator
            ]);
        } else{
            $email = $this->request->getPost('email');
            $subject = $this->request->getPost('subject');
            $message = $this->request->getPost('message');
            $file = $this->request->getFile('file');

            $fileName = $file->getName();
            $file->move('uploads', $fileName);
            $filePath = 'uploads/' . $fileName;

            $mail = \Config\Services::email();
            $mail->setFrom('yukinon@gmail.com');
            $mail->setTo($email);
            $mail->setSubject($subject);
            $mail->setMessage($message);
            $mail->attach($filePath, 'attachment', $fileName);
            if($mail->send()){
                session()->setFlashdata('success', 'Your message has been sent successfully.');
                return redirect()->to('compose');
            } else{
                session()->setFlashdata('error', 'Sorry, your message could not be sent.');
                return redirect()->to('compose');
            }
        }
    }
}
