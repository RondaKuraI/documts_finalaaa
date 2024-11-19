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
                                <?php if ($session->get('role') == 'admin') : ?>
                                    <h3 class="text-white mb-0 fs-4">All Outgoing Documents</h3>
                                <?php else : ?>
                                    <h3 class="text-white mb-0 fs-4">Your Outgoing Documents</h3>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <!-- Search and Filter Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-8">
                                        <form action="<?= site_url('search') ?>" method="get">
                                            <div class="input-group">
                                                <input type="hidden" name="type" value="outgoing">
                                                <input type="text" name="keyword" class="form-control bg-white" placeholder="Search documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-search d-md-none"></i>
                                                    <span class="d-none d-md-inline">Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        <a href="<?= site_url('outgoing') ?>" class="btn btn-warning w-100 w-md-auto">
                                            <i class="bi bi-list-ul me-1"></i> Show All
                                        </a>
                                    </div>
                                </div>

                                <?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])) : ?>
                                    <div class="alert alert-info">
                                        Search results for: <?= esc($_GET['keyword']) ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Responsive Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle" id="mydatatable">
                                        <thead>
                                            <tr class="text-white bg-primary">
                                                <th class="d-none d-md-table-cell">Doc. Code</th>
                                                <th>Recipient</th>
                                                <th class="d-none d-md-table-cell">Subject</th>
                                                <th>Description</th>
                                                <th class="d-none d-lg-table-cell">Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($uploads)) : ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-3">No records found</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($uploads as $row) :
                                                    $row['fname'] = str_replace("uploads/", "", $row['path']);
                                                ?>
                                                    <tr>
                                                        <td class="d-none d-md-table-cell"><?= $row['doc_code'] ?></td>
                                                        <td><?= $row['recipient'] ?></td>
                                                        <td class="d-none d-md-table-cell"><strong><?= $row['subject'] ?></strong></td>
                                                        <td>
                                                            <div class="d-md-none mb-1">
                                                                <small class="text-muted"><?= $row['doc_code'] ?></small>
                                                            </div>
                                                            <div class="text-truncate" style="max-width: 150px;">
                                                                <?= $row['description'] ?>
                                                            </div>
                                                            <div class="d-md-none mt-1">
                                                                <small class="text-muted"><?= date('M d, Y', strtotime($row['date_of_letter'])) ?></small>
                                                            </div>
                                                        </td>
                                                        <td class="d-none d-lg-table-cell"><?= date('M d, Y', strtotime($row['date_of_letter'])) ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'pending') : ?>
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            <?php elseif ($row['status'] == 'received') : ?>
                                                                <span class="badge bg-success">Received</span>
                                                            <?php elseif ($row['status'] == 'confirmed') : ?>
                                                                <span class="badge bg-danger">Ended</span>
                                                            <?php else : ?>
                                                                <span class="badge bg-secondary"><?= ucfirst($row['status']) ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="<?= base_url('doc_view/' . $row['id']); ?>" class="btn btn-info btn-sm text-white">
                                                                    <i class="bi bi-search"></i>
                                                                    <span class="d-none d-md-inline ms-1">View</span>
                                                                </a>
                                                                <a href="<?= base_url('conversation/' . $row['id']) ?>" class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-chat-dots"></i>
                                                                    <span class="d-none d-md-inline ms-1">Chat</span>
                                                                </a>
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

        <!-- Add this to your footer or before </body> -->
        <script>
            $(document).ready(function() {
                // Initialize DataTable with responsive features
                $('#mydatatable').DataTable({
                    responsive: true,
                    ordering: true,
                    pageLength: 10,
                    language: {
                        searchPlaceholder: "Search records"
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>