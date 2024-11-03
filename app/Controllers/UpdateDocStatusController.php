<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileModel;
use CodeIgniter\I18n\Time;

class UpdateDocStatusController extends BaseController
{
    protected $fileModel;

    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $json = $this->request->getJSON();
        $documentId = $json->document_id ?? null;
        $status = $json->status ?? null;

        if (!$documentId || !$status) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required data']);
        }

        try {
            // Set timezone to Asia/Manila
            $timezone = 'Asia/Manila';
            $currentTime = Time::now($timezone)->toDateTimeString();
            
            $updateData = ['status' => $status];
            
            // Add appropriate timestamp based on status
            if ($status === 'received') {
                $updateData['updated_at'] = $currentTime;
            } elseif ($status === 'confirmed') {
                $updateData['confirmed_at'] = $currentTime;
            }

            $updated = $this->fileModel->update($documentId, $updateData);

            if ($updated) {
                // Get the updated document
                $document = $this->fileModel->find($documentId);
                
                // Format timestamps for display
                $receivedTime = !empty($document['updated_at']) 
                    ? Time::parse($document['updated_at'], $timezone)->toDateTimeString()
                    : null;
                
                $confirmedTime = !empty($document['confirmed_at'])
                    ? Time::parse($document['confirmed_at'], $timezone)->toDateTimeString()
                    : null;
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Document status updated successfully',
                    'timestamp' => $currentTime,
                    'received_timestamp' => $receivedTime,
                    'confirmed_timestamp' => $confirmedTime
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update document status'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating document status: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while updating the status'
            ]);
        }
    }
}