<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentVersionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'document_versions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'original_document_id',
        'version_number',
        'path',
        'original_name',
        'created_by',
        'updated_at',
        'notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'original_document_id' => 'required|numeric',
        'version_number' => 'required|numeric',
        'path' => 'required',
        'original_name' => 'required',
        'created_by' => 'required'
    ];

    // Get the latest version number for a document
    public function getLatestVersionNumber($documentId)
    {
        $result = $this->where('original_document_id', $documentId)
                       ->selectMax('version_number')
                       ->first();
        
        return $result ? (int)$result['version_number'] : 0;
    }

    // Get all versions for a document
    public function getDocumentVersions($documentId)
    {
        return $this->where('original_document_id', $documentId)
                    ->orderBy('version_number', 'DESC')
                    ->findAll();
    }
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
