<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\RecipientModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

class FileUploadController extends BaseController
{
    // public $fileModel;
    // public $session;
    public $db;
    public $model;
    public $recipientModel;
    public $userModel;
    public $notificationModel;
    public $session;
    public $data;

    public function __construct()
    {
        // $this->fileModel = new FileModel();
        // $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->model = new FileModel();
        $this->recipientModel = new RecipientModel();
        $this->userModel = new UserModel();
        $this->notificationModel = new NotificationModel();
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->data['session'] = $this->session;
        $this->data['request'] = $this->request;
        $this->data['uploads'] = $this->model->findAll();
        $this->data['recipients'] = $this->recipientModel->findAll();
    }

    public function index()
    {
        // $data['uploads'] = $this->fileModel->findAll();
        // return view('dashboard/outgoing', $data);
        // return view('dashboard/outgoing', $this->data);
        $userName = $this->session->get('name');
        $userRole = $this->session->get('role');

        if ($userRole == 'admin') {
            // Admin sees all documents
            $this->data['uploads'] = $this->model->findAll();
        } else {
            // Normal users only see their own documents
            $this->data['uploads'] = $this->model->where('sender', $userName)->findAll();
        }
        return view('dashboard/outgoing', $this->data);
    }



  
    public function upload()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'doc_code' => 'required|integer',
            'sender' => 'required',
            'recipient' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'date_of_letter' => 'required|valid_date',
            'deadline' => 'required|valid_date',
            'file' => 'uploaded[file]|max_size[file,30000]|ext_in[file,pdf,doc,docx]'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $errorMessages = implode(', ', $errors); // Convert array to string
            return redirect()->back()->withInput()->with('main_error', $errorMessages);
        }
    
        if (!is_dir('./uploads/')) mkdir('./uploads/');
    
        $doc_code = $this->request->getPost('doc_code');
        $sender = $this->request->getPost('sender');
        $recipient = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject');
        $description = $this->request->getPost('description');
        $date_of_letter = $this->request->getPost('date_of_letter');
        $deadline = $this->request->getPost('deadline');
        $file = $this->request->getFile('file');
        $fname = $file->getRandomName();
    
        while ($this->model->where("path", "uploads/{$fname}")->countAllResults() > 0) {
            $fname = $file->getRandomName();
        }

        $userName = $this->session->get('name');
        $sender = $userName; // Use the logged-in user's ID as the sender
    
        if ($file->move("uploads/", $fname)) {
            $this->model->save([
                "doc_code" => $doc_code,
                "sender" => $sender,
                "recipient" => $recipient,
                "subject" => $subject,
                "description" => $description,
                "date_of_letter" => $date_of_letter,
                "deadline" => $deadline,
                "path" => "uploads/" . $fname
            ]);

            // // After saving the file in your upload method
            // $notificationModel = new NotificationModel();
            // $notificationModel->save([
            //     "recipient" => $recipient,  // The recipient's ID
            //     "subject" => $subject,  // Notification message or subject
            //     "doc_code" => $doc_code,  // The document code associated with the file
            //     "status" => 'pending'  // Set status to 'pending' by default
            // ]);
    
            $this->session->setFlashdata('main_success', "New File Uploaded successfully.");
            return redirect()->to('/compose');
        } else {
            $this->session->setFlashdata('main_error', "File Upload failed.");
            return redirect()->back()->withInput();
        }
    }

      // public function upload()
    // {
    //     if (!is_dir('./uploads/'))
    //         mkdir('./uploads/');
    //     $doc_code = $this->request->getPost('doc_code');
    //     $sender = $this->request->getPost('sender');
    //     $recipient = $this->request->getPost('recipient');
    //     $subject = $this->request->getPost('subject');
    //     $description = $this->request->getPost('description');
    //     $date_of_letter = $this->request->getPost('date_of_letter');
    //     $deadline = $this->request->getPost('deadline');
    //     $file = $this->request->getFile('file');
    //     $fname = $file->getRandomName();
    //     while (true) {
    //         $check = $this->model->where("path", "uploads/{$fname}")->countAllResults();
    //         if ($check > 0) {
    //             $fname = $file->getRandomName();
    //         } else {
    //             break;
    //         }
    //     }
    //     if ($file->move("uploads/", $fname)) {
    //         $this->model->save([
    //             "doc_code" => $this->db->escapeString($doc_code),
    //             "sender" => $this->db->escapeString($sender),
    //             "recipient" => $this->db->escapeString($recipient),
    //             "subject" => $this->db->escapeString($subject),
    //             "description" => $this->db->escapeString($description),
    //             "date_of_letter" => $this->db->escapeString($date_of_letter),
    //             "deadline" => $this->db->escapeString($deadline),
    //             "path" => "uploads/" . $fname
    //         ]);
    //         $this->session->setFlashdata('main_success', "New File Uploaded successfully.");
    //         return redirect()->to('/compose');
    //         // return redirect('compose')->with('status', 'New File Uploaded successfully.');
    //     } else {
    //         $this->session->setFlashdata('main_error', "File Upload failed.");
    //     }
    //     return view('/compose', $this->data);
    // }

    
    public function doc_view($id)
    {
        $data['file'] = $this->model->find($id);
        return view('dashboard/doc_view', $data);
    }
    

















    // public function doc_view($id = null){
    //     $model = new FileModel();
    //     $data['model'] = $model->find($id);
    //     return view('dashboard/doc_view', $data);
    // }

    // public function doc_view($id){
    //     $file = new FileModel();
    //     $data['file'] = $file->find($id);
        
    //     return view('dashboard/doc_view', $data);

    // }
}
