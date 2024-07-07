<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\RecipientModel;

class FileUploadController extends BaseController
{
    // public $fileModel;
    // public $session;
    public $db;
    public $model;
    public $recipientModel;
    public $session;
    public $data;

    public function __construct()
    {
        // $this->fileModel = new FileModel();
        // $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->model = new FileModel();
        $this->recipientModel = new RecipientModel();
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
        return view('dashboard/outgoing', $this->data);
    }



    public function upload()
    {
        if (!is_dir('./uploads/'))
            mkdir('./uploads/');
        $doc_code = $this->request->getPost('doc_code');
        $sender = $this->request->getPost('sender');
        $recipient = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject');
        $description = $this->request->getPost('description');
        $date_of_letter = $this->request->getPost('date_of_letter');
        $deadline = $this->request->getPost('deadline');
        $file = $this->request->getFile('file');
        $fname = $file->getRandomName();
        while (true) {
            $check = $this->model->where("path", "uploads/{$fname}")->countAllResults();
            if ($check > 0) {
                $fname = $file->getRandomName();
            } else {
                break;
            }
        }
        if ($file->move("uploads/", $fname)) {
            $this->model->save([
                "doc_code" => $this->db->escapeString($doc_code),
                "sender" => $this->db->escapeString($sender),
                "recipient" => $this->db->escapeString($recipient),
                "subject" => $this->db->escapeString($subject),
                "description" => $this->db->escapeString($description),
                "date_of_letter" => $this->db->escapeString($date_of_letter),
                "deadline" => $this->db->escapeString($deadline),
                "path" => "uploads/" . $fname
            ]);
            $this->session->setFlashdata('main_success', "New File Uploaded successfully.");
            return redirect()->to('/compose');
            // return redirect('compose')->with('status', 'New File Uploaded successfully.');
        } else {
            $this->session->setFlashdata('main_error', "File Upload failed.");
        }
        return view('/compose', $this->data);
    }

    // public function doc_view($id = null){
    //     $model = new FileModel();
    //     $data['model'] = $model->find($id);
    //     return view('dashboard/doc_view', $data);
    // }

    public function doc_view($id){
        $file = new FileModel();
        $data['file'] = $file->find($id);
        
        return view('dashboard/doc_view', $data);

    }
}
