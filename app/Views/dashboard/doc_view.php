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
                            <div class="card-header d-flex justify-content-center align-items-center bg-primary">
                                <h3 class="text-white mb-0">Document Details</h3>
                            </div>
                            <div class="card-body p-5">
                                <form action="<?= base_url('') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control" placeholder="Document Code" value="<?= $file['doc_code'] ?>">
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="sender">Sender</label>
                                        <input type="text" name="sender" id="sender" class="form-control" placeholder="Sender" value="<?= $file['sender'] ?>">
                                    </div>


                                    <div class="mb-3">
                                        <label for="recipient">Recipient</label>
                                        <input type="text" name="recipient" id="recipient" class="form-control" placeholder="Recipient" value="<?= $file['recipient'] ?>">
                                    </div>


                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="<?= $file['subject'] ?>">
                                    </div>


                                    <!-- <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Description" value="<?= $file['description'] ?>"></textarea>
                                    </div> -->


                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_letter">Date of Letter</label>
                                            <input type="date" name="date_of_letter" id="date_of_letter" class="form-control" placeholder="date_of_letter" value="<?= $file['date_of_letter'] ?>">
                                        </div>


                                        <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <input type="date" name="deadline" id="deadline" class="form-control" placeholder="deadline" value="<?= $file['deadline'] ?>">
                                        </div>
                                    </div>


                                    <!-- <div class="d-grid">
                                        <button type="submit" class="btn btn-primary bg-gradient files-save">Send</button>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection(); ?>