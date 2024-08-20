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


        <!-- CARDS -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-warning rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-line fa-3x text-dark"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-dark">All Incoming Docs</p>
                            <h4 class="mb-0 text-secondary"><?= $all_incoming_count ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-info rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-bar fa-3x text-dark"></i>
                        <div class="ms-3">
                            <p class="mb-2 text-dark">Pending Docs</p>
                            <h4 class="mb-0 text-dark"><?= $pending_count ?></h6>
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
        <?= $this->include("partials/incoming"); ?>
        <!-- Recent Sales End -->


        <!-- Widgets Start -->
        <!-- <?= $this->include("partials/widgets"); ?> -->
        <!-- Widgets End -->

        <?= $this->endSection(); ?>