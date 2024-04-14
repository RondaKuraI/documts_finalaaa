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

        <?php $validation = \Config\Services::validation(); ?>
        <div class="bg-dark">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <!-- <div class="col-lg-6 mx-auto"> -->
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-secondary">
                            <div class="card-header">
                                <h3 class="text-white">Document View</h3>
                            </div>
                            <div class="card-body p-5">


                                <form action="<?= base_url() ?>" method="POST">
                                    <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control" placeholder="Document Code" value="<?= $model['doc_code']; ?>" >
                                    </div>


                                    <div class="mb-3">
                                        <label for="recipient">Email</label>
                                        <input type="email" name="recipient" id="recipient" class="form-control" placeholder="Email">
                                    </div>


                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                                    </div>


                                    <div class="mb-3">
                                        <label for="message">Message</label>
                                        <textarea name="label" id="label" rows="4" class="form-control" placeholder="Message"></textarea>
                                    </div>


                                    <div class="mb-3">
                                        <label for="file">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control'' ?>">
                                    </div>

                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary bg-gradient">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>