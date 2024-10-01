<?php $page_session = \Config\Services::session(); ?>

<?= $this->extend('layouts/header') ?>

<?= $this->section("content"); ?>

<div class="container-fluid d-flex justify-content-center align-items-center vh-100 p-0">
    <div class="bg-secondary rounded-3 p-4 w-100 mx-auto" style="max-width: 600px;">
        <h3 class="text-center mb-3">Register</h3>
        <p class="text-center text-muted mb-4">Please enter your information and submit to create an account.</p>

        <?php if ($page_session->getTempdata('success')) : ?>
            <div class="alert alert-success text-center"><?= $page_session->getTempdata('success') ?></div>
        <?php endif; ?>

        <?php if ($page_session->getTempdata('error')) : ?>
            <div class="alert alert-danger text-center"><?= $page_session->getTempdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('store'); ?>" method="post">
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0"> <!-- Margin for small devices -->
                    <div class="form-floating">
                        <input type="text" name="name" class="form-control bg-dark text-light border-0" id="floatingText" placeholder="Name" value="<?= set_value('name'); ?>">
                        <label for="floatingText">Full Name</label>
                        <span class="text-danger small"><?= isset($validation) ? $validation->getError('name') : '' ?></span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control bg-dark text-light border-0" id="floatingInput" placeholder="Email Address" value="<?= set_value('email'); ?>">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <span class="text-danger small"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0"> <!-- Added margin for small devices -->
                    <div class="form-floating">
                        <select class="form-select bg-dark text-light border-0" id="floatingSelectRole" name="role" aria-label="Select Role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <label for="floatingSelectRole">Select Role</label>
                        <span class="text-danger small"><?= isset($validation) ? $validation->getError('role') : '' ?></span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select bg-dark text-light border-0" id="floatingSelectBrgy" name="brgy" aria-label="Select Barangay">
                            <option value="Bigaan">Bigaan</option>
                            <option value="Calangatan">Calangatan</option>
                            <option value="Calsapa">Calsapa</option>
                            <option value="Ilag">Ilag</option>
                            <option value="Lumangbayan">Lumangbayan</option>
                            <option value="Tacligan">Tacligan</option>
                            <option value="Poblacion">Poblacion</option>
                            <option value="Caagutayan">Caagutayan</option>
                        </select>
                        <label for="floatingSelectBrgy">Select Barangay</label>
                        <span class="text-danger small"><?= isset($validation) ? $validation->getError('brgy') : '' ?></span>
                    </div>
                </div>
            </div>

            <!-- Password and Confirm Password Fields in a Single Row -->
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0 position-relative"> <!-- Margin for small devices -->
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control bg-dark text-light border-0" id="floatingPassword" placeholder="Password" value="<?= set_value('password'); ?>">
                        <label for="floatingPassword">Password</label>
                        <span class="text-danger small"><?= isset($validation) ? $validation->getError('password') : '' ?></span>
                    </div>
                    <button type="button" id="togglePassword" class="btn position-absolute end-0 top-50 translate-middle-y me-2">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="col-12 col-md-6 position-relative">
                    <div class="form-floating">
                        <input type="password" name="confirmpassword" class="form-control bg-dark text-light border-0" id="floatingConfirmPassword" placeholder="Confirm Password" value="<?= set_value('confirmpassword'); ?>">
                        <label for="floatingConfirmPassword">Confirm Password</label>
                        <span class="text-danger small"><?= isset($validation) ? $validation->getError('confirmpassword') : '' ?></span>
                    </div>
                    <button type="button" id="toggleConfirmPassword" class="btn position-absolute end-0 top-50 translate-middle-y me-2">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary py-3 w-100 mb-3">Register</button>
            <a href="<?= base_url('/login'); ?>" class="btn btn-outline-primary w-100">Already have an Account? Login</a>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('floatingPassword');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Toggle confirm password visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const confirmPasswordField = document.getElementById('floatingConfirmPassword');
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?= $this->endSection(); ?>




<!-- <div class="container-fluid position-relative d-flex p-0">
    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <!-- <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                            </a> -->
                        <h3>Register</h3>
                    </div>
                    <?php if ($page_session->getTempdata('success')) : ?>
                        <div class="alert alert-success"><?= $page_session->getTempdata('success') ?></div>
                    <?php endif; ?>

                    <?php if ($page_session->getTempdata('error')) : ?>
                        <div class="alert alert-danger"><?= $page_session->getTempdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?php echo base_url('store'); ?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="floatingText" placeholder="Name" value="<?= set_value('name'); ?>">
                            <label for="floatingText">Name</label>
                        </div>
                        <div class="mb-1">
                            <!-- <span class="text-danger"><?= display_error($validation, 'name'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('name') : '' ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address" value="<?= set_value('email'); ?>">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="mb-1">
                            <!-- <span class="text-danger"><?= display_error($validation, 'email'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
                        </div>

                        <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" name="role"
                                    aria-label="Floating label select example">
                                    <!-- <option selected>Open this select menu</option> -->
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <label for="floatingSelect">Select Role:</label>
                            </div>
                        <div class="mb-1">
                            <!-- <span class="text-danger"><?= display_error($validation, 'email'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
                        </div>

                        <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" name="brgy"
                                    aria-label="Floating label select example">
                                    <option value="Bigaan">Bigaan</option>
                                    <option value="Calangatan">Calangatan</option>
                                    <option value="Calsapa">Calsapa</option>
                                    <option value="Ilag">Ilag</option>
                                    <option value="Lumangbayan">Lumangbayan</option>
                                    <option value="Tacligan">Tacligan</option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="Caagutayan">Caagutayan</option>
                                </select>
                                <label for="floatingSelect">Select Barangay:</label>
                            </div>
                        <div class="mb-1">
                            <!-- <span class="text-danger"><?= display_error($validation, 'email'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="<?= set_value('password'); ?>">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="mb-1">
                            <!-- <span class="text-danger"><?= display_error($validation, 'password'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('password') : '' ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="confirmpassword" class="form-control" id="floatingPassword" placeholder="Confirm Password" value="<?= set_value('confirmpassword'); ?>">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <div class="mb-4">
                            <!-- <span class="text-danger"><?= display_error($validation, 'confirmpassword'); ?></span> -->
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('confirmpassword') : '' ?></span>
                        </div>

                        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <a href="">Forgot Password</a>
                        </div> -->

                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Register</button>
                    </form>
                    <p class="text-center mb-0">Already have an Account? <a href="<?= base_url('/login'); ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->
</div> -->