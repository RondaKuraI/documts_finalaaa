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
                                <h3 class="text-white">Outgoing Documents
                                    <!-- <a href="<?= base_url(); ?>" class="btn btn-info btn-sm float-end">Add</a> -->
                                </h3>
                            </div>
                            <div class="card-body p-5">
                                <table class="table table-bordered" id="mydatatable">
                                    <thead>
                                        <tr class="text-white">
                                            <th>ID</th>
                                            <th>Doc. Code</th>
                                            <th>Recipient</th>
                                            <th>Details</th>
                                            <th>Date of Letter</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($uploads as $row) :
                                            $row['fname'] = str_replace("uploads/", "", $row['path']);
                                        ?>
                                            <tr>
                                                <td class="px-2 py-1 align-middle text-center"><?= number_format($i++) ?></td>
                                                <td class="px-2 py-1 align-middle"><?= $row['doc_code'] ?></td>
                                                <td class="px-2 py-1 align-middle"><?= $row['recipient'] ?></td>
                                                <td class="px-2 py-1 align-middle"><?= $row['subject'] ?></td>
                                                <td class="px-2 py-1 align-middle"><?= $row['date_of_letter'] ?></td>
                                                <td class="px-2 py-1 align-middle"><?= $row['status'] ?></td>
                                                <!-- <td class="px-2 py-1 align-middle"><p class="m-0 text-truncate" title="<?= $row['fname'] ?>"><?= $row['fname'] ?></p></td> -->
                                                <td class="px-2 py-1 align-middle text-center">
                                                    <!-- <a href="<?= base_url('doc_view/'.$row['doc_code']); ?>" class="btn btn-warning btn-sm" target="_blank" title="View File"><i class="fa fa-external-link"></i>View</a> -->
                                                    <a href="<?= base_url($row['path']) ?>" class="text-primary fw-bolder text-decoration-none mx-2" target="_blank" title="Download File" download="<?= $row['fname'] ?>"><i class="fa fa-download"></i></a>
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