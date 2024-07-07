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
                                <h3 class="text-white mb-0">Compose Document</h3>
                            </div>
                            <br>
                            <div class="mx-5">
                                <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Add Details</h4>
                            </div>
                            <div class="card-body p-5">

                                <?php if (session()->getFlashdata(('main_success'))) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session()->getFlashdata('main_success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata(('main_error'))) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('main_error'); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('send') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control <?= ($validation->getError('doc_code')) ? 'is-invalid' : '' ?>" placeholder="Document Code" required>
                                        <?php if ($validation->getError('doc_code')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('doc_code') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="sender">Sender</label>
                                        <input type="text" name="sender" id="sender" class="form-control <?= ($validation->getError('sender')) ? 'is-invalid' : '' ?>" placeholder="Sender">
                                        <?php if ($validation->getError('sender')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('sender') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recipient">Recipient</label>
                                        <input type="text" name="recipient" id="recipient" class="form-control <?= ($validation->getError('recipient')) ? 'is-invalid' : '' ?>" placeholder="Recipient">
                                        <?php if ($validation->getError('recipient')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('recipient') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control <?= ($validation->getError('subject')) ? 'is-invalid' : '' ?>" placeholder="Subject">
                                        <?php if ($validation->getError('subject')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('subject') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control <?= ($validation->getError('description')) ? 'is-invalid' : '' ?>" placeholder="Description"></textarea>
                                        <?php if ($validation->getError('description')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('description') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_letter">Date of Letter</label>
                                            <input type="date" name="date_of_letter" id="date_of_letter" class="form-control <?= ($validation->getError('date_of_letter')) ? 'is-invalid' : '' ?>" placeholder="date_of_letter">
                                            <?php if ($validation->getError('date_of_letter')) : ?>
                                                <div class="invalid-feedback"><?= $validation->getError('date_of_letter') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <input type="date" name="deadline" id="deadline" class="form-control <?= ($validation->getError('deadline')) ? 'is-invalid' : '' ?>" placeholder="deadline">
                                            <?php if ($validation->getError('deadline')) : ?>
                                                <div class="invalid-feedback"><?= $validation->getError('deadline') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Add Attachment/s</h4>
                                    </div>
                                    <br>

                                    <div class="mb-3 ">
                                        <label for="file">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control bg-dark<?= ($validation->getError('file')) ? 'is-invalid' : '' ?>">
                                        <?php if ($validation->getError('file')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('file') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary bg-gradient files-save">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection(); ?>