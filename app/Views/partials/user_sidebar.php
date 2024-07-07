<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>E-GovDocs</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">John Edward</h6>
                <span>User</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="<?= base_url('user_dashboard'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_dashboard') ? ' active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="<?= base_url('user_compose'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_compose') ? ' active' : ''; ?>"><i class="fa fa-plus me-2"></i>Compose</a>
            <a href="<?= base_url('user_incoming'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_incoming') ? ' active' : ''; ?>"><i class="fa fa-file-download me-2"></i>Incoming</a>
            <a href="<?= base_url('user_outgoing'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_outgoing') ? ' active' : ''; ?>"><i class="fa fa-file-import me-2"></i>Outgoing</a>
        </div>

    </nav>
</div>