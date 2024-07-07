<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class GColumnChartController extends BaseController
{
    public function index()
    {
        return view('dashboard/reports');
    }

    public function initChart()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('filess');
        $builder->select('DISTINCT MONTH(date_of_letter) as month, (SELECT COUNT(*) FROM filess WHERE MONTH(date_of_letter) = month) as file_count, subject');
        $builder->groupBy('subject, MONTH(date_of_letter)');
        $query = $builder->get();
        $chart_data = $query->getResultArray();

        return view('dashboard/reports', ['chart_data' => $chart_data]);
    }
}
