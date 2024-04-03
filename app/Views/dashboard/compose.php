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
            <div class="container pt-4">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow bg-secondary">
                            <div class="card-header">
                                <h3 class="text-primary">Contact Us</h3>
                            </div>
                            <div class="card-body p-5">
                                <form action="<?= base_url('send') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                                    </div>

                                    <div class="mb-3">
                                        <label for="message">Message</label>
                                        <textarea name="message" id="message" rows="4" class="form-control" placeholder="Message"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="file">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark bg-gradient">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>