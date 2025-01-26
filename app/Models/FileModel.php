<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'filess';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'doc_code',
        'sender',
        'recipient',
        'subject',
        'description',
        'prioritization',
        'action',
        'date_of_letter',
        'updated_at',
        'confirmed_at',
        'deadline',
        'status',
        'path',
        'original_name',
        'qr_code',
        'archived'
    ];

    public function getAllDocuments($status = null, $start_date = null, $end_date = null, $keyword = null)
    {
        $builder = $this->where('archived', 0);

        // Status filter
        if ($status) {
            $builder->where('status', $status);
        }

        // Date range filter
        if ($start_date && $end_date) {
            $builder->where('date_of_letter >=', $start_date)
                ->where('date_of_letter <=', $end_date);
        }

        // Keyword search
        if ($keyword) {
            $builder->groupStart()
                ->like('doc_code', $keyword)
                ->orLike('sender', $keyword)
                ->orLike('subject', $keyword)
                ->orLike('description', $keyword)
                ->groupEnd();
        }

        // Order by most recent first
        $builder->orderBy('date_of_letter', 'DESC');

        return $builder->findAll();
    }

    public function getDocumentsByBarangay($brgy, $status = null, $keyword = null)
    {
        $builder = $this->select('filess.*, users.name as name, users.brgy')
            ->join('users', 'users.name = filess.sender', 'left')
            ->where('users.brgy', $brgy)
            ->where('filess.archived', 0);

        // Status filter
        if ($status) {
            $builder->where('filess.status', $status);
        }

        // Keyword search
        if ($keyword) {
            $builder->groupStart()
                ->like('filess.doc_code', $keyword)
                ->orLike('filess.subject', $keyword)
                ->orLike('filess.description', $keyword)
                ->groupEnd();
        }

        return $builder->orderBy('filess.date_of_letter', 'DESC')->findAll();
    }

    public function getAllBarangays()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
            ->select('brgy')
            ->where('brgy IS NOT NULL')
            ->distinct()
            ->orderBy('brgy', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getRecentActivity()
    {
        $builder = $this->db->table($this->table)
            ->orderBy('updated_at', 'DESC')
            ->limit(5)
            ->get();

        return $builder->getResultArray();
    }

    public function getStatusBreakdown()
    {
        $builder = $this->db->table($this->table);
        $statusBreakdown = $builder->select('status, COUNT(*) AS count')
            ->groupBy('status')
            ->get()
            ->getResultArray();

        return $statusBreakdown;
    }

    public function getAverageProcessingTime()
    {
        $builder = $this->db->table($this->table);
        $result = $builder->selectMax('updated_at')
            ->selectMin('created_at')
            ->get()
            ->getRowArray();

        $totalSeconds = strtotime($result['updated_at']) - strtotime($result['created_at']);
        $totalDocuments = $this->countAll();

        return $totalDocuments > 0 ? round($totalSeconds / $totalDocuments, 2) : 0;
    }

    public function countDocumentsBySender()
    {
        $builder = $this->db->table('filess');
        $builder->select('sender, COUNT(*) as documents_created');
        $builder->groupBy('sender');
        $query = $builder->get();

        return $query->getResultArray(); // Returns an associative array with sender and total_documents
    }

    public function getDocuments($filters = [])
{
    $builder = $this->db->table('filess'); // Reference your table

    // Example filters: Adjust based on your use case
    if (isset($filters['status']) && $filters['status'] !== '') {
        $builder->where('status', $filters['status']);
    }

    if (isset($filters['start_date']) && isset($filters['end_date'])) {
        $builder->where('created_at >=', $filters['start_date']);
        $builder->where('created_at <=', $filters['end_date']);
    }

    if (isset($filters['doc_code']) && $filters['doc_code'] !== '') {
        $builder->where('doc_code', $filters['doc_code']);
    }

    // Get results as an array
    return $builder->get()->getResultArray();
}



    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
