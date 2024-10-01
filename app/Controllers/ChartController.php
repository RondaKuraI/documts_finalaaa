<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use App\Models\UserModel;

class ChartController extends BaseController
{
    protected $fileModel;
    protected $userModel;

    public function __construct()
    {
        $this->fileModel = new FileModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $chartData = $this->getChartData();
        $incomingChartData = $this->getIncomingChartData();
        $usersByBarangayData = $this->getUsersByBarangayChartData();

        $this->data['chartData'] = json_encode($chartData);
        $this->data['incomingChartData'] = json_encode($incomingChartData);
        $this->data['usersByBarangayData'] = json_encode($usersByBarangayData);

        return view('dashboard/maintenance', $this->data);
    }

    private function getChartData()
    {
        $documents = $this->fileModel->findAll();
        $chartData = [
            'labels' => [],
            'data' => []
        ];

        // Initialize an array for all years
        $allYears = [];

        // Group documents by year
        foreach ($documents as $doc) {
            $year = date('Y', strtotime($doc['date_of_letter']));
            if (isset($allYears[$year])) {
                $allYears[$year]++;
            } else {
                $allYears[$year] = 1;
            }
        }

        // Prepare data for chart.js
        foreach ($allYears as $year => $count) {
            $chartData['labels'][] = $year;
            $chartData['data'][] = $count;
        }

        return $chartData;
    }

    private function getIncomingChartData()
    {
        $incomingDocuments = $this->fileModel
            ->where('status', 'pending') // Assuming there's a 'status' column
            ->findAll();

        $incomingChartData = [
            'labels' => [],
            'data' => []
        ];

        // Initialize an array for all months of the year
        $allMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthKey = date('F Y', mktime(0, 0, 0, $i, 1, date('Y')));
            $allMonths[$monthKey] = 0;
        }

        // Group incoming documents by month
        foreach ($incomingDocuments as $doc) {
            $month = date('F Y', strtotime($doc['date_of_letter']));
            if (isset($allMonths[$month])) {
                $allMonths[$month]++;
            }
        }

        // Prepare data for chart.js
        foreach ($allMonths as $month => $count) {
            $incomingChartData['labels'][] = $month;
            $incomingChartData['data'][] = $count;
        }

        return $incomingChartData;
    }

    private function getUsersByBarangayChartData()
    {
        // Fetch all users and group by barangay
        $users = $this->userModel->findAll();
        $barangayData = [
            'labels' => [],
            'data' => []
        ];

        // Initialize a barangay count array
        $barangays = [];

        foreach ($users as $user) {
            $barangay = $user['brgy'];
            if (isset($barangays[$barangay])) {
                $barangays[$barangay]++;
            } else {
                $barangays[$barangay] = 1;
            }
        }

        // Prepare data for chart.js
        foreach ($barangays as $barangay => $count) {
            $barangayData['labels'][] = $barangay;
            $barangayData['data'][] = $count;
        }

        return $barangayData;
    }
}
