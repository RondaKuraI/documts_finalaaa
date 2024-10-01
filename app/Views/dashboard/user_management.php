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

        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-white">
                            <div class="card-header bg-light">
                                <h3 class="text-white mb-0">User List</h3>
                            </div>

                            <div class="card-body p-6">
                                <!-- Search Form (similar to outgoing view) -->
                                <form action="<?= site_url('search_users') ?>" method="get" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control bg-white" placeholder="Search users..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </form>
                                <!-- End of search form -->

                                <!-- Show all button, similar to outgoing -->
                                <a href="<?= site_url('user_management') ?>" class="btn btn-warning">Show All</a>

                                <div class="mb-3 mt-4">
                                    <?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])) : ?>
                                        <p>Search results for: <?= esc($_GET['keyword']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <table class="table table-bordered" id="userTable">
                                    <thead>
                                        <tr class="text-white text-center bg-primary">
                                            <th>Nos.</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Barangay</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($users)) : ?>
                                            <tr>
                                                <td colspan="7" class="p-1 text-center">No users found</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($users as $index => $user) : ?>
                                                <tr>
                                                    <td class="px-2 py-1 align-middle text-center"><?= $index + 1 ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $user['name'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $user['email'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $user['brgy'] ?></td> <!-- Assuming 'brgy' represents the office -->
                                                    <td class="px-2 py-1 align-middle"><?= $user['role'] ?></td>
                                                    <td class="px-2 py-1 align-middle text-center">
                                                        <span class="badge <?= $user['status'] === 'Active' ? 'bg-success' : 'bg-danger' ?>">
                                                            <?= $user['status'] ?? 'Inactive' ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-2 py-1 align-middle text-center">
                                                        <a href="<?= base_url('user_view/' . $user['id']); ?>" class="btn btn-success btn-sm">View</a>
                                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "pageLength": 10,
            "lengthChange": false
        });

        $('#searchInput').on('keyup', function() {
            $('#userTable').DataTable().search(this.value).draw();
        });
    });
</script>
<?= $this->endSection(); ?>
