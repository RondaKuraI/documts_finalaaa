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
                                <h5 class="text-white mb-0">Compose Document</h5>
                            </div>
                            <br>
                            <div class="bg-primary text-center p-2">
                                <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Add Details</h4>
                            </div>
                            <div class="card-body p-6">

                                <!-- <?php if (session()->getFlashdata(('main_success'))) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session()->getFlashdata('main_success'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata(('main_error'))) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('main_error'); ?>
                                    </div>
                                <?php endif; ?> -->

                                <?php if (session()->getFlashdata('main_success')) : ?>
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: '<?= session()->getFlashdata('main_success'); ?>',
                                        });
                                    </script>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('main_error')) : ?>
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: '<?= session()->getFlashdata('main_error'); ?>',
                                        });
                                    </script>
                                <?php endif; ?>


                                <form action="<?= base_url('send') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="doc_code">Document Code</label>
                                        <input type="text" name="doc_code" id="doc_code" class="form-control bg-white <?= ($validation->getError('doc_code')) ? 'is-invalid' : '' ?>" placeholder="Document Code" value="<?= old('doc_code') ?>" required>
                                        <?php if ($validation->getError('doc_code')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('doc_code') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="qr_code">QR Code</label>
                                        <div id="qr_code_container"></div>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="sender">Sender</label>
                                        <select name="sender" id="sender" class="form-control bg-white<?= ($validation && $validation->hasError('sender')) ? 'is-invalid' : '' ?>">
                                            <option value="">Select Sender</option>
                                            <?php foreach ($users as $user) : ?>
                                                <option value="<?= $user['name'] ?>" <?= old('sender') == $user['name'] ? 'selected' : '' ?>><?= $user['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($validation && $validation->hasError('sender')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('sender') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recipient">Recipient</label>
                                        <select name="recipient" id="recipient" class="form-control bg-white <?= ($validation && $validation->hasError('recipient')) ? 'is-invalid' : '' ?>">
                                            <option value="">Select Recipient</option>
                                            <?php foreach ($users as $user) : ?>
                                                <option value="<?= $user['name'] ?>" <?= old('recipient') == $user['name'] ? 'selected' : '' ?>><?= $user['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if ($validation && $validation->hasError('recipient')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('recipient') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <input type="text" name="subject" id="subject" class="form-control bg-white <?= ($validation->getError('subject')) ? 'is-invalid' : '' ?>" placeholder="Subject" value="<?= old('subject') ?>">
                                        <?php if ($validation->getError('subject')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('subject') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="4" class="form-control bg-white <?= ($validation->getError('description')) ? 'is-invalid' : '' ?>" placeholder="Description"><?= old('description') ?></textarea>
                                        <?php if ($validation->getError('description')) : ?>
                                            <div class="invalid-feedback"><?= $validation->getError('description') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label for="date_of_letter">Date of Letter</label>
                                            <div class="input-group date" id="datepicker">
                                                <input type="text" name="date_of_letter" id="date_of_letter" class="form-control bg-white <?= ($validation->getError('date_of_letter')) ? 'is-invalid' : '' ?>" placeholder="Date of Letter" value="<?= old('date_of_letter') ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-white text-dark" style="height: 100%; display: flex; align-items: center; padding: 0 0.75rem;"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <?php if ($validation->getError('date_of_letter')) : ?>
                                                    <div class="invalid-feedback"><?= $validation->getError('date_of_letter') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <div class="input-group date" id="deadline-datepicker">
                                                <input type="text" name="deadline" id="deadline" class="form-control bg-white <?= ($validation->getError('deadline')) ? 'is-invalid' : '' ?>" placeholder="Deadline" value="<?= old('deadline') ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-white text-dark" style="height: 100%; display: flex; align-items: center; padding: 0 0.75rem;"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <?php if ($validation->getError('deadline')) : ?>
                                                    <div class="invalid-feedback"><?= $validation->getError('deadline') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6">
                                            <label for="deadline">Deadline</label>
                                            <input type="date" name="deadline" id="deadline" class="form-control <?= ($validation->getError('deadline')) ? 'is-invalid' : '' ?>" placeholder="deadline" value="<?= old('deadline') ?>" required>
                                            <?php if ($validation->getError('deadline')) : ?>
                                                <div class="invalid-feedback"><?= $validation->getError('deadline') ?></div>
                                            <?php endif; ?>
                                        </div> -->
                                    </div>
                                    <br>
                                    <div>
                                        <h4 class="text-white mb-0 d-flex justify-content-center align-items-center bg-primary">Add Attachment/s</h4>
                                    </div>
                                    <br>

                                    <div class="mb-3 ">
                                        <label for="file">Select File</label>
                                        <input type="file" name="file" id="file" class="form-control bg-white <?= ($validation->getError('file')) ? 'is-invalid' : '' ?>">
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

    

        <?= $this->section("scripts"); ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
                $('#deadline-datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });

                $('#datepicker .input-group-text').on('click', function() {
                    $('#datepicker input').focus();
                });

                $('#deadline-datepicker .input-group-text').on('click', function() {
                    $('#deadline-datepicker input').focus();
                });

                // Document code uniqueness check
                $('#doc_code').on('blur', function() {
                    var docCode = $(this).val();
                    if (docCode.length > 0) {
                        $.ajax({
                            url: '<?= base_url('check-doc-code') ?>',
                            method: 'POST',
                            data: {
                                doc_code: docCode
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (!response.isUnique) {
                                    $('#doc_code_error').text(response.message).show();
                                    $('#doc_code').addClass('is-invalid');
                                } else {
                                    $('#doc_code_error').hide();
                                    $('#doc_code').removeClass('is-invalid');
                                }
                            },
                            error: function() {
                                $('#doc_code_error').text('Error checking document code').show();
                            }
                        });
                    }
                });

                // Prevent form submission if document code is not unique
                $('form').on('submit', function(e) {
                    if ($('#doc_code').hasClass('is-invalid')) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please choose a unique document code'
                        });
                    }
                });

                // QR Code generation
                $('#doc_code').on('input', function() {
                    var docCode = $(this).val();
                    if (docCode.length > 0) {
                        $.ajax({
                            url: '<?= base_url('generate-qr') ?>',
                            method: 'POST',
                            data: {
                                doc_code: docCode
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#qr_code_container').html('<img src="' + response.qr_code_url + '" alt="QR Code" class="img-fluid" style="max-width: 200px;">');
                                } else {
                                    $('#qr_code_container').html('<p>Failed to generate QR code: ' + response.message + '</p>');
                                }
                            },
                            error: function() {
                                $('#qr_code_container').html('<p>Error generating QR code</p>');
                            }
                        });
                    } else {
                        $('#qr_code_container').empty();
                    }
                });
            });

            // Display SweetAlert for success and error flashdata
            <?php if (session()->getFlashdata('main_success')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?= session()->getFlashdata('main_success'); ?>',
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('main_error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= session()->getFlashdata('main_error'); ?>',
                });
            <?php endif; ?>
        </script>

        <?= $this->endSection(); ?>