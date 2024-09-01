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
                                <h3 class="text-white mb-0">Incoming Documents</h3>
                            </div>
                            <div class="card-body p-6">
                                <table class="table table-bordered" id="mydatatable">
                                    <thead>
                                        <tr class="text-white bg-primary">
                                            <th>Doc. Code</th>
                                            <th>Sender</th>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>Date of Letter</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($incoming)) : ?>
                                            <tr>
                                                <td colspan="7" class="p-1 text-center">No records found</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($incoming as $message) : ?>
                                                <tr>
                                                    <td class="px-2 py-1 align-middle"><?= $message['doc_code'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $message['sender'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $message['subject'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= substr($message['description'], 0, 50) . '...' ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $message['date_of_letter'] ?></td>
                                                    <td class="px-2 py-1 align-middle"><?= $message['deadline'] ?? 'N/A' ?></td>
                                                    <td>
                                                        <a href="<?= base_url('incoming_doc_view/' . $message['id']) ?>" class="btn btn-success btn-sm ">View</a>
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

        <?= $this->endSection(); ?>