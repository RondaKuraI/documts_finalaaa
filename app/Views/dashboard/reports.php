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

        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <div class="icon bg-info text-white rounded-circle mb-3 mx-auto d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-file fa-lg"></i>
                            </div>
                            <h5 class="card-title text-dark">Total Documents</h5>
                            <h3 class="fw-bold text-dark"><?= $totalDocuments ?></h3>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-9">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">Document Status Breakdown</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="documentStatusChart"></canvas>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="text-end mb-3">
                <a href="<?= base_url('export-csv') ?>" class="btn btn-dark">
                    <i class="fas fa-download"></i> Export to CSV
                </a>
            </div>

            <div class="row">
                <!-- Recent Activity -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Document ID</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recentActivity)) : ?>
                                            <?php foreach ($recentActivity as $activity) : ?>
                                                <tr>
                                                    <td><?= esc($activity['doc_code']) ?></td>
                                                    <td><?= esc($activity['subject']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $activity['status'] == 'pending' ? 'warning' : 'success'; ?>">
                                                            <?= esc(ucfirst($activity['status'])) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= esc($activity['updated_at']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No recent activity</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Users -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Top Users</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Documents Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($topUsers)) : ?>
                                            <?php foreach ($topUsers as $user) : ?>
                                                <tr>
                                                    <td><?= esc($user['name']) ?></td>
                                                    <td><?= esc($user['documents_created']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="2" class="text-center">No data available</td>
                                            </tr>
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