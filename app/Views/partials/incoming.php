<div class="container-fluid pt-4 px-4">
    <div class="shadow bg-white text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0 text-dark">Incoming Documents</h6>
            <a href="<?= base_url('incoming'); ?>">Show All</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="">
                        <th>Doc. Code</th>
                        <th>Sender</th>
                        <th>Details</th>
                        <th>Required Action</th>
                        <th>Date of Letter</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="7" class="p-1 text-center">No records found</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>