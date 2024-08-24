<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control bg-dark border-0" type="search" placeholder="Search">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
    <div class="nav-item dropdown">
            <a href="<?= site_url('notifications'); ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notifications</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <?php if (isset($notifications) && !empty($notifications)): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <a href="<?= site_url('notifications/mark-as-read/' . $notification['id']); ?>" class="dropdown-item">
                            <h6 class="fw-normal mb-0"><?= esc($notification['subject']); ?></h6>
                            <small>Received at: <?= esc(date('Y-m-d H:i:s', strtotime($notification['created_at']))); ?></small>
                        </a>
                        <hr class="dropdown-divider">
                    <?php endforeach; ?>
                    <a href="<?= site_url('notifications'); ?>" class="dropdown-item text-center">See all notifications</a>
                <?php else: ?>
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">No new notifications</h6>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <!-- <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
                <span class="d-none d-lg-inline-flex">
                    <?= session()->get('name') ?? 'Guest' ?>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
        <?php if($isLoggedIn): ?>
            <a href="#" class="dropdown-item">My Profile</a>
            <a href="#" class="dropdown-item">Settings</a>
            <a href="<?= base_url('logout') ?>" class="dropdown-item">Log Out</a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="dropdown-item">Log In</a>
        <?php endif; ?>
    </div>
        </div>
    </div>
</nav>