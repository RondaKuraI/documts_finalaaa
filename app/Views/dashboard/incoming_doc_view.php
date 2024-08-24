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
                            <br>
                            <div class="mx-5">
                                <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Add Details</h4>
                            </div>
                            <div class="card-body p-5">
                            <form>
                                    <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control bg-dark" value="<?= $document['doc_code'] ?>" disabled>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="sender">Sender</label>
                                        <input type="text" name="sender" id="sender" class="form-control bg-dark" value="<?= $document['sender'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recipient">Recipient</label>
                                        <input type="text" name="recipient" id="recipient" class="form-control bg-dark" value="<?= $document['recipient'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control bg-dark" value="<?= $document['subject'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control bg-dark" disabled><?= $document['description'] ?></textarea>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_letter">Date of Letter</label>
                                            <input type="text" name="date_of_letter" id="date_of_letter" class="form-control bg-dark" value="<?= $document['date_of_letter'] ?>" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <input type="text" name="deadline" id="deadline" class="form-control bg-dark" value="<?= $document['deadline'] ?>" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Attachment</h4>
                                    </div>
                                    <br>

                                    <div class="mb-3 ">
                                        <label for="file">File</label>
                                        <a href="<?= base_url($document['path']) ?>" target="_blank" class="btn btn-primary">Download</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection(); ?>