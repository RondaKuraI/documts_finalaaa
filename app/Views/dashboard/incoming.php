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
                                            <th>Doc. Code</th>
                                            <th>Sender</th>
                                            <th>Details</th>
                                            <th>Required Action</th>
                                            <th>Date of Letter</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="7" class="p-1 text-center">No records found</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?= $this->endSection(); ?>