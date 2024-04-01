<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->


        <!-- Sale & Revenue Start -->
        <?= $this->include("partials/cards"); ?>
        <!-- Sale & Revenue End -->


        <!-- Sales Chart Start -->
        <?= $this->include("partials/charts"); ?>
        <!-- Sales Chart End -->


        <!-- Recent Sales Start -->
        <?= $this->include("partials/recent"); ?>
        <!-- Recent Sales End -->


        <!-- Widgets Start -->
        <?= $this->include("partials/widgets"); ?>
        <!-- Widgets End -->

<?= $this->endSection(); ?>