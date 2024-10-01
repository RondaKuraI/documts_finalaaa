<?= $this->extend('layouts/header') ?>

<?= $this->section("content"); ?>

<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
    <div class="bg-secondary rounded-3 p-4 w-100" style="max-width: 400px;">
        <img src="/img/Department_of_the_Interior_and_Local_Government_(DILG)_Seal_-_Logo.png" alt="DILG Logo" class="d-block mx-auto mb-4" style="max-width: 100px;">
        <h3 class="text-center mb-3">Welcome!</h3>
        <p class="text-center text-muted mb-4">Login to your account</p>

        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url(); ?>SigninController/loginAuth" method="post">
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control bg-dark text-light border-0" id="floatingInput" placeholder="Email Address" value="<?= set_value('email') ?>">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3 position-relative">
                <input type="password" name="password" class="form-control bg-dark text-light border-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <button type="button" id="togglePassword" class="btn position-absolute end-0 top-50 translate-middle-y me-2">
                    <i class="fa fa-eye text-light" aria-hidden="true"></i>
                </button>
            </div>

            <!-- <div class="text-end mb-3">
                <a href="#" class="text-primary">Forgot Your Password?</a>
            </div> -->
            <button type="submit" class="btn btn-primary py-3 w-100 mb-3">Login</button>
            <a href="<?= base_url(); ?>" class="btn btn-outline-primary w-100">Don't have an account? Register</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function(e) {
        const password = document.getElementById('floatingPassword');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?= $this->endSection(); ?>
