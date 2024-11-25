<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Sidebar Start -->
    <?= $this->include("partials/sidebar"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content bg-white">
        <!-- Navbar Start -->
        <?= $this->include("partials/navbar"); ?>
        <!-- Navbar End -->

        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow bg-white">
                            <div class="card-header bg-light">
                                <h3 class="text-white mb-0 fs-4">Archived Documents</h3>
                            </div>
                            <div class="card-body p-3 p-md-4">
                                <!-- Search and Filter Section -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-8">
                                        <form action="<?= site_url('search') ?>" method="get">
                                            <div class="input-group">
                                                <input type="hidden" name="type" value="archived">
                                                <input type="text" name="keyword" class="form-control bg-white" placeholder="Search archived documents..." value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>" autocomplete="off">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-search d-md-none"></i>
                                                    <span class="d-none d-md-inline">Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        <a href="<?= site_url('documents/archived') ?>" class="btn btn-warning w-100 w-md-auto">
                                            <i class="bi bi-list-ul me-1"></i> Show All
                                        </a>
                                    </div>
                                </div>

                                <?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])) : ?>
                                    <div class="alert alert-info">
                                        Search results for: <?= esc($_GET['keyword']) ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Responsive Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle" id="archivedTable">
                                        <thead>
                                            <tr class="text-white bg-primary">
                                                <th>Doc. Code</th>
                                                <th>Subject</th>
                                                <th>Sender</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($archived)) : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-3">No archived documents found.</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($archived as $doc) : ?>
                                                    <tr>
                                                        <td><?= esc($doc['doc_code']) ?></td>
                                                        <td><?= esc($doc['subject']) ?></td>
                                                        <td><?= esc($doc['sender']) ?></td>
                                                        <td><?= date('M d, Y', strtotime($doc['date_of_letter'])) ?></td>
                                                        <td>
                                                            <a href="/fileupload/unarchive/<?= esc($doc['id']) ?>" class="btn btn-success btn-sm">
                                                                <i class="bi bi-box-arrow-up"></i>
                                                                <span class="d-none d-md-inline ms-1">Unarchive</span>
                                                            </a>
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

<?= $this->endSection(); ?>

<!-- Add DataTable Initialization -->
<script>
    $(document).ready(function () {
        $('#archivedTable').DataTable({
            responsive: true,
            ordering: true,
            pageLength: 10,
            language: {
                searchPlaceholder: "Search archived documents"
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });
    });
</script>
