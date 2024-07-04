<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Optimal Internet Explorer compatibility -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>LAR Hunger Games</title>

    <!-- Favicon  -->
    <link rel="icon" href="assets/img/server-icon-96.png">

    <!-- ***** All CSS Files ***** -->

    <!-- Style css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">


    <!-- jQuery(necessary for all JavaScript plugins) -->
    <script src="assets/js/vendor/jquery.min.js"></script>

    <script src="config.js"></script>

    <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
</head>

<body>
    <!--====== Preloader Area Start ======-->
    <div id="gameon-preloader" class="gameon-preloader">
        <!-- Preloader Animation -->
        <div class="preloader-animation">
            <!-- Spinner -->
            <div class="spinner"></div>
            <p class="fw-5 text-center text-uppercase">Loading</p>
        </div>
        <!-- Loader Animation -->
        <div class="loader-animation">
            <div class="row h-100">
                <!-- Single Loader -->
                <div class="col-3 single-loader p-0">
                    <div class="loader-bg"></div>
                </div>
                <!-- Single Loader -->
                <div class="col-3 single-loader p-0">
                    <div class="loader-bg"></div>
                </div>
                <!-- Single Loader -->
                <div class="col-3 single-loader p-0">
                    <div class="loader-bg"></div>
                </div>
                <!-- Single Loader -->
                <div class="col-3 single-loader p-0">
                    <div class="loader-bg"></div>
                </div>
            </div>
        </div>
    </div>
    <!--====== Preloader Area End ======-->

    <div class="main">

        <?php include 'components/header.php'; ?>
        <?php include 'components/server_status_banner.php'; ?>
        <?php include 'components/leaderboard.php'; ?>

        <?php include 'components/premium_banner.php'; ?>

        <?php #include 'components/kits.php'; 
        ?>

        <?php include 'components/footer.php'; ?>

        <?php include 'components/mobile_menu_modal.php'; ?>
        <?php include 'components/premium_modal.php'; ?>

        <!--====== Modal Responsive Menu Area Start ======-->
        <div id="menu" class="modal fade p-0">
            <div class="modal-dialog dialog-animated">
                <div class="modal-content h-100">
                    <div class="modal-header" data-dismiss="modal">
                        Menu <i class="far fa-times-circle icon-close"></i>
                    </div>
                    <div class="menu modal-body">
                        <div class="row w-100">
                            <div class="items p-0 col-12 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== Modal Responsive Menu Area End ======-->

    </div>



    <!-- ***** All jQuery Plugins ***** -->
    <!-- Bootstrap js -->
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="assets/js/vendor/bootstrap.min.js"></script>

    <!-- Plugins js -->
    <script src="assets/js/vendor/all.min.js"></script>
    <script src="assets/js/vendor/gallery.min.js"></script>
    <script src="assets/js/vendor/slider.min.js"></script>
    <script src="assets/js/vendor/countdown.min.js"></script>
    <script src="assets/js/vendor/shuffle.min.js"></script>

    <!-- Active js -->
    <script src="assets/js/main.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>