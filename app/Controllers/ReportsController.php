<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\FileModel;
use App\Models\UserModel;

class ReportsController extends BaseController
{
    public $fileModel;
    public $userModel;

    public function __construct()
    {
        $this->fileModel = new FileModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $isLoggedIn = $this->session->get('isLoggedIn') ?? false;

        $data = [
            'totalDocuments' => $this->fileModel->countAll(),
            'documentStatusBreakdown' => $this->fileModel->getStatusBreakdown(),
            'averageProcessingTime' => $this->fileModel->getAverageProcessingTime(),
            'recentActivity' => $this->fileModel->getRecentActivity(),
            'topUsers' => $this->userModel->getTopUsers(),
            'documentsBySender' => $this->fileModel->countDocumentsBySender(), // Add this line
            'isLoggedIn' => $isLoggedIn
        ];

        return view('dashboard/reports', $data);
    }


    public function documents()
    {
        $filters = [
            'startDate' => $this->request->getVar('start_date'),
            'endDate' => $this->request->getVar('end_date'),
            'status' => $this->request->getVar('status'),
            'department' => $this->request->getVar('department'),
        ];


        $data = [
            'documents' => $this->fileModel->getDocuments($filters),
            'filters' => $filters,
        ];

        return view('reports/documents', $data);
    }

    public function export()
    {
        $reportType = $this->request->getVar('type');
        $filters = [
            'startDate' => $this->request->getVar('start_date'),
            'endDate' => $this->request->getVar('end_date'),
            'status' => $this->request->getVar('status'),
            'department' => $this->request->getVar('department'),
        ];

        switch ($reportType) {
            case 'csv':
                return $this->exportToCSV($filters);
            case 'excel':
                return $this->exportToExcel($filters);
            default:
                return redirect()->back()->with('error', 'Invalid export type');
        }
    }

    // private function exportToCSV($filters = [])
    // {
    //     $documents = $this->fileModel->getDocuments($filters);

    //     $csv = "Document Code,Subject,Status,Created At,Updated At\n";
    //     foreach ($documents as $doc) {
    //         $csv .= implode(',', [
    //             $doc['doc_code'],
    //             $doc['subject'],
    //             $doc['status'],
    //             $doc['created_at'],
    //             $doc['updated_at'],
    //         ]) . "\n";
    //     }

    //     header('Content-Type: text/csv');
    //     header('Content-Disposition: attachment; filename="document_report.csv"');
    //     echo $csv;
    //     exit;
    // }

    public function exportToCSV()
    {
        $documents = $this->fileModel->getAllDocuments();

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=documents-report.csv");

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


    private function exportToExcel($filters)
    {
        // Code to export to Excel using a library like PhpSpreadsheet
    }
}
