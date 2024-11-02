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
        <div class="bg-white min-vh-100">
            <div class="container-fluid py-3 px-3">
                <!-- Breadcrumb -->
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="breadcrumb-links">
                            <a href="<?= base_url('incoming') ?>" class="text-decoration-none text-primary">Incoming Document(s)</a>
                            <span class="text-secondary mx-2">/</span>
                            <span class="text-secondary">Document View</span>
                        </div>
                        <button onclick="window.print(); return false;" class="btn btn-link text-dark p-0">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <!-- Document Header -->
                            <div class="bg-primary p-3">
                                <h5 class="text-center text-white mb-0">DOCUMENT CODE: <?= $document['doc_code'] ?></h5>
                            </div>

                            <!-- Sender Info -->
                            <div class="bg-white text-dark p-3">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                    <div class="dropdown mb-2 mb-md-0">
                                        <h6 class="mb-0 text-dark"><?= $document['sender'] ?></h6>
                                        <div class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                                            <small>to me</small>
                                        </div>
                                        <div class="dropdown-menu shadow-sm p-3" style="max-width: 100%; width: 320px;">
                                            <div class="mb-2">
                                                <strong class="fw-bold text-dark">From:</strong> <?= $document['sender'] ?>
                                            </div>
                                            <div class="mb-2">
                                                <strong class="fw-bold text-dark">To:</strong> <?= $document['recipient'] ?>
                                            </div>
                                            <div class="mb-2">
                                                <strong class="fw-bold text-dark">Date:</strong> <?= $document['created_at'] ?>
                                            </div>
                                            <div class="mb-2">
                                                <strong class="fw-bold text-dark">Subject:</strong> <?= $document['subject'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?= $document['date_of_letter'] ?></small>
                                </div>
                            </div>

                            <!-- Subject and Priority -->
                            <div class="bg-secondary text-white p-3">
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <?php if (!empty($document['qr_code'])) : ?>
                                        <div class="qr-code flex-shrink-0">
                                            <img src="<?= base_url('uploads/' . $document['qr_code']) ?>" alt="QR Code" class="img-fluid" style="width: 50px;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-2"><?= $document['subject'] ?>: <?= $document['description'] ?></h6>
                                        <?php if ($document['prioritization'] == 'Usual') : ?>
                                            <span class="badge bg-warning text-dark">Usual</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Urgent</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Details -->
                            <div class="card-body p-4">
                                <form>
                                    <!-- Details Section -->
                                    <div class="mb-4">
                                        <h5 class="bg-primary text-white p-2 mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Details
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label fw-bold">Required Action</label>
                                                <input type="text" name="action" class="form-control bg-white" value="<?= $document['action'] ?>" disabled>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label fw-bold">Deadline</label>
                                                <input type="text" name="deadline" class="form-control bg-white" value="<?= $document['deadline'] ?>" disabled>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea name="description" rows="4" class="form-control bg-white" disabled><?= $document['description'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Attachments Section -->
                                    <div class="mb-4">
                                        <h5 class="bg-primary text-white p-2 mb-3">
                                            <i class="bi bi-paperclip me-2"></i>Attachments
                                        </h5>
                                        <div class="border rounded p-3">
                                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                                    <span class="text-break"><?= !empty($document['original_name']) ? $document['original_name'] : 'File' ?></span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <a href="<?= base_url('view/file/' . $document['id']) ?>" class="btn btn-sm btn-primary" target="_blank">View</a>
                                                    <a href="<?= base_url($document['path']) ?>" class="btn btn-sm btn-warning">Download</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Section -->
                                    <div class="mb-4">
                                        <h5 class="bg-primary text-white p-2 mb-3">
                                            <i class="bi bi-check-circle me-2"></i>Action
                                        </h5>
                                        <div class="d-grid">
                                            <button class="btn btn-success">Receive?</button>
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