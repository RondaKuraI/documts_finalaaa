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

        <div class="bg-dark">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-secondary">
                            <div class="card-header">
                                <h3 class="text-white">Incoming Documents
                                    <!-- <a href="<?= base_url(); ?>" class="btn btn-info btn-sm float-end">Add</a> -->
                                </h3>
                            </div>
                            <div class="card-body p-5">
                                <table class="table table-bordered" id="mydatatable">
                                    <thead>
                                        <tr class="text-white">
                                            <th>Doc. Code</th>
                                            <th>Sender</th>
                                            <th>Details</th>
                                            <th>Date of Letter</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($files)) : ?>
                                            <?php foreach ($files as $file) : ?>
                                                <tr>
                                                    <td><?= $file['doc_code']; ?></td>
                                                    <td><?= $file['sender']; ?></td>
                                                    <td><?= $file['description']; ?></td>
                                                    <td><?= $file['date_of_letter']; ?></td>
                                                    <td><?= $file['status']; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('doc_view/' . $row['id']); ?>" class="badge btn-success view_btn">View</a>
                                                        <a href="<?= base_url($row['path']) ?>" class="badge btn-primary" target="_blank" title="Download File" download="<?= $row['fname'] ?>">Download</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <th colspan="8" class="p-1 text-center">No records found</th>
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