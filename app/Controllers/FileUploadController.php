<?php

namespace App\Controllers;

defined('FCPATH') || define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\RecipientModel;
use App\Models\UserModel;
use App\Models\NotificationModel;
use App\Models\ReplyModel;
use App\Models\DocumentVersionModel;
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
    public $replyModel;
    public $versionModel;
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
        $this->replyModel = new ReplyModel();
        $this->versionModel = new DocumentVersionModel;
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->data['session'] = $this->session;
        $this->data['request'] = $this->request;
        $this->data['uploads'] = $this->model->findAll();
        $this->data['recipients'] = $this->recipientModel->findAll();
    }

    public function index()
    {
        $userName = $this->session->get('name');

        // $this->data['uploads'] = $this->model->where('sender', $userName)->findAll();
        $builder = $this->db->table('filess');
        $builder->select('filess.*, users.brgy');
        $builder->join('users', 'filess.recipient = users.name', 'left');
        $builder->where('filess.sender', $userName);
        $this->data['uploads'] = $builder->get()->getResult('array');

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

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $errorMessages = implode(', ', $errors); // Convert array to string
            $this->session->setFlashdata('main_error', $errorMessages); // Store in session
            return redirect()->back()->withInput();
        }

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
        // $fname = $file->getRandomName();

        // Get original filename and sanitize it
        $originalName = $file->getClientName();
        $fileExt = $file->getClientExtension();
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);

        // Sanitize the filename
        $safeName = url_title($baseName, '-', true); // Converts spaces to dashes and lowercase

        // Add timestamp to ensure uniqueness while keeping original name
        $finalName = $safeName . '_' . time() . '.' . $fileExt;

        // Check if file with this name already exists and append number if needed
        $counter = 1;
        while (file_exists($uploadsDir . DIRECTORY_SEPARATOR . $finalName)) {
            $finalName = $safeName . '_' . time() . '_' . $counter . '.' . $fileExt;
            $counter++;
        }

        // Generate QR code
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
            $qrCodePath = $uploadsDir . DIRECTORY_SEPARATOR . $qrCodeFilename;
            $result->saveToFile($qrCodePath);
        } catch (\Exception $e) {
            log_message('error', 'QR Code generation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('main_error', 'QR Code generation failed: ' . $e->getMessage());
        }

        $userName = $this->session->get('name');
        $sender = $userName; // Use the logged-in user's name as the sender

        if (!is_dir($uploadsDir)) {
            if (!mkdir($uploadsDir, 0755, true)) {
                log_message('error', 'Failed to create uploads directory: ' . $uploadsDir);
                return redirect()->back()->with('main_error', 'Failed to create uploads directory');
            }
        }

        if (!is_writable($uploadsDir)) {
            log_message('error', 'Uploads directory is not writable: ' . $uploadsDir);
            return redirect()->back()->with('main_error', 'Uploads directory is not writable');
        }


        if ($file->move($uploadsDir, $finalName)) {
            $this->model->insert([
                "doc_code" => $doc_code,
                "sender" => $sender,
                "recipient" => $recipient,
                "subject" => $subject,
                "description" => $description,
                "prioritization" => $prioritization,
                "action" => $action,
                "date_of_letter" => $date_of_letter,
                "deadline" => $deadline,
                "path" => "uploads/" . $finalName,
                "original_name" => $originalName, // Optional: Store original name in database
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
        $replies = $this->getReplies($id);
        $isLoggedIn = $this->session->get('isLoggedIn') ?? false;

        if (!$document) {
            // If the document is not found, you can either return a 404 error or redirect to a default page
            return redirect()->to('/dashboard/incoming')->with('error', 'Document not found');
        }

        return view('dashboard/incoming_doc_view', [
            'document' => $document,
            'replies' => $replies,
            'isLoggedIn' => $isLoggedIn
        ]);
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $type = $this->request->getGet('type') ?? 'outgoing'; // Default to outgoing if not specified
        $userRole = $this->session->get('role');
        $userName = $this->session->get('name');

        // Set view and data key based on type
        $viewPath = 'dashboard/' . $type;
        $dataKey = ($type === 'incoming') ? 'incoming' : 'uploads';

        if ($keyword) {
            if ($userRole == 'admin') {
                $this->data[$dataKey] = $this->model
                    ->groupStart()
                    ->like('subject', $keyword)
                    ->orLike('description', $keyword)
                    ->orLike('sender', $keyword)
                    ->orLike('recipient', $keyword)
                    ->orLike('doc_code', $keyword)
                    ->groupEnd()
                    ->findAll();
            } else {
                // For non-admin users, filter based on sender/recipient
                $query = $this->model
                    ->groupStart()
                    ->like('subject', $keyword)
                    ->orLike('description', $keyword)
                    ->orLike('sender', $keyword)
                    ->orLike('recipient', $keyword)
                    ->orLike('doc_code', $keyword)
                    ->groupEnd();

                // Add user-specific condition based on type
                if ($type === 'incoming') {
                    $query->where('recipient', $userName);
                } else {
                    $query->where('sender', $userName);
                }

                $this->data[$dataKey] = $query->findAll();
            }
        } else {
            // If no keyword, return all documents (respecting user role)
            if ($userRole == 'admin') {
                $this->data[$dataKey] = $this->model->findAll();
            } else {
                if ($type === 'incoming') {
                    $this->data[$dataKey] = $this->model->where('recipient', $userName)->findAll();
                } else {
                    $this->data[$dataKey] = $this->model->where('sender', $userName)->findAll();
                }
            }
        }

        // Pass additional data needed by the views
        $this->data['session'] = $this->session;

        return view($viewPath, $this->data);
    }

    public function incoming()
{
    $userName = $this->session->get('name');

    // Start with a builder instance
    $builder = $this->model->builder();
    
    // Select needed fields and join with users table
    $builder->select('filess.*, users.name as sender, users.brgy as brgy')
            ->join('users', 'users.name = filess.sender', 'left')
            ->where('filess.recipient', $userName)
            ->orderBy('filess.date_of_letter', 'DESC');

    // Get the results
    $this->data['incoming'] = $builder->get()->getResultArray();

    return view('dashboard/incoming', $this->data);
}

    public function ougoing()
    {
        $userName = $this->session->get('name');

        // Query documents where the recipient is the logged-in user
        $baseQuery = $this->model->where('sender', $userName);

        // Retrieve incoming documents for the logged-in user
        $this->data['outgoing'] = $baseQuery->findAll();

        return view('dashboard/outgoing', $this->data);
    }

    public function dashboard()
    {
        $userName = $this->session->get('name');
        $userRole = $this->session->get('role');

        // if ($userRole == 'admin') {
        //     $baseQuery = $this->model;
        // } else {
        $baseQuery = $this->model->where('recipient', $userName);
        // }

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

    public function viewFile($id)
    {
        $document = $this->model->find($id);

        if (!$document) {
            return redirect()->back()->with('error', 'Document not found');
        }

        $filePath = FCPATH . $document['path'];
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found');
        }

        // Handle DOC and DOCX files
        if (in_array($fileExtension, ['doc', 'docx'])) {
            // Instead of using Office Online Viewer directly, use Google Docs Viewer as a fallback
            $fileUrl = base_url($document['path']);
            $encodedUrl = urlencode($fileUrl);

            return view('dashboard/file_viewer', [
                'document' => $document,
                'fileUrl' => $fileUrl,
                'fileName' => $document['original_name'],
                'fileType' => $fileExtension,
                'isLoggedIn' => session()->get('isLoggedIn') ?? false
            ]);
        }

        // Handle PDF files directly
        if ($fileExtension === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $document['original_name'] . '"');
            header('Cache-Control: no-cache, must-revalidate');
            readfile($filePath);
            exit;
        }

        // Handle unsupported file types
        return redirect()->back()->with('error', 'Unsupported file type');
    }

    // Add a new method to serve the file content
    public function serveFile($id)
    {
        $document = $this->model->find($id);

        if (!$document) {
            return $this->response->setStatusCode(404, 'File not found');
        }

        $filePath = FCPATH . $document['path'];

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404, 'File not found');
        }

        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Set appropriate content type
        switch ($fileExtension) {
            case 'doc':
                $contentType = 'application/msword';
                break;
            case 'docx':
                $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            default:
                $contentType = 'application/octet-stream';
        }

        // Set headers for file download
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: inline; filename="' . $document['original_name'] . '"');
        header('Cache-Control: public, max-age=3600');
        header('Content-Length: ' . filesize($filePath));

        // Output file content
        readfile($filePath);
        exit;
    }

    // Add a method to get replies for a document
    public function getReplies($documentId)
    {
        $replyModel = new \App\Models\ReplyModel();
        return $replyModel->where('document_id', $documentId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function showConversations($id)
    {
        // Check if document exists
        $document = $this->model->find($id);
        if (!$document) {
            return redirect()->back()->with('error', 'Document not found');
        }

        // Check if user has access to this document
        $currentUser = $this->session->get('name');
        if ($document['sender'] !== $currentUser && $document['recipient'] !== $currentUser) {
            return redirect()->back()->with('error', 'Access denied');
        }

        // Get all replies for this document
        $conversations = $this->replyModel->where('document_id', $id)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        return view('dashboard/conversation_view', [
            'document' => $document,
            'conversations' => $conversations,
            'isLoggedIn' => $this->session->get('isLoggedIn')
        ]);
    }

    public function reply($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        // Validate document exists
        $document = $this->model->find($id);
        if (!$document) {
            return redirect()->back()->with('error', 'Document not found');
        }

        // Validate message
        $message = $this->request->getPost('message');
        if (empty($message)) {
            return redirect()->back()->with('error', 'Message is required');
        }

        // Handle file upload if exists
        $file = $this->request->getFile('attachment');
        $attachment = null;
        $originalName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            try {
                $file->move(FCPATH . 'uploads', $newName);
                $attachment = 'uploads/' . $newName;
                $originalName = $file->getClientName();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to upload attachment: ' . $e->getMessage());
            }
        }

        // Prepare reply data
        $replyData = [
            'document_id' => $id,
            'sender' => $this->session->get('name'),
            'recipient' => ($document['sender'] === $this->session->get('name')) ? $document['recipient'] : $document['sender'],
            'message' => $message,
            'attachment' => $attachment,
            'original_name' => $originalName
        ];

        // Save reply
        try {
            if ($this->replyModel->insert($replyData)) {
                return redirect()->back()->with('success', 'Reply sent successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to send reply');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Method to list archived documents
    public function archived()
    {
        $this->data['archived'] = $this->model->where('archived', 1)->findAll();
        return view('dashboard/archived', $this->data);
    }

    // // Archive a document
    // public function archive($id)
    // {
    //     $document = $this->model->find($id);

    //     if ($document) {
    //         $this->model->update($id, ['archived' => 1]);
    //         $this->session->setFlashdata('main_success', 'Document archived successfully.');
    //     } else {
    //         $this->session->setFlashdata('main_error', 'Document not found.');
    //     }

    //     return redirect()->to('/barangay_documents/(:segment)');
    // }

    // Unarchive a document
    public function unarchive($id)
    {
        $document = $this->model->find($id);

        if ($document) {
            $this->model->update($id, ['archived' => 0]);
            $this->session->setFlashdata('main_success', 'Document unarchived successfully.');
        } else {
            $this->session->setFlashdata('main_error', 'Document not found.');
        }

        return redirect()->to('/documents/archived');
    }

    // Add a new method for updating documents with versioning
    public function updateDocument($id)
    {
        // Check if document exists
        $document = $this->model->find($id);
        if (!$document) {
            $this->session->setFlashdata('main_error', 'Document not found.');
            return redirect()->back();
        }

        // Validate user has permission to update this document
        $userName = $this->session->get('name');
        if ($document['sender'] !== $userName && $this->session->get('role') !== 'admin') {
            $this->session->setFlashdata('main_error', 'You do not have permission to update this document.');
            return redirect()->back();
        }

        // Validate form data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'subject' => 'required',
            'description' => 'required',
            'prioritization' => 'required|in_list[Usual,Urgent]',
            'action' => 'required',
            'deadline' => 'required|valid_date',
            'version_notes' => 'required|min_length[5]', // New field for version notes
            'file' => 'uploaded[file]|max_size[file,30000]|ext_in[file,pdf,doc,docx]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $errorMessages = implode(', ', $errors);
            $this->session->setFlashdata('main_error', $errorMessages);
            return redirect()->back()->withInput();
        }

        // Handle file upload
        $file = $this->request->getFile('file');
        $uploadsDir = FCPATH . 'uploads';

        // Original filename and sanitization (similar to upload method)
        $originalName = $file->getClientName();
        $fileExt = $file->getClientExtension();
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeName = url_title($baseName, '-', true);
        $finalName = $safeName . '_v' . time() . '.' . $fileExt;

        // Ensure directory exists and is writable
        if (!is_dir($uploadsDir) || !is_writable($uploadsDir)) {
            if (!mkdir($uploadsDir, 0755, true)) {
                return redirect()->back()->with('main_error', 'Uploads directory issue');
            }
        }

        // Move the uploaded file
        if (!$file->move($uploadsDir, $finalName)) {
            $this->session->setFlashdata('main_error', "File Upload failed.");
            return redirect()->back()->withInput();
        }

        // Get current version number and increment
        $currentVersion = $this->versionModel->getLatestVersionNumber($id);
        $newVersionNumber = $currentVersion + 1;

        // Save the current document as a version record
        $versionData = [
            'original_document_id' => $id,
            'version_number' => $newVersionNumber,
            'path' => "uploads/" . $finalName,
            'original_name' => $originalName,
            'created_by' => $userName,
            'notes' => $this->request->getPost('version_notes')
        ];

        $this->versionModel->insert($versionData);

        // Update the main document record
        $updateData = [
            'subject' => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'prioritization' => $this->request->getPost('prioritization'),
            'action' => $this->request->getPost('action'),
            'deadline' => $this->request->getPost('deadline'),
            'path' => "uploads/" . $finalName,
            'original_name' => $originalName,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->model->update($id, $updateData);

        // Add notification for the recipient about the update
        $notificationData = [
            'user_id' => $this->userModel->where('name', $document['recipient'])->first()['id'] ?? null,
            'message' => "Document {$document['doc_code']} has been updated with a new version.",
            'link' => "/document/view/{$id}",
            'is_read' => 0
        ];

        if ($notificationData['user_id']) {
            $this->notificationModel->insert($notificationData);
        }

        $this->session->setFlashdata('main_success', "Document updated successfully with new version {$newVersionNumber}.");
        return redirect()->to('/outgoing'); // Adjust redirect as needed
    }

    public function showUpdateForm($id)
{
    // Check if document exists
    $document = $this->model->find($id);
    if (!$document) {
        $this->session->setFlashdata('main_error', 'Document not found.');
        return redirect()->back();
    }

    // Validate user has permission to update this document
    $userName = $this->session->get('name');
    if ($document['sender'] !== $userName && $this->session->get('role') !== 'admin') {
        $this->session->setFlashdata('main_error', 'You do not have permission to update this document.');
        return redirect()->back();
    }

    // Get version history info
    $versionCount = $this->versionModel->where('original_document_id', $id)->countAllResults();
    $latestVersion = $this->versionModel->getLatestVersionNumber($id);

    // Prepare data for the view
    $this->data['document'] = $document;
    $this->data['versionCount'] = $versionCount;
    $this->data['latestVersion'] = $latestVersion;

    return view('dashboard/update_document_form', $this->data);
}

    // Method to view document versions
    public function viewVersions($id)
    {
        // Check if document exists
        $document = $this->model->find($id);
        if (!$document) {
            $this->session->setFlashdata('main_error', 'Document not found.');
            return redirect()->back();
        }

        // Get all versions for this document
        $versions = $this->versionModel->getDocumentVersions($id);

        // Prepare data for view
        $this->data['document'] = $document;
        $this->data['versions'] = $versions;

        return view('dashboard/document_versions', $this->data);
    }

    // Method to view a specific version
    public function viewVersion($versionId)
    {
        // Get version details
        $version = $this->versionModel->find($versionId);
        
        if (!$version) {
            $this->session->setFlashdata('main_error', 'Version not found.');
            return redirect()->back();
        }

        // Get original document
        $document = $this->model->find($version['original_document_id']);
        
        // Prepare data for view
        $this->data['document'] = $document;
        $this->data['version'] = $version;
        
        return view('dashboard/view_version', $this->data);
    }

    // Method to restore to a previous version
    public function restoreVersion($versionId)
    {
        // Get version details
        $version = $this->versionModel->find($versionId);
        
        if (!$version) {
            $this->session->setFlashdata('main_error', 'Version not found.');
            return redirect()->back();
        }

        $documentId = $version['original_document_id'];
        $document = $this->model->find($documentId);

        // Validate user has permission
        $userName = $this->session->get('name');
        if ($document['sender'] !== $userName && $this->session->get('role') !== 'admin') {
            $this->session->setFlashdata('main_error', 'You do not have permission to restore this version.');
            return redirect()->back();
        }

        // First create a new version with the current document state
        $currentVersion = $this->versionModel->getLatestVersionNumber($documentId);
        $newVersionNumber = $currentVersion + 1;

        // Save current state as a version
        $this->versionModel->insert([
            'original_document_id' => $documentId,
            'version_number' => $newVersionNumber,
            'path' => $document['path'],
            'original_name' => $document['original_name'],
            'created_by' => $userName,
            'notes' => "Auto-saved before restoring to version " . $version['version_number']
        ]);

        // Then update the main document with the data from the version being restored
        $this->model->update($documentId, [
            'path' => $version['path'],
            'original_name' => $version['original_name'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // Add notification
        $notificationData = [
            'user_id' => $this->userModel->where('name', $document['recipient'])->first()['id'] ?? null,
            'message' => "Document {$document['doc_code']} has been restored to version {$version['version_number']}.",
            'link' => "/document/view/{$documentId}",
            'is_read' => 0
        ];

        if ($notificationData['user_id']) {
            $this->notificationModel->insert($notificationData);
        }

        $this->session->setFlashdata('main_success', "Document restored to version {$version['version_number']} successfully.");
        return redirect()->to("/document/versions/{$documentId}");
    }
}
