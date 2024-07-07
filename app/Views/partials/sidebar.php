<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>E-GovDocs</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <!-- <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div> -->
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Ramon Cayanan</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="<?= base_url('dashboard'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? ' active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="<?= base_url('compose'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/compose') ? ' active' : ''; ?>"><i class="fa fa-plus me-2"></i>Compose</a>
            <a href="<?= base_url('incoming'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/incoming') ? ' active' : ''; ?>"><i class="fa fa-file-download me-2"></i>Incoming</a>
            <a href="<?= base_url('outgoing'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/outgoing') ? ' active' : ''; ?>"><i class="fa fa-file-import me-2"></i>Outgoing</a>
            <a href="<?= base_url('maintenance'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/maintenance') ? ' active' : ''; ?>"><i class="fa fa-wrench me-2"></i>Maintenance</a>
            <a href="<?= base_url('reports'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/reports') ? ' active' : ''; ?>"><i class="fa fa-chart-bar me-2"></i>Reports</a>
            <a href="<?= base_url('user_management'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_management') ? ' active' : ''; ?>"><i class="fa fa-user me-2"></i>UserManagement</a>
        </div>

    </nav>
</div>