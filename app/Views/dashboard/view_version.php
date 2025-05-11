<?= $this->extend('layouts/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">View Document Version</h1>
        <div>
            <a href="<?= base_url('document/versions/' . $document['id']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Version History
            </a>
            <a href="<?= base_url('document/view/' . $document['id']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                <i class="fas fa-file fa-sm text-white-50"></i> View Current Document
            </a>
        </div>
    </div>

    <!-- Document Version Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Version <?= $version['version_number'] ?> Details</h6>
            <div>
                <a href="<?= base_url(esc($version['path'], 'url')) ?>" target="_blank" class="btn btn-sm btn-primary">
                    <i class="fas fa-download"></i> Download File
                </a>
                <?php if (session()->get('name') == $document['sender'] || session()->get('role') == 'admin') : ?>
                    <a href="<?= base_url('document/restore-version/' . $version['id']) ?>" class="btn btn-sm btn-warning" 
                       onclick="return confirm('Are you sure you want to restore to this version? This will create a new version with the current state before restoration.')">
                        <i class="fas fa-undo"></i> Restore to This Version
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Document Code:</strong> <?= $document['doc_code'] ?></p>
                    <p><strong>Subject:</strong> <?= $document['subject'] ?></p>
                    <p><strong>Version Number:</strong> <?= $version['version_number'] ?></p>
                    <p><strong>Created By:</strong> <?= $version['created_by'] ?></p>
                    <p><strong>Created On:</strong> <?= date('F d, Y h:i A', strtotime($version['created_at'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Original Filename:</strong> <?= $version['original_name'] ?></p>
                    <p><strong>File Path:</strong> <?= $version['path'] ?></p>
                    <p><strong>Sender:</strong> <?= $document['sender'] ?></p>
                    <p><strong>Recipient:</strong> <?= $document['recipient'] ?></p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-left-info">
                        <div class="card-body">
                            <h5 class="card-title">Version Notes</h5>
                            <p class="card-text"><?= nl2br(esc($version['notes'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Preview -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Document Preview</h6>
        </div>
        <div class="card-body">
            <?php
            $fileExtension = pathinfo($version['path'], PATHINFO_EXTENSION);
            if (in_array(strtolower($fileExtension), ['pdf'])) {
                // PDF Preview
                echo '<div class="embed-responsive embed-responsive-16by9">';
                echo '<iframe class="embed-responsive-item" src="' . base_url($version['path']) . '" allowfullscreen></iframe>';
                echo '</div>';
            } else {
                // Non-PDF files
                echo '<div class="text-center p-4">';
                echo '<i class="fas fa-file-alt fa-5x text-secondary mb-3"></i>';
                echo '<p>Preview not available for ' . strtoupper($fileExtension) . ' files.</p>';
                echo '<a href="' . base_url($version['path']) . '" target="_blank" class="btn btn-primary">Download to View</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Document Comparison (if applicable) -->
    <?php if ($version['version_number'] > 1) : ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Version Comparison</h6>
        </div>
        <div class="card-body">
            <p>This is version <?= $version['version_number'] ?> of the document. You can compare with other versions from the version history.</p>
            <a href="<?= base_url('document/versions/' . $document['id']) ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-history"></i> View All Versions
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>