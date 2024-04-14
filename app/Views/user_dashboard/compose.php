<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Sidebar Start -->
    <?= $this->include("partials/user_sidebar"); ?>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <?php $validation = \Config\Services::validation(); ?>
        <div class="bg-dark">
            <div class="container pt-4">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow bg-secondary">
                            <div class="card-header">
                                <h3 class="text-primary">Compose</h3>
                            </div>
                            <div class="card-body p-5">

                                <?php if(session()->setFlashdata(('success'))) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session()->getFlashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if(session()->setFlashdata(('error'))) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('send') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control <?= ($validation->getError('email')) ? 'is-invalid' : '' ?>" placeholder="Email">
                                        <?php if($validation->getError('email')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control <?= ($validation->getError('subject')) ? 'is-invalid' : '' ?>" placeholder="Subject">
                                        <?php if($validation->getError('subject')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('subject') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message">Message</label>
                                        <textarea name="message" id="message" rows="4" class="form-control <?= ($validation->getError('message')) ? 'is-invalid' : '' ?>" placeholder="Message"></textarea>
                                        <?php if($validation->getError('message')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('message') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="file">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control <?= ($validation->getError('file')) ? 'is-invalid' : '' ?>">
                                        <?php if($validation->getError('file')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('file') ?></div>
                                        <?php endif; ?>
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