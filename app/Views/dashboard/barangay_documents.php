<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <?= $this->include("partials/sidebar"); ?>

    <div class="content bg-white">
        <?= $this->include("partials/navbar"); ?>

        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow bg-white">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h3 class="text-white mb-0 fs-4">Documents - Barangay <?= esc($barangay) ?></h3>
                            <a href="<?= base_url('barangay_list') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to List
                            </a>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <!-- Search and Filter Section -->
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-8">
                                    <form action="<?= current_url() ?>" method="get">
                                        <div class="input-group">
                                            <input type="text" name="keyword" class="form-control bg-white" placeholder="Search documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-search d-md-none"></i>
                                                <span class="d-none d-md-inline">Search</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="<?= current_url() . '?show_all=1' ?>" class="btn btn-warning w-100">
                                        <i class="bi bi-arrow-repeat me-2"></i> Show All
                                    </a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <select class="form-select" name="status" onchange="window.location.href=this.value">
                                        <option value="<?= current_url() ?>">All Status</option>
                                        <option value="<?= current_url() ?>?status=pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>
                                            Pending
                                        </option>
                                        <option value="<?= current_url() ?>?status=received" <?= isset($_GET['status']) && $_GET['status'] == 'received' ? 'selected' : '' ?>>
                                            Received
                                        </option>
                                        <option value="<?= current_url() ?>?status=confirmed" <?= isset($_GET['status']) && $_GET['status'] == 'confirmed' ? 'selected' : '' ?>>
                                            Ended
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Modified Table Section -->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle" id="mydatatable">
                                    <thead>
                                        <tr class="text-white bg-primary">
                                            <th class="d-none d-md-table-cell">Doc. Code</th>
                                            <th>Sender</th>
                                            <th>Details</th>
                                            <th class="d-none d-lg-table-cell">Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($documents)) : ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-3">No documents found</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($documents as $doc) : ?>
                                                <tr>
                                                    <td class="d-none d-md-table-cell text-dark"><?= esc($doc['doc_code']) ?></td>
                                                    <td class="text-dark"><?= esc($doc['sender']) ?></td>
                                                    <td>
                                                        <div>
                                                            <strong class="d-block mb-1 text-dark"><?= esc($doc['subject']) ?></strong>
                                                            <small class="text-muted"><?= esc($doc['description']) ?></small>
                                                        </div>
                                                    </td>
                                                    <td class="d-none d-lg-table-cell text-dark">
                                                        <?= date('M d, Y', strtotime($doc['date_of_letter'])) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = [
                                                            'pending' => 'bg-warning text-dark',
                                                            'received' => 'bg-success',
                                                            'confirmed' => 'bg-danger'
                                                        ];
                                                        $class = $statusClass[$doc['status']] ?? 'bg-secondary';
                                                        ?>
                                                        <span class="badge <?= $class ?>">
                                                            <?= $doc['status'] === 'confirmed' ? 'Ended' : ucfirst($doc['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                Actions
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="<?= base_url('incoming_doc_view/' . $doc['id']) ?>">
                                                                        <i class="bi bi-search me-2"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="<?= base_url('fileupload/archive/' . $doc['id']) ?>">
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
        <?= $this->endSection(); ?>