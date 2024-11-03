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

        <?php $validation = \Config\Services::validation(); ?>
        <div class="bg-white">
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <!-- Simple Breadcrumb -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 px-4 py-2">
                                <a href="<?= base_url('outgoing') ?>" class="text-decoration-none text-primary">Outgoing Document(s)</a>
                                <span class="text-secondary mx-2">/</span>
                                <span class="text-secondary">Document View</span>
                                <a href="#" onclick="window.print(); return false;" class="float-end text-dark">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 text-center text-sm-start">
                        <div class="card shadow bg-white">
                            <div class="card-header d-flex justify-content-center align-items-center bg-light">
                                <h5 class="text-white mb-0">Document Details</h5>
                            </div>
                            <br>
                            <div class="bg-primary text-center p-2">
                                <h4 class="mb-0">DOCUMENT CODE: <?= $document['doc_code'] ?></h4>
                            </div>
                            <div class="card-body p-6">
                                <form>
                                    <div class="mb-4">
                                        <!-- Clickable Status Header -->
                                        <div class="bg-primary text-white rounded p-3 mb-2" role="button" data-bs-toggle="collapse" data-bs-target="#statusTimeline" aria-expanded="false" aria-controls="statusTimeline" style="cursor: pointer;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">
                                                        <i class="bi bi-clipboard-check me-1"></i>
                                                        Status - <?= $document['recipient'] ?>
                                                    </h6>
                                                    <h6 class="mb-0">
                                                        <?php if ($document['status'] == 'pending') : ?>
                                                            <span class="badge bg-warning text-dark fs-7 p-1">Pending</span>
                                                        <?php elseif ($document['status'] == 'received') : ?>
                                                            <span class="badge bg-success fs-7 p-1">Received</span>
                                                        <?php elseif ($document['status'] == 'confirmed') : ?>
                                                            <span class="badge bg-danger fs-7 p-1">Ended</span>
                                                        <?php else : ?>
                                                            <span class="badge bg-secondary fs-5 p-2"><?= ucfirst($document['status']) ?></span>
                                                        <?php endif; ?>
                                                    </h6>
                                                </div>
                                                <i class="bi bi-chevron-down"></i>
                                            </div>
                                        </div>

                                        <!-- Collapsible Timeline Content -->
                                        <div class="collapse" id="statusTimeline">
                                            <?php if ($document['status'] == 'pending') : ?>
                                                <div class="alert alert-warning py-1 px-2 mb-2 text-center">
                                                    Pending
                                                </div>
                                            <?php else : ?>
                                                <?php if ($document['updated_at']) : ?>
                                                    <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                                        Document Received on <?= date('M d, Y h:i a', strtotime($document['updated_at'])) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($document['confirmed_at']) : ?>
                                                    <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                                        Document confirmed on <?= date('M d, Y h:i a', strtotime($document['confirmed_at'])) ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($document['status'] == 'confirmed') : ?>
                                                    <div class="alert alert-danger py-1 px-2 mb-2 text-center">
                                                        Ended
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Details Section -->
                                    <div class="mb-4">
                                        <h4 class="text-white mb-3 d-flex justify-content-start align-items-center bg-primary p-1">
                                            <i class="bi bi-info-circle me-2"></i> Details
                                        </h4>

                                        <div class="rounded">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="sender" class="fw-bold text-dark">Sender</label>
                                                    <input type="text" name="sender" id="sender" class="form-control bg-outline-dark" value="<?= $document['sender'] ?>" disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="recipient" class="fw-bold text-dark">Recipient</label>
                                                    <input type="text" name="recipient" id="recipient" class="form-control bg-outline-dark" value="<?= $document['recipient'] ?>" disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="subject" class="fw-bold text-dark">Subject</label>
                                                    <input type="text" name="subject" id="subject" class="form-control bg-outline-dark" value="<?= $document['subject'] ?>" disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="description" class="fw-bold text-dark">Description</label>
                                                    <textarea name="description" id="description" rows="4" class="form-control bg-outline-dark" disabled><?= $document['description'] ?></textarea>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-md-6">
                                                        <label for="date_of_letter" class="fw-bold text-dark">Date of Letter</label>
                                                        <input type="text" name="date_of_letter" id="date_of_letter" class="form-control bg-outline-dark" value="<?= date('M d, Y', strtotime($document['date_of_letter'])) ?>" disabled>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="deadline" class="fw-bold text-dark">Deadline</label>
                                                        <input type="text" name="deadline" id="deadline" class="form-control bg-outline-dark" value="<?= date('M d, Y', strtotime($document['deadline'])) ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Attachments Section -->
                                    <div class="mb-4">
                                        <h4 class="text-white mb-3 d-flex justify-content-start align-items-center bg-primary p-1">
                                            <i class="bi bi-paperclip me-2"></i> Attachments
                                        </h4>

                                        <div class="border rounded p-2">
                                            <div class="d-flex justify-content-between align-items-center bg-white">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                                    <span><?= !empty($document['original_name']) ? $document['original_name'] : 'File' ?></span>
                                                </div>
                                                <div>
                                                    <a href="<?= base_url('view/file/' . $document['id']) ?>" class="btn btn-sm btn-primary me-2" target="_blank">View</a>
                                                    <a href="<?= base_url($document['path']) ?>" class="btn btn-sm btn-warning">Download</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-white mb-3 d-flex justify-content-start align-items-center bg-primary p-1">
                                            <i class="bi bi-qr me-2"></i> QR Code
                                        </h4>
                                        <div class="text-center mt-3">
                                            <?php if (!empty($document['qr_code'])) : ?>
                                                <img src="<?= base_url('uploads/' . $document['qr_code']) ?>" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                            <?php else : ?>
                                                <p>QR Code not available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->endSection(); ?>

        <?= $this->section('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add click event to toggle the chevron icon
                const statusHeader = document.querySelector('[data-bs-toggle="collapse"]');
                const chevronIcon = statusHeader.querySelector('.bi-chevron-down');

                statusHeader.addEventListener('click', function() {
                    chevronIcon.style.transform = chevronIcon.style.transform === 'rotate(180deg)' ?
                        'rotate(0deg)' :
                        'rotate(180deg)';
                });
            });
        </script>
        <?= $this->endSection(); ?>

        <?= $this->section('style'); ?>
        <style>
            .bi-chevron-down {
                transition: transform 0.3s ease;
            }
        </style>
        <?= $this->endSection(); ?>