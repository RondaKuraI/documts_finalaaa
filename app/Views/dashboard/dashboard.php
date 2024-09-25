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
                        <table class="table table-bordered table-hover" id="incomingDocumentsTable">
                            <thead>
                                <tr class="text-white bg-primary">
                                    <th>Doc. Code</th>
                                    <th>Sender</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Date of Letter</th>
                                    <th>Deadline</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($incoming)) : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No records found</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($incoming as $message) : ?>
                                        <tr>
                                            <td><?= esc($message['doc_code']) ?></td>
                                            <td><?= esc($message['sender']) ?></td>
                                            <td><?= esc($message['subject']) ?></td>
                                            <td><?= esc(substr($message['description'], 0, 50) . '...') ?></td>
                                            <td><?= esc($message['date_of_letter']) ?></td>
                                            <td><?= esc($message['deadline'] ?? 'N/A') ?></td>
                                            <td>
                                                <a href="<?= base_url('incoming_doc_view/' . $message['id']) ?>" class="btn btn-success btn-sm">View</a>
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


        <!-- Widgets Start -->
        <!-- <?= $this->include("partials/widgets"); ?> -->
        <!-- Widgets End -->

        <?= $this->endSection(); ?>