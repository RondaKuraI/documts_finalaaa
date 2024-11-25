<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content bg-white">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow bg-white">
                            <div class="card-header bg-light">
                                <h3 class="text-white mb-0 fs-4">All Documents</h3>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <!-- Search and Filter Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-8">
                                        <form action="<?= site_url('all_documents') ?>" method="get">
                                            <div class="input-group">
                                                <input type="hidden" name="type" value="documents">
                                                <input type="text" name="keyword" class="form-control bg-white" placeholder="Search documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-search d-md-none"></i>
                                                    <span class="d-none d-md-inline">Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        <a href="<?= site_url('all_documents') ?>" class="btn btn-warning w-100 w-md-auto">
                                            <i class="bi bi-list-ul me-1"></i> Show All
                                        </a>
                                    </div>
                                </div>

                                <?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])) : ?>
                                    <div class="alert alert-info">
                                        Search results for: <?= esc($_GET['keyword']) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <form action="<?= site_url('all_documents') ?>" method="get">
                                            <select class="form-select" name="status" onchange="this.form.submit()">
                                                <option value="">Filter by Status</option>
                                                <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="received" <?= isset($_GET['status']) && $_GET['status'] == 'received' ? 'selected' : '' ?>>Received</option>
                                                <option value="confirmed" <?= isset($_GET['status']) && $_GET['status'] == 'confirmed' ? 'selected' : '' ?>>Ended</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="<?= site_url('export') ?>" class="btn btn-success mb-3">
                                            <i class="bi bi-file-earmark-spreadsheet"></i> Export to CSV
                                        </a>
                                    </div>
                                </div>

                                <!-- Responsive Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle" id="mydatatable">
                                        <thead>
                                            <tr class="text-white bg-primary">
                                                <th class="d-none d-md-table-cell">Doc. Code</th>
                                                <th>Sender</th>
                                                <th class="d-none d-md-table-cell">Subject</th>
                                                <th>Description</th>
                                                <th class="d-none d-lg-table-cell">Date</th>
                                                <th class="d-none d-lg-table-cell">Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($documents)) : ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-3">No records found</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($documents as $message) : ?>
                                                    <tr>
                                                        <td class="d-none d-md-table-cell"><?= $message['doc_code'] ?></td>
                                                        <td><?= $message['sender'] ?></td>
                                                        <td class="d-none d-md-table-cell"><strong><?= $message['subject'] ?></strong></td>
                                                        <td>
                                                            <div class="d-md-none mb-1">
                                                                <small class="text-muted"><?= $message['doc_code'] ?></small>
                                                            </div>
                                                            <div class="text-truncate" style="max-width: 150px;">
                                                                <?= $message['description'] ?>
                                                            </div>
                                                            <div class="d-md-none mt-1">
                                                                <small class="text-muted"><?= date('M d, Y', strtotime($message['date_of_letter'])) ?></small>
                                                            </div>
                                                        </td>
                                                        <td class="d-none d-lg-table-cell"><?= date('M d, Y', strtotime($message['date_of_letter'])) ?></td>
                                                        <td>
                                                            <?php if ($message['status'] == 'pending') : ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php elseif ($message['status'] == 'received') : ?>
                                                                <span class="badge bg-success">Received</span>
                                                            <?php elseif ($message['status'] == 'confirmed') : ?>
                                                                <span class="badge bg-danger">Ended</span>
                                                            <?php else : ?>
                                                                <span class="badge bg-secondary"><?= ucfirst($message['status']) ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Actions
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="<?= base_url('incoming_doc_view/' . $message['id']) ?>">
                                                                            <i class="bi bi-search me-2"></i> View
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="<?= base_url('fileupload/archive/' . $message['id']) ?>">
                                                                            <i class="bi bi-archive me-2"></i> Archive
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
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
            </div>
        </div>
        <?= $this->endSection(); ?>

        <!-- Add DataTable Initialization -->
        <script>
            $(document).ready(function() {
                // Initialize DataTable with responsive features
                $('#mydatatable').DataTable({
                    responsive: true,
                    ordering: true,
                    pageLength: 10,
                    language: {
                        searchPlaceholder: "Search documents"
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>