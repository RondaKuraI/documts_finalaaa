<?= $this->extend('layouts/header.php') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card bg bg-secondary">
        <div class="card-body bg bg-secondary">
            <h2 class="text-primary">Activation Process</h2>
        </div>
    </div>
    <br>
    <div>
    <?php if(isset($error)) : ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php endif; ?>
    
        <?php if(isset($success)) : ?>
            <div class="alert alert-success">
                <?= $success; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>