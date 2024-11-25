<?php

namespace App\Controllers;

defined('FCPATH') || define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

use App\Controllers\BaseController;
use App\Models\FileModel;

class AllDocumentsController extends BaseController
{
    public $db;
    public $model;
    public $session;
    public $data;

    public function __construct()
    {
        $this->db = db_connect();
        $this->model = new FileModel();
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->data['session'] = $this->session;
        $this->data['request'] = $this->request;
    }

    public function allDocuments()
    {
        // Initialize the model
        $model = $this->model;

        // Get filter parameters
        $status = $this->request->getGet('status');
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $keyword = $this->request->getGet('keyword');

        // Fetch documents using your existing getAllDocuments method
        // Ensure this method in your model supports additional filtering
        $documents = $model->getAllDocuments($status, $start_date, $end_date, $keyword);

        // Prepare view data
        $data = [
            'documents' => $documents,
            'isLoggedIn' => $this->session->get('isLoggedIn') ?? false,

            // // Additional data for filtering and UI
            // 'documentTypes' => $this->getDocumentTypes(), // Add this method
            // 'statusOptions' => [
            //     'pending' => 'Pending',
            //     'received' => 'Received',
            //     'confirmed' => 'Ended'
            // ]
        ];

        // Return the view
        return view('dashboard/all_documents', $data);
    }

    public function export()
    {
        $documents = $this->model->getAllDocuments();

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=documents.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, ['Doc Code', 'Sender', 'Subject', 'Description', 'Date', 'Status']);

        foreach ($documents as $document) {
            fputcsv($output, [
                $document['doc_code'],
                $document['sender'],
                $document['subject'],
                $document['description'],
                $document['date_of_letter'],
                ucfirst($document['status'])
            ]);
        }

        fclose($output);
        exit;
    }

    // public function exportDocuments()
    // {
    //     $model = $this->model;

    //     // Get filter parameters
    //     $status = $this->request->getGet('status');
    //     $start_date = $this->request->getGet('start_date');
    //     $end_date = $this->request->getGet('end_date');
    //     $keyword = $this->request->getGet('keyword');

    //     // Fetch documents
    //     $documents = $model->getAllDocuments(
    //         $status,
    //         $start_date,
    //         $end_date,
    //         $keyword
    //     );

    //     // Generate CSV
    //     $this->generateCSV($documents);
    // }

    // protected function generateCSV($documents)
    // {
    //     // Prepare CSV headers
    //     $headers = [
    //         'Document Code',
    //         'Sender',
    //         'Recipient',
    //         'Subject',
    //         'Description',
    //         'Status',
    //         'Date of Letter'
    //     ];

    //     // Prepare file
    //     $filename = 'documents_export_' . date('YmdHis') . '.csv';
    //     header('Content-Type: text/csv');
    //     header('Content-Disposition: attachment; filename="' . $filename . '"');
    //     header('Pragma: no-cache');
    //     header('Expires: 0');

    //     // Open file output
    //     $output = fopen('php://output', 'w');

    //     // Write headers
    //     fputcsv($output, $headers);

    //     // Write document data
    //     foreach ($documents as $document) {
    //         fputcsv($output, [
    //             $document['doc_code'],
    //             $document['sender'],
    //             $document['recipient'],
    //             $document['subject'],
    //             $document['description'],
    //             $document['status'],
    //             $document['date_of_letter']
    //         ]);
    //     }

    //     // Close file
    //     fclose($output);
    //     exit;
    // }

    public function barangayList()
    {
        $data = [
            'barangays' => $this->model->getAllBarangays(),
            'isLoggedIn' => $this->session->get('isLoggedIn') ?? false,
        ];
        return view('dashboard/barangay_list', $data);
    }

    public function barangayDocuments($brgy)
    {
        $status = $this->request->getGet('status');
        $keyword = $this->request->getGet('keyword');

        // Check if the "show all" button was clicked
        if ($this->request->getGet('show_all')) {
            $status = null;
            $keyword = null;
        }

        $data = [
            'documents' => $this->model->getDocumentsByBarangay($brgy, $status, $keyword),
            'barangay' => $brgy,
            'isLoggedIn' => $this->session->get('isLoggedIn') ?? false,
            'showAll' => $this->request->getGet('show_all'), // Pass a flag to indicate if "Show All" was clicked
        ];

        return view('dashboard/barangay_documents', $data);
    }
}
