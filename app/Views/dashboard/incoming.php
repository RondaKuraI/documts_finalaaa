<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content bg-gradient-light">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <div class="bg-gradient-light">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow bg-gradient-light">
                            <div class="card-header bg-gradient-dark">
                                <?php if ($session->get('role') == 'admin') : ?>
                                    <h3 class="text-white mb-0 fs-4">All Incoming Documents</h3>
                                <?php else : ?>
                                    <h3 class="text-white mb-0 fs-4">Your Incoming Documents</h3>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <!-- Search and Filter Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-8">
                                        <form action="<?= site_url('search') ?>" method="get">
                                            <div class="input-group">
                                                <input type="hidden" name="type" value="incoming">
                                                <input type="text" name="keyword" class="form-control bg-white" placeholder="Search documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                                <button class="btn btn-light" type="submit">
                                                    <i class="bi bi-search d-md-none"></i>
                                                    <span class="d-none d-md-inline">Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        <a href="<?= site_url('incoming') ?>" class="btn btn-danger w-100 w-md-auto">
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
                                    <table class="table table-sm table-hover table-striped align-middle fs-7" id="mydatatable">
                                        <thead class="text-center">
                                            <tr class="text-white bg-gradient-primary">
                                                <th class="w-auto text-nowrap">Doc. Code</th>
                                                <th class="w-auto text-nowrap">Sender</th>
                                                <th class="w-25 text-wrap">Details</th>
                                                <th class="w-25 text-wrap">Required Action</th>
                                                <th class="w-auto text-nowrap">Date</th>
                                                <th class="w-auto text-nowrap">Status</th>
                                                <th class="w-auto text-nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($incoming)) : ?>
                                                <tr>
                                                    <td colspan="7" class="text-center py-3">No records found</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($incoming as $message) : ?>
                                                    <tr>
                                                        <td class="w-auto text-nowrap text-dark"><?= $message['doc_code'] ?></td>
                                                        <td class="w-auto text-nowrap">
                                                            <strong class="text-dark"><?= $message['sender'] ?></strong> -
                                                            <small class="text-primary"><?= $message['brgy'] ?></small>
                                                        </td>
                                                        <td class="w-25 text-wrap">
                                                            <strong class="text-dark"><?= $message['subject'] ?></strong><br>
                                                            <span class=""><?= $message['description'] ?></span>
                                                        </td>

                                                        <td class="w-25 text-wrap"><?= $message['action'] ?? 'For Information' ?></td>

                                                        <td class="w-auto text-nowrap"><?= date('M d, Y', strtotime($message['date_of_letter'])) ?></td>
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
                                                            <div class="d-flex gap-2">
                                                                <a href="<?= base_url('incoming_doc_view/' . $message['id']) ?>" class="btn btn-light btn-sm text-white">
                                                                    <i class="bi bi-search"></i>
                                                                    <span class="d-none d-md-inline ms-1">View</span>
                                                                </a>
                                                                <a href="<?= base_url('conversation/' . $message['id']) ?>" class="btn btn-primary btn-sm">
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