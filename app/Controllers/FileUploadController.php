<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;

class FileUploadController extends BaseController
{
    // public $fileModel;
    // public $session;
    public $db;
    public $model;
    public $session;
    public $data;

    public function __construct()
    {
        // $this->fileModel = new FileModel();
        // $this->session = \Config\Services::session();
        $this->db = db_connect();
        $this->model = new FileModel();
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->data['session'] = $this->session;
        $this->data['request'] = $this->request;
        $this->data['uploads'] = $this->model->findAll();
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
        $recipient = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject');
        $label = $this->request->getPost('label');
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
                "recipient" => $this->db->escapeString($recipient),
                "subject" => $this->db->escapeString($subject),
                "label" => $this->db->escapeString($label),
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

    public function doc_view($id = null){
        $model = new FileModel();
        $data['model'] = $model->find($id);
        return view('dashboard/doc_view', $data);
    }
}
