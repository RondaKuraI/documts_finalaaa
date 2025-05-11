<?= $this->extend('layouts/base'); ?>

<?= $this->section('content'); ?>
<!-- Sidebar Start -->
<?= $this->include("partials/sidebar"); ?>
<!-- Sidebar End -->

<div class="content">
  <!-- Navbar Start -->
  <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Document Versions</h1>
      <a href="<?= base_url('view/file/' . $document['id']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Document
      </a>
    </div>

    <!-- Document Info Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Document Information</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>Document Code:</strong> <?= $document['doc_code'] ?></p>
            <p><strong>Subject:</strong> <?= $document['subject'] ?></p>
            <p><strong>Sender:</strong> <?= $document['sender'] ?></p>
            <p><strong>Recipient:</strong> <?= $document['recipient'] ?></p>
          </div>
          <div class="col-md-6">
            <p><strong>Current Status:</strong> <span class="badge <?= $document['status'] == 'confirmed' ? 'bg-success' : ($document['status'] == 'received' ? 'bg-info' : 'bg-warning') ?>"><?= ucfirst($document['status']) ?></span></p>
            <p><strong>Prioritization:</strong> <?= $document['prioritization'] ?></p>
            <p><strong>Date Created:</strong> <?= date('F d, Y', strtotime($document['created_at'])) ?></p>
            <p><strong>Deadline:</strong> <?= date('F d, Y', strtotime($document['deadline'])) ?></p>
          </div>
        </div>
      </div>
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

    <!-- Versions Table -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Version History</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover" id="versionsTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Version</th>
                <th>Created By</th>
                <th>Date</th>
                <th>Notes</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($versions)) : ?>
                <tr>
                  <td colspan="5" class="text-center">No versions available</td>
                </tr>
              <?php else : ?>
                <?php foreach ($versions as $version) : ?>
                  <tr>
                    <td><?= $version['version_number'] ?></td>
                    <td><?= $version['created_by'] ?></td>
                    <td><?= date('F d, Y h:i A', strtotime($version['created_at'])) ?></td>
                    <td><?= $version['notes'] ?></td>
                    <td>
                      <a href="<?= base_url('document/view-version/' . $version['id']) ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> View
                      </a>
                      <a href="<?= base_url(esc($version['path'], 'url')) ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i> Download
                      </a>
                      <?php if (session()->get('name') == $document['sender'] || session()->get('role') == 'admin') : ?>
                        <a href="<?= base_url('document/restore-version/' . $version['id']) ?>" class="btn btn-sm btn-warning"
                          onclick="return confirm('Are you sure you want to restore to this version? This will create a new version with the current state before restoration.')">
                          <i class="fas fa-undo"></i> Restore
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- DataTables JavaScript -->
<script>
  $(document).ready(function() {
    $('#versionsTable').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>

<?= $this->endSection(); ?>