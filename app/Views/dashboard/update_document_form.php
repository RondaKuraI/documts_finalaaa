<?= $this->extend('layouts/base'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update Document</h1>
        <a href="<?= base_url('document/view/' . $document['id']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Document
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('main_success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('main_success') ?>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('main_error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('main_error') ?>
        </div>
    <?php endif; ?>

    <!-- Update Document Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Document: <?= $document['doc_code'] ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('document/update/' . $document['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subject">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?= old('subject', $document['subject']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prioritization">Prioritization <span class="text-danger">*</span></label>
                            <select class="form-control" id="prioritization" name="prioritization" required>
                                <option value="Usual" <?= (old('prioritization', $document['prioritization']) == 'Usual') ? 'selected' : '' ?>>Usual</option>
                                <option value="Urgent" <?= (old('prioritization', $document['prioritization']) == 'Urgent') ? 'selected' : '' ?>>Urgent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="action">Action <span class="text-danger">*</span></label>
                            <select class="form-control" id="action" name="action" required>
                                <option value="For Information" <?= (old('action', $document['action']) == 'For Information') ? 'selected' : '' ?>>For Information</option>
                                <option value="For Review" <?= (old('action', $document['action']) == 'For Review') ? 'selected' : '' ?>>For Review</option>
                                <option value="For Approval" <?= (old('action', $document['action']) == 'For Approval') ? 'selected' : '' ?>>For Approval</option>
                                <option value="For Signature" <?= (old('action', $document['action']) == 'For Signature') ? 'selected' : '' ?>>For Signature</option>
                                <option value="For Compliance" <?= (old('action', $document['action']) == 'For Compliance') ? 'selected' : '' ?>>For Compliance</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deadline">Deadline <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="deadline" name="deadline" value="<?= old('deadline', date('Y-m-d', strtotime($document['deadline']))) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description', $document['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="version_notes">Version Notes <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="version_notes" name="version_notes" rows="3" placeholder="Describe what changes you made in this version" required><?= old('version_notes') ?></textarea>
                    <small class="form-text text-muted">Please provide detailed notes about the changes made in this version.</small>
                </div>

                <div class="form-group">
                    <label for="file">File <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file" required>
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                    <small class="form-text text-muted">Current file: <?= $document['original_name'] ?></small>
                    <small class="form-text text-muted">Allowed file types: PDF, DOC, DOCX (Max: 30MB)</small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update Document</button>
                    <a href="<?= base_url('document/view/' . $document['id']) ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Version History Link -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Version History</h6>
        </div>
        <div class="card-body">
            <p>View all previous versions of this document:</p>
            <a href="<?= base_url('document/versions/' . $document['id']) ?>" class="btn btn-info">
                <i class="fas fa-history"></i> View Version History
            </a>
        </div>
    </div>
</div>

<!-- Script to display the name of the selected file -->
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = this.files[0].name;
        var nextSibling = this.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<?= $this->endSection(); ?>