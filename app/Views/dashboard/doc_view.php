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
        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <!-- <div class="col-lg-6 mx-auto"> -->
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-white">
                            <div class="card-header d-flex justify-content-center align-items-center bg-light">
                                <h5 class="text-white mb-0">Document Details</h5>
                            </div>
                            <br>
                            <div class="bg-primary text-center p-2">
                                <h4 class="mb-0">DOCUMENT CODE: <?= $document['doc_code'] ?></h4>
                            </div>
                            <div class="card-body p-6">
                                <form>
                                    <!-- <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control bg-outline-dark" value="<?= $document['doc_code'] ?>" disabled>
                                    </div> -->
                                    <div class="bg-primary text-white rounded p-3 mb-2">
                                        <h6 class="mb-0">Status - <?= $document['recipient'] ?></h6>
                                        <h6 class="mb-0">
                                            <br>
                                            <?php if ($document['status'] == 'pending') : ?>
                                                <span class="status-pending">Pending</span>
                                            <?php else : ?>
                                                <?= $document['status'] ?>
                                            <?php endif; ?>
                                        </h6>
                                    </div>


                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Details</h4>
                                    </div>
                                    <br>
                                    <div class="mb-3">
                                        <label for="sender" class="text-dark">Sender</label>
                                        <input type="text" name="sender" id="sender" class="form-control bg-outline-dark" value="<?= $document['sender'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recipient">Recipient</label>
                                        <input type="text" name="recipient" id="recipient" class="form-control bg-outline-dark" value="<?= $document['recipient'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control bg-outline-dark" value="<?= $document['subject'] ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control bg-outline-dark" disabled><?= $document['description'] ?></textarea>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_letter">Date of Letter</label>
                                            <input type="text" name="date_of_letter" id="date_of_letter" class="form-control bg-outline-dark" value="<?= $document['date_of_letter'] ?>" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <input type="text" name="deadline" id="deadline" class="form-control bg-outline-dark" value="<?= $document['deadline'] ?>" disabled>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Attachment</h4>
                                    </div>
                                    <br>

                                    <div class="shadow d-flex justify-content-between align-items-center bg-white rounded p-2 mb-2">
                                        <div class="mb-0">
                                            <label for="file"><?= $document['original_name'] ?></label>
                                        </div>
                                        <div>
                                            <a href="<?= base_url('view/' . $document['id']) ?>" class="btn btn-sm btn-primary me-2">View</a>
                                            <a href="<?= base_url($document['path']) ?>" class="btn btn-sm btn-warning">Download</a>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">QR Code</h4>
                                        <div class="text-center mt-3">
                                            <?php if (!empty($document['qr_code'])) : ?>
                                                <img src="<?= base_url('uploads/' . $document['qr_code']) ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                            <?php else : ?>
                                                <p>QR Code not available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection(); ?>