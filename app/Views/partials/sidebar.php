<div class="sidebar pe-2 pb-2" style="width: 250px; min-width: 250px;">
    <nav class="navbar bg-secondary navbar-dark flex-column">
        <a href="index.html" class="navbar-brand mx-3 mb-2">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>E-GovDocs</h3>
        </a>
        <div class="d-flex align-items-center ms-3 mb-3">
            <div class="ms-2">
                <h5 class="mb-0"><?= session()->get('name') ?? 'Guest' ?></h5>
                <span class="fs-6"><?= ucfirst(session()->get('role') ?? 'Guest') ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="<?= base_url('dashboard'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? ' active' : ''; ?>">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="<?= base_url('compose'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/compose') ? ' active' : ''; ?>">
                <i class="fa fa-plus me-2"></i>Compose
            </a>
            <a href="<?= base_url('incoming'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/incoming') ? ' active' : ''; ?>">
                <i class="fa fa-file-download me-2"></i>Incoming
            </a>
            <a href="<?= base_url('outgoing'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/outgoing') ? ' active' : ''; ?>">
                <i class="fa fa-file-import me-2"></i>Outgoing
            </a>

            <?php if (session()->get('role') === 'admin') : ?>
                <?php
                // Determine if the dropdown should be active
                $isDropdownActive = in_array($_SERVER['REQUEST_URI'], ['/all_documents', '/documents/archived']);
                ?>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= $isDropdownActive ? ' active' : ''; ?>" href="#" id="allDocsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-folder me-2"></i>All Documents
                    </a>
                    <ul class="dropdown-menu bg-secondary border-0">
                        <li>
                            <a class="dropdown-item<?= ($_SERVER['REQUEST_URI'] == '/barangay_list') ? ' active' : ''; ?>" href="<?= base_url('barangay_list'); ?>">
                                Active Documents
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item<?= ($_SERVER['REQUEST_URI'] == '/documents/archived') ? ' active' : ''; ?>" href="<?= base_url('documents/archived'); ?>">
                                Archived Documents
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="<?= base_url('maintenance'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/maintenance') ? ' active' : ''; ?>">
                    <i class="fa fa-wrench me-2"></i>Analytics
                </a>
                <a href="<?= base_url('reports'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/reports') ? ' active' : ''; ?>">
                    <i class="fa fa-chart-bar me-2"></i>Reports
                </a>
                <a href="<?= base_url('user_management'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_management') ? ' active' : ''; ?> fs-8">
                    <i class="fa fa-user me-2"></i>User Management
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>



<!-- <div class="sidebar pe-2 pb-2">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-3 mb-2">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>E-GovDocs</h3>
        </a>
        <div class="d-flex align-items-center ms-3 mb-3">
            <div class="ms-2">
                <h5 class="mb-0"><?= session()->get('name') ?? 'Guest' ?></h5>
                <span class="fs-6"><?= ucfirst(session()->get('role') ?? 'Guest') ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="<?= base_url('dashboard'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? ' active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="<?= base_url('compose'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/compose') ? ' active' : ''; ?>"><i class="fa fa-plus me-2"></i>Compose</a>
            <a href="<?= base_url('incoming'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/incoming') ? ' active' : ''; ?>"><i class="fa fa-file-download me-2"></i>Incoming</a>
            <a href="<?= base_url('outgoing'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/outgoing') ? ' active' : ''; ?>"><i class="fa fa-file-import me-2"></i>Outgoing</a>
            
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('all_documents'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/all_documents') ? ' active' : ''; ?>"><i class="fa fa-wrench me-2"></i>All Documents</a>
                <a href="<?= base_url('maintenance'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/maintenance') ? ' active' : ''; ?>"><i class="fa fa-wrench me-2"></i>Analytics</a>
                <a href="<?= base_url('reports'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/reports') ? ' active' : ''; ?>"><i class="fa fa-chart-bar me-2"></i>Reports</a>
                <a href="<?= base_url('user_management'); ?>" class="nav-item nav-link<?= ($_SERVER['REQUEST_URI'] == '/user_management') ? ' active' : ''; ?>"><i class="fa fa-user me-2"></i>User Management</a>
            <?php endif; ?>
        </div>
    </nav>
</div> -->