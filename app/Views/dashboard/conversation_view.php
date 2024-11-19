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
                        <!-- Document Details -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h5 class="card-title mb-0">Document Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Document Code:</strong> <?= esc($document['doc_code']) ?></p>
                                        <p><strong>Subject:</strong> <?= esc($document['subject']) ?></p>
                                        <p><strong>Sender:</strong> <?= esc($document['sender']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Recipient:</strong> <?= esc($document['recipient']) ?></p>
                                        <p><strong>Date:</strong> <?= esc($document['date_of_letter']) ?></p>
                                        <p><strong>Status:</strong> <?= esc($document['status']) ?></p>
                                    </div>
                                </div>
                                <?php if ($document['path']) : ?>
                                    <div class="mt-2">
                                        <strong>Original Document:</strong>
                                        <a href="<?= base_url($document['path']) ?>" class="btn btn-sm btn-primary" target="_blank">
                                            View Document
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Conversation Thread -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h5 class="card-title mb-0">Conversation History</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($conversations)) : ?>
                                    <?php foreach ($conversations as $reply) : ?>
                                        <div class="mb-3 <?= ($reply['sender'] === session()->get('name')) ? 'text-end' : '' ?>">
                                            <div class="d-inline-block max-w-75 <?= ($reply['sender'] === session()->get('name')) ? 'bg-primary text-white' : 'bg-secondary' ?> rounded p-3">
                                                <div class="mb-1">
                                                    <strong><?= esc($reply['sender']) ?></strong>
                                                    <small class="text-muted ms-2">
                                                        <?= date('M d, Y H:i', strtotime($reply['created_at'])) ?>
                                                    </small>
                                                </div>
                                                <div class="message-content">
                                                    <?= nl2br(esc($reply['message'])) ?>
                                                </div>
                                                <?php if ($reply['attachment']) : ?>
                                                    <div class="mt-2">
                                                        <a href="<?= base_url($reply['attachment']) ?>" class="btn btn-sm btn-light" download="<?= $reply['original_name'] ?>">
                                                            <i class="bi bi-paperclip"></i>
                                                            <?= esc($reply['original_name']) ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center text-muted">No replies yet</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Reply Form -->
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h5 class="card-title mb-0">Send Reply</h5>
                            </div>
                            <div class="card-body">
                                <?php if (session()->getFlashdata('error')) : ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('success')) : ?>
                                    <div class="alert alert-success">
                                        <?= session()->getFlashdata('success') ?>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('reply/' . $document['id']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea id="message" name="message" rows="4" class="form-control bg-white" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="attachment" class="form-label">Attachment (optional)</label>
                                        <input type="file" id="attachment" name="attachment" class="form-control">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">
                                            Send Reply
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?= $this->endSection(); ?>