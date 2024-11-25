<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<div class="container-fluid position-relative d-flex p-0">
    <?= $this->include("partials/sidebar"); ?>
    
    <div class="content bg-white">
        <?= $this->include("partials/navbar"); ?>
        
        <div class="container-fluid pt-4 px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow bg-white">
                        <div class="card-header bg-light">
                            <h3 class="text-white mb-0 fs-4">All Documents</h3>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="row g-4">
                                <?php 
                                // Define an array of color schemes
                                $colorSchemes = [
                                    [
                                        'bg' => 'bg-primary bg-opacity-10',
                                        'border' => 'border-primary',
                                        'btn' => 'btn-primary'
                                    ],
                                    [
                                        'bg' => 'bg-success bg-opacity-10',
                                        'border' => 'border-success',
                                        'btn' => 'btn-success'
                                    ],
                                    [
                                        'bg' => 'bg-dark bg-opacity-10',
                                        'border' => 'border-dark',
                                        'btn' => 'btn-dark'
                                    ],
                                    [
                                        'bg' => 'bg-warning bg-opacity-10',
                                        'border' => 'border-warning',
                                        'btn' => 'btn-warning'
                                    ],
                                    [
                                        'bg' => 'bg-danger bg-opacity-10',
                                        'border' => 'border-danger',
                                        'btn' => 'btn-danger'
                                    ],
                                    [
                                        'bg' => 'bg-secondary bg-opacity-10',
                                        'border' => 'border-secondary',
                                        'btn' => 'btn-secondary'
                                    ]
                                ];
                                ?>
                                
                                <?php foreach ($barangays as $index => $brgy): ?>
                                <?php 
                                // Get color scheme for current card
                                $colorIndex = $index % count($colorSchemes);
                                $currentScheme = $colorSchemes[$colorIndex];
                                ?>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border <?= $currentScheme['border'] ?> <?= $currentScheme['bg'] ?>">
                                        <div class="card-body">
                                            <h5 class="card-title text-white">Barangay <?= esc($brgy['brgy']) ?></h5>
                                            <p class="card-text text-white">
                                                View all documents from Barangay <?= esc($brgy['brgy']) ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0">
                                            <a href="<?= base_url('barangay_documents/' . esc($brgy['brgy'])) ?>" 
                                               class="btn <?= $currentScheme['btn'] ?> w-100 text-white">
                                                <i class="bi bi-folder2-open me-2"></i>View Documents
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?= $this->endSection(); ?>