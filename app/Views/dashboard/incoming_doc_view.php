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
                                                <strong class="fw-bold text-dark">Date:</strong> <?= date('M d, Y h:i a', strtotime($document['created_at'])) ?>
                                            </div>
                                            <div class="mb-2">
                                                <strong class="fw-bold text-dark">Subject:</strong> <?= $document['subject'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?= date('M d, Y h:i a', strtotime($document['created_at'])) ?></small>
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
                                                <input type="text" name="deadline" class="form-control bg-white" value="<?= date('M d, Y', strtotime($document['deadline'])) ?>" disabled>
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
                                                <div class="d-flex gap-2 attachment-buttons">
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
                                            <?php if ($document['status'] === 'pending') : ?>
                                                <button type="button" class="btn btn-success" id="receiveBtn" data-document-id="<?= $document['id'] ?>">Receive?</button>
                                            <?php elseif ($document['status'] === 'received') : ?>
                                                <div class="received-status">
                                                    <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                                        Document Received on <?= date('M d, Y h:i a', strtotime($document['updated_at'])) ?>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-outline-success flex-grow-1" id="confirmBtn" data-document-id="<?= $document['id'] ?>">Confirm?</button>
                                                        <!-- <button type="button" class="btn btn-danger flex-grow-1" id="disconfirmBtn" data-document-id="<?= $document['id'] ?>">Disconfirm?</button> -->
                                                    </div>
                                                </div>
                                            <?php elseif ($document['status'] === 'confirmed') : ?>
                                                <div>
                                                    <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                                        Document Received on <?= date('M d, Y h:i a', strtotime($document['updated_at'])) ?>
                                                    </div>
                                                    <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                                        Document confirmed on <?= date('M d, Y h:i a', strtotime($document['confirmed_at'])) ?>
                                                    </div>
                                                    <div class="alert alert-danger py-1 px-2 mb-2 text-center">
                                                        <i class="bi bi-check-circle me-2"></i>Ended
                                                    </div>
                                                </div>
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

        <?= $this->section("scripts"); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initially hide the attachment buttons if status is pending
                const attachmentButtons = document.querySelectorAll('.attachment-buttons');
                <?php if ($document['status'] === 'pending') : ?>
                    attachmentButtons.forEach(button => {
                        button.style.display = 'none';
                    });
                <?php endif; ?>

                // Add click handler for receive button
                const receiveBtn = document.getElementById('receiveBtn');
                if (receiveBtn) {
                    receiveBtn.addEventListener('click', function() {
                        const documentId = this.getAttribute('data-document-id');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You want to receive this document?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, receive it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateDocumentStatus(documentId, 'received');
                            }
                        });
                    });
                }

                // Add handlers for confirm/disconfirm buttons
                document.addEventListener('click', function(e) {
                    if (e.target.id === 'confirmBtn') {
                        const documentId = e.target.getAttribute('data-document-id');
                        Swal.fire({
                            title: 'Confirm Document?',
                            text: 'Are you sure you want to confirm this document?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, confirm it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                updateDocumentStatus(documentId, 'confirmed');
                            }
                        });
                    } else if (e.target.id === 'disconfirmBtn') {
                        const documentId = e.target.getAttribute('data-document-id');
                        // Handle disconfirm action if needed
                    }
                });

                // Function to update document status
                function updateDocumentStatus(documentId, status) {
                    fetch('<?= base_url('update-status') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                            },
                            body: JSON.stringify({
                                document_id: documentId,
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show the attachment buttons
                                attachmentButtons.forEach(button => {
                                    button.style.display = 'flex';
                                });

                                // Update the UI based on the status
                                const actionSection = document.querySelector('.d-grid');
                                if (status === 'received') {
                                    actionSection.innerHTML = `
                        <div class="received-status">
                            <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                Document Received on ${data.timestamp}
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary flex-grow-1" id="confirmBtn" data-document-id="${documentId}">Confirm?</button>
                            </div>
                        </div>
                    `;
                                } else if (status === 'confirmed') {
                                    actionSection.innerHTML = `
                        <div>
                            <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                Document Received on ${data.received_timestamp}
                            </div>
                            <div class="alert alert-success py-1 px-2 mb-2 text-center">
                                Document confirmed on ${data.timestamp}
                            </div>
                            <div class="alert alert-danger py-1 px-2 mb-2 text-center">
                                <i class="bi bi-check-circle me-2"></i>Ended
                            </div>
                        </div>
                    `;
                                }

                                // Show success message
                                Swal.fire(
                                    status === 'received' ? 'Received!' : 'Document Confirmed!',
                                    `Document has been ${status === 'confirmed' ? 'ended' : status} successfully.`,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || `Failed to update document status to ${status}.`,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'An unexpected error occurred.',
                                'error'
                            );
                        });
                }
            });
        </script>
        <?= $this->endSection(); ?>