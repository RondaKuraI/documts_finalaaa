<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;

class ChartController extends BaseController
{
    protected $fileModel;

    public function __construct(){
        $this->fileModel = new FileModel();
    }

    public function index()
    {
        $chartData = $this->getChartData();
        return view('dashboard/maintenance', ['chartData' => json_encode($chartData)]);
    }

    private function getChartData(){
        $documents = $this->fileModel->findAll();
        $chartData = [
            'labels' => [],
            'data' => []
        ];

        // Group documents by month
        $groupedDocs = [];
        foreach($documents as $doc){
            $month = date('F Y', strtotime($doc['date_of_letter']));
            if(!isset($groupedDocs[$month])){
                $groupedDocs[$month] = 0;
            }
            $groupedDocs[$month]++;
        }

        // Prepare data for chart.js
        foreach($groupedDocs as $month =>$count){
            $chartData['labels'][] = $month;
            $chartData['data'][] = $count;
        }

        return $chartData;
    }
}
