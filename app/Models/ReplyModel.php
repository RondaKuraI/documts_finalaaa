<?php

namespace App\Models;

use CodeIgniter\Model;

class ReplyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'document_replies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'document_id',
        'sender',
        'recipient',
        'message',
        'attachment',
        'original_name',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Add this method to join with files table
    public function getRepliesWithDocuments($docCode)
    {
        return $this->select('document_replies.*, filess.subject')
                    ->join('filess', 'filess.id = document_replies.document_id')
                    ->where('document_replies.document_id', $docCode)
                    ->orderBy('document_replies.created_at', 'DESC')
                    ->findAll();
    }

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
