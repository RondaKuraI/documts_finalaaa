<!-- app/Views/dashboard/file_viewer.php -->
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

        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">Viewing: <?= esc($fileName) ?></h5>
                            <div>
                                <!-- <a href="<?= base_url($document['path']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-download"></i> Download
                                </a> -->
                                <a href="<?= base_url('incoming_doc_view/' . $document['id']) ?>" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0" style="height: 80vh;">
                            <?php if (in_array($fileType, ['doc', 'docx'])): ?>
                                <!-- Use Google Docs Viewer -->
                                <iframe
                                    src="https://docs.google.com/gview?url=<?= urlencode($fileUrl) ?>&embedded=true"
                                    style="width: 100%; height: 100%;"
                                    frameborder="0">
                                </iframe>

                                <!-- Fallback message if viewer fails -->
                                <div id="viewerFallback" class="p-4 text-center" style="display: none;">
                                    <p>Unable to load document viewer. Please try the following options:</p>
                                    <div class="mt-3">
                                        <a href="<?= base_url($document['path']) ?>" class="btn btn-primary me-2">
                                            Download Document
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="p-4 text-center">
                                    <p>This file type cannot be previewed. Please download the file to view it.</p>
                                    <a href="<?= base_url($document['path']) ?>" class="btn btn-primary">
                                        Download Document
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h1>
                    <a href="<?= base_url('document/versions/' . $document['id']) ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-document"></i> View Versions
                    </a>
                </h1>
                <h1>
                    <a href="<?= base_url('document/update-form/' . $document['id']) ?>" class="btn btn-success btn-sm">
                        <i class="fa fa-document"></i> Update Document
                    </a>
                </h1>
            </div>
        </div>
    </div>
</div>

<script>
    // Add error handling for the iframe
    document.querySelector('iframe').onload = function() {
        // Check if the iframe loaded successfully
        try {
            setTimeout(function() {
                if (document.querySelector('iframe').contentDocument.body.innerHTML === '') {
                    document.querySelector('#viewerFallback').style.display = 'block';
                    document.querySelector('iframe').style.display = 'none';
                }
            }, 2000);
        } catch (e) {
            // If there's an error accessing the iframe content, show fallback
            document.querySelector('#viewerFallback').style.display = 'block';
            document.querySelector('iframe').style.display = 'none';
        }
    };
</script>

<?= $this->endSection(); ?>