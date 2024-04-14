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


        <!-- Sale & Revenue Start -->
        <?= $this->include("partials/cards"); ?>
        <!-- Sale & Revenue End -->


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