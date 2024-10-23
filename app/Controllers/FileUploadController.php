<?php

namespace App\Controllers;

defined('FCPATH') || define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\RecipientModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

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

    public function checkDocCodeUniqueness()
    {
        $doc_code = $this->request->getPost('doc_code');
        
        if (is_array($doc_code)) {
            $doc_code = implode('', $doc_code);
        }

        if (empty($doc_code)) {
            return $this->response->setJSON(['isUnique' => false, 'message' => 'Document code is required']);
        }

        // Check if the document code already exists in the database
        $existingDoc = $this->model->where('doc_code', $doc_code)->first();

        if ($existingDoc) {
            return $this->response->setJSON(['isUnique' => false, 'message' => 'This document code already exists']);
        } else {
            return $this->response->setJSON(['isUnique' => true]);
        }
    }

    public function upload()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'doc_code' => [
                'rules' => 'required|is_unique[filess.doc_code]',
                'errors' => [
                    'required' => 'Document code is required',
                    'is_unique' => 'This document code already exists'
                ]
            ],
            'sender' => 'required',
            'recipient' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'prioritization' => 'required|in_list[Usual,Urgent]',
            'action' => 'required',
            'date_of_letter' => 'required|valid_date',
            'deadline' => 'required|valid_date',
            'file' => 'uploaded[file]|max_size[file,30000]|ext_in[file,pdf,doc,docx]'
        ]);

        // if (!$validation->withRequest($this->request)->run()) {
        //     $errors = $validation->getErrors();
        //     $errorMessages = implode(', ', $errors); // Convert array to string
        //     return redirect()->back()->withInput()->with('main_error', $errorMessages);
        // }

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $errorMessages = implode(', ', $errors); // Convert array to string
            $this->session->setFlashdata('main_error', $errorMessages); // Store in session
            return redirect()->back()->withInput();
        }
        

        // if (!is_dir('./uploads/')) mkdir('./uploads/');
        // Ensure the uploads directory exists and is writable
        $uploadsDir = FCPATH . 'uploads';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }

        if (!is_writable($uploadsDir)) {
            return redirect()->back()->withInput()->with('main_error', 'Uploads directory is not writable');
        }

        $doc_code = $this->request->getPost('doc_code');
        if (is_array($doc_code)) {
            $doc_code = implode('', $doc_code);
        }
        $sender = $this->request->getPost('sender');
        $recipient = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject');
        $description = $this->request->getPost('description');
        $prioritization = $this->request->getPost('prioritization');
        $action = $this->request->getPost('action');
        $date_of_letter = $this->request->getPost('date_of_letter');
        $deadline = $this->request->getPost('deadline');
        $file = $this->request->getFile('file');
        $fname = $file->getRandomName();

        /// Generate the QR code image
        try {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($doc_code)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::Low) // Use correct class
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin) // Use correct class
                ->build();

            $qrCodeFilename = 'qr_code_' . $doc_code . '.png';
            $qrCodePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $qrCodeFilename;
            $result->saveToFile($qrCodePath);
        } catch (\Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('main_error', 'QR Code generation failed: ' . $e->getMessage());
        }


        while ($this->model->where("path", "uploads/{$fname}")->countAllResults() > 0) {
            $fname = $file->getRandomName();
        }

        $userName = $this->session->get('name');
        $sender = $userName; // Use the logged-in user's name as the sender

        if ($file->move("uploads/", $fname)) {
            $this->model->save([
                "doc_code" => $doc_code,
                "sender" => $sender,
                "recipient" => $recipient,
                "subject" => $subject,
                "description" => $description,
                "prioritization" => $prioritization,
                "action" => $action,
                "date_of_letter" => $date_of_letter,
                "deadline" => $deadline,
                "path" => "uploads/" . $fname,
                "qr_code" => $qrCodeFilename
            ]);

            $this->session->setFlashdata('main_success', "New File Uploaded successfully.");
            return redirect()->to('/compose');
        } else {
            $this->session->setFlashdata('main_error', "File Upload failed.");
            return redirect()->back()->withInput();
        }
    }

    public function compose()
    {
        $userModel = new UserModel();
        // Fetch all users to be used as both senders and recipients
        $users = $userModel->findAll();
        // return view('dashboard/compose', ['users' => $users]);

        $isLoggedIn = $this->session->get('isLoggedIn') ?? false;

        // Pass both users and isLoggedIn to the view
        return view('dashboard/compose', [
            'users' => $users,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function doc_view($id)
    {
        $document = $this->model->find($id);
        $isLoggedIn = $this->session->get('isLoggedIn') ?? false;

        if (!$document) {
            // If the document is not found, you can either return a 404 error or redirect to a default page
            return redirect()->to('/dashboard/outgoing')->with('error', 'Document not found');
        }

        return view('dashboard/doc_view', [
            'document' => $document,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function incoming_doc_view($id)
    {
        $document = $this->model->find($id);
        $isLoggedIn = $this->session->get('isLoggedIn') ?? false;

        if (!$document) {
            // If the document is not found, you can either return a 404 error or redirect to a default page
            return redirect()->to('/dashboard/incoming')->with('error', 'Document not found');
        }

        return view('dashboard/incoming_doc_view', [
            'document' => $document,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $userRole = $this->session->get('role');
        $userName = $this->session->get('name');

        if ($keyword) {
            if ($userRole == 'admin') {
                $this->data['uploads'] = $this->model->like('subject', $keyword)
                    ->orLike('description', $keyword)
                    ->orLike('sender', $keyword)
                    ->orLike('recipient', $keyword)
                    ->findAll();
            } else {
                $this->data['uploads'] = $this->model->where('sender', $userName)
                    ->groupStart()
                    ->like('subject', $keyword)
                    ->orLike('description', $keyword)
                    ->orLike('recipient', $keyword)
                    ->groupEnd()
                    ->findAll();
            }
        } else {
            // If no keyword, return all documents (respecting user role)
            if ($userRole == 'admin') {
                $this->data['uploads'] = $this->model->findAll();
            } else {
                $this->data['uploads'] = $this->model->where('sender', $userName)->findAll();
            }
        }

        return view('dashboard/outgoing', $this->data);
    }

    public function incoming()
    {
        $userName = $this->session->get('name');
        $userRole = $this->session->get('role');

        if ($userRole == 'admin') {
            $baseQuery = $this->model;
        } else {
            $baseQuery = $this->model->where('recipient', $userName);
        }

        //Counting bullshit
        $this->data['all_incoming_count'] = $baseQuery->countAllResults();
        $baseQuery = $baseQuery->builder();
        $this->data['pending_count'] = $baseQuery->where('status', 'pending')->countAllResults();


        if ($userRole == 'admin') {
            // Admin sees all documents
            $this->data['incoming'] = $this->model->findAll();
        } else {
            // Normal users only see documents where they are the recipient
            $this->data['incoming'] = $this->model->where('recipient', $userName)->findAll();
        }


        return view('dashboard/incoming', $this->data);
    }

    public function dashboard()
    {
        $userName = $this->session->get('name');
        $userRole = $this->session->get('role');

        if ($userRole == 'admin') {
            $baseQuery = $this->model;
        } else {
            $baseQuery = $this->model->where('recipient', $userName);
        }

        //Counting bullshit
        $this->data['all_incoming_count'] = $baseQuery->countAllResults();
        $baseQuery = $baseQuery->builder();
        $this->data['pending_count'] = $baseQuery->where('status', 'pending')->countAllResults();


        if ($userRole == 'admin') {
            // Admin sees all documents
            // $this->data['incoming'] = $this->model->findAll();
            $this->data['incoming'] = $this->model->findAll(5); //most recent
        } else {
            // Normal users only see documents where they are the recipient
            // $this->data['incoming'] = $this->model->where('recipient', $userName)->findAll();
            $this->data['incoming'] = $this->model->where('recipient', $userName)->findAll(5);
        }
        return view('dashboard/dashboard', $this->data);
    }

    public function generateQR()
    {
        $doc_code = $this->request->getPost('doc_code');

        // Handle case where doc_code is an array
        if (is_array($doc_code)) {
            $doc_code = implode('', $doc_code);
        }

        if (empty($doc_code)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Document code is required']);
        }

        try {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($doc_code)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::Low)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->build();

            $qrCodeFilename = 'qr_code_' . $doc_code . '.png';
            $qrCodePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $qrCodeFilename;
            $result->saveToFile($qrCodePath);

            $qrCodeUrl = base_url('uploads/' . $qrCodeFilename);

            return $this->response->setJSON([
                'success' => true,
                'qr_code_url' => $qrCodeUrl
            ]);
        } catch (\Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'QR Code generation failed: ' . $e->getMessage()
            ]);
        }
    }
}
