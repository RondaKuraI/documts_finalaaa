<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-GovDocs</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url(); ?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url(); ?>css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Responsive -->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?= $this->renderSection("content"); ?>

    <!-- Footer Start -->
    <div class="container-fluid pt-4 px-4 bg-white">
        <div class="bg-white rounded-top p-4">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-start">
                    &copy; <a href="#">E-GovDocs</a>, All Right Reserved.
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-end">
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    </div>
    <!-- Content End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="<?= base_url('js/jquery-3.5.1.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>lib/chart/chart.min.js"></script>
    <!-- ChartJS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>js/chart.min.js"></script> -->

    <script src="<?= base_url(); ?>lib/easing/easing.min.js"></script>
    <script src="<?= base_url(); ?>lib/waypoints/waypoints.min.js"></script>
    <script src="<?= base_url(); ?>lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?= base_url(); ?>lib/tempusdominus/js/moment.min.js"></script>
    <script src="<?= base_url(); ?>lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="<?= base_url(); ?>lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Template Javascript -->
    <script src="<?= base_url(); ?>js/main.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success('Current position : ' + alertify.get('notifier', 'position'));
        });
    </script> -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>



    <?= $this->renderSection("scripts"); ?>

</body>

</html>