<?php $page_session = \Config\Services::session(); ?>

<?= $this->extend('layouts/header') ?>

<?= $this->section("content"); ?>

<div class="container-fluid position-relative d-flex p-0">



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
                            <span class="text-danger"><?= display_error($validation, 'name'); ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address" value="<?= set_value('email'); ?>">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="mb-1">
                            <span class="text-danger"><?= display_error($validation, 'email'); ?></span>
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
                            <span class="text-danger"><?= display_error($validation, 'email'); ?></span>
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
                            <span class="text-danger"><?= display_error($validation, 'email'); ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="<?= set_value('password'); ?>">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="mb-1">
                            <span class="text-danger"><?= display_error($validation, 'password'); ?></span>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="confirmpassword" class="form-control" id="floatingPassword" placeholder="Confirm Password" value="<?= set_value('confirmpassword'); ?>">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        <div class="mb-4">
                            <span class="text-danger"><?= display_error($validation, 'confirmpassword'); ?></span>
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
</div>

<?= $this->endSection(); ?>