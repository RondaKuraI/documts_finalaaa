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


        <!-- CARDS -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-warning rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-line fa-3x text-dark"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-white">All Incoming Docs</p>
                            <h4 class="mb-0 text-white"><?= $all_incoming_count ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-primary rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-bar fa-3x text-dark"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-white">Pending Docs</p>
                            <h4 class="mb-0 text-white"><?= $pending_count ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-success rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-area fa-3x text-white"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-white">Received Docs</p>
                            <h4 class="mb-0 text-white">0</h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-danger rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-pie fa-3x text-white"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-white">Ended Docs</p>
                            <h4 class="mb-0 text-white">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CARDS -->


        <!-- Sales Chart Start -->
        <?= $this->include("partials/charts"); ?>
        <!-- Sales Chart End -->


        <!-- Recent Sales Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Incoming Documents</h5>
                    <a href="<?= base_url('incoming') ?>" class="btn btn-primary btn-sm">Show All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle" id="mydatatable">
                            <thead>
                                <tr class="text-white bg-primary">
                                    <th class="d-none d-md-table-cell">Doc. Code</th>
                                    <th>Sender</th>
                                    <th class="d-none d-md-table-cell">Subject</th>
                                    <th>Description</th>
                                    <th class="d-none d-lg-table-cell">Date</th>
                                    <th class="d-none d-lg-table-cell">Deadline</th>
                                    <th>Action</th>
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
                                            <!-- <td class="d-none d-lg-table-cell"><?= $message['deadline'] ?? 'N/A' ?></td> -->
                                            <td class="d-none d-lg-table-cell"><?= date('M d, Y', strtotime($message['deadline']) ?? 'N/A') ?></td>
                                            <td>
                                                <a href="<?= base_url('incoming_doc_view/' . $message['id']) ?>" class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-search"></i>
                                                    <span class="d-none d-md-inline ms-1">View</span>
                                                </a>
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
        <!-- Recent Sales End -->

        <!-- Reply Tabs Section Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Message Conversations</h5>
                        <div class="nav nav-tabs border-0">
                            <button class="nav-link active me-2 btn btn-sm btn-primary text-white" data-bs-toggle="tab" data-bs-target="#all">
                                All <span class="badge bg-white text-primary ms-1"><?= count($messages ?? []) ?></span>
                            </button>
                            <button class="nav-link me-2 btn btn-sm btn-secondary" data-bs-toggle="tab" data-bs-target="#reply">
                                Reply <span class="badge bg-white text-secondary ms-1"><?= count($reply_messages ?? []) ?></span>
                            </button>
                            <button class="nav-link me-2 btn btn-sm btn-warning" data-bs-toggle="tab" data-bs-target="#urgent">
                                Urgent <span class="badge bg-white text-warning ms-1"><?= count($urgent_messages ?? []) ?></span>
                            </button>
                            <button class="nav-link btn btn-sm btn-info" data-bs-toggle="tab" data-bs-target="#usual">
                                Usual <span class="badge bg-white text-info ms-1"><?= count($usual_messages ?? []) ?></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Doc. Code</th>
                                            <th>Sender</th>
                                            <th>Details</th>
                                            <th>Date of Reply</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($messages)) : ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-3">No messages found</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($messages as $msg) : ?>
                                                <tr>
                                                    <td><?= $msg['doc_code'] ?></td>
                                                    <td>
                                                        <div><?= $msg['sender'] ?></div>
                                                        <small class="text-muted"><?= $msg['position'] ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 300px;">
                                                            <?= $msg['details'] ?>
                                                        </div>
                                                    </td>
                                                    <td><?= date('M d, Y h:i a', strtotime($msg['reply_date'])) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('view_conversation/' . $msg['id']) ?>" class="btn btn-info btn-sm text-white">
                                                            <i class="bi bi-eye"></i>
                                                            <span class="d-none d-md-inline ms-1">View</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Repeat similar structure for other tabs (reply, urgent, usual) -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Reply Tabs Section End -->


        <!-- Widgets Start -->
        <!-- <?= $this->include("partials/widgets"); ?> -->
        <!-- Widgets End -->

        <?= $this->endSection(); ?>