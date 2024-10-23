<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-white">
                            <div class="card-header bg-light">
                                <?php if ($session->get('role') == 'admin') : ?>
                                    <h3 class="text-white mb-0">All Outgoing Documents</h3>
                                <?php else : ?>
                                    <h3 class="text-white mb-0">Your Outgoing Documents</h3>
                                <?php endif; ?>
                            </div>

                            <div class="card-body p-6">
                                <!-- Add this search form -->
                                <form action="<?= site_url('search') ?>" method="get" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control bg-white" placeholder="Search documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </form>
                                <!-- End of search form -->
                                <a href="<?= site_url('outgoing') ?>" class="btn btn-warning">Show All</a>

                                <div class="mb-3 mt-4">
                                    <?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])) : ?>
                                        <p>Search results for: <?= esc($_GET['keyword']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <table class="table table-hover table-striped align-middle" id="mydatatable">
                                    <thead>
                                        <tr class="text-white text-center bg-primary">
                                            <th scope="col">ID</th>
                                            <th scope="col">Doc. Code</th>
                                            <th scope="col">Recipient</th>
                                            <th scope="col">Details</th>
                                            <!-- <th>Description</th> -->
                                            <th scope="col">Date of Letter</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="filedata">
                                        <?php
                                        $i = 1;
                                        foreach ($uploads as $row) :
                                            $row['fname'] = str_replace("uploads/", "", $row['path']);
                                        ?>
                                            <tr>
                                                <td class="px-2 py-1 align-middle text-center"><?= $row['id'] ?></td>
                                                <td class="text-center"><?= $row['doc_code'] ?></td>
                                                <td class=""><?= $row['recipient'] ?></td>
                                                <td>
                                                    <strong><?= $row['subject'] ?></strong> -
                                                    <span class="text-muted"><?= $row['description'] ?></span>
                                                </td>
                                                <td class=""><?= $row['date_of_letter'] ?></td>
                                                <!-- <td class="px-2 py-1 align-middle text-center">
                                                    <?php if ($row['status'] == 'pending') : ?>
                                                        <span class="status-pending d-inline-block">Pending</span>
                                                    <?php else : ?>
                                                        <?= $row['status'] ?>
                                                    <?php endif; ?>
                                                </td> -->
                                                <td class="text-center">
                                                    <?php if ($row['status'] == 'pending') : ?>
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    <?php elseif ($row['status'] == 'received') : ?>
                                                        <span class="badge bg-danger">Received</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-success"><?= ucfirst($row['status']) ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- <td class="px-2 py-1 align-middle text-center">
                                                    <a href="<?= base_url('doc_view/' . $row['id']); ?>" class="btn btn-success btn-sm view_btn">View</a>
                                                    <a href="<?= base_url($row['path']) ?>" class="btn btn-primary btn-sm" target="_blank" title="Download File" download="<?= $row['fname'] ?>">Download</a>
                                                </td> -->
                                                <td class="text-center">
                                                    <a href="<?= base_url('doc_view/' . $row['id']); ?>" class="btn btn-info btn-sm text-white">
                                                        <i class="bi bi-search"></i> View
                                                    </a>
                                                    <!-- <a href="<?= base_url($row['path']) ?>" class="btn btn-primary btn-sm" target="_blank" download="<?= $row['fname'] ?>">
                                                        <i class="bi bi-download"></i> Download
                                                    </a> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (!isset($uploads) || (isset($uploads) && count($uploads) <= 0)) : ?>
                                            <tr>
                                                <th colspan="6" class="p-1 text-center">No records found</th>
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