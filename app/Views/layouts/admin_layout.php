<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/argon-dashboard/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/argon-dashboard/assets/img/favicon.png">
    <title>
        <?= $title ?>
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/argon-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/argon-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a35fe366cf.js" crossorigin="anonymous"></script>
    <script src="/js/library/jwt_decode.js"></script>
    <link href="/argon-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- CSS Files -->
    <link id="pagestyle" href="/argon-dashboard/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <!-- mystyle -->
    <link rel="stylesheet" href="../../../style/app_layout.css">
    <link rel="stylesheet" href="/style/admin.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>
    <!-- Moment Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?= $this->renderSection('css-component') ?>
</head>

<body class="g-sidenav-show   bg-gray-100">
    <?php helper("cookie"); ?>
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php echo $this->include('components/admin/sidebar.php') ?>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <?php echo $this->include('components/admin/navbar.php') ?>
        <!-- End Navbar -->
        <?= $this->renderSection('app-component') ?>
    </main>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/livequery/1.1.1/jquery.livequery.js"></script> -->
    <script src="/js/library/jquery.livequery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- sweetalert -->
    <!-- js cookie -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <!--   Core JS Files   -->
    <script src="/argon-dashboard/assets/js/core/popper.min.js"></script>
    <script src="/argon-dashboard/assets/js/core/bootstrap.min.js"></script>
    <script src="/argon-dashboard/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/argon-dashboard/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/argon-dashboard/assets/js/plugins/chartjs.min.js"></script>
    <script src="https://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- myscript -->
    <script src="../../../js/utils/textTruncate.js"></script>
    <script src="../../../js/home/home.js"></script>
    <script src="../../../js/home/notification.js"></script>
    <script src="../../../js/home/profile.js"></script>
    <script src="../../../js/library/fileinput.js"></script>
    <script>
        // var ctx1 = document.getElementById("chart-line").getContext("2d");

        // var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        // gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        // gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        // gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        // new Chart(ctx1, {
        //     type: "line",
        //     data: {
        //         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //         datasets: [{
        //             label: "Mobile apps",
        //             tension: 0.4,
        //             borderWidth: 0,
        //             pointRadius: 0,
        //             borderColor: "#5e72e4",
        //             backgroundColor: gradientStroke1,
        //             borderWidth: 3,
        //             fill: true,
        //             data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        //             maxBarThickness: 6

        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     padding: 10,
        //                     color: '#fbfbfb',
        //                     font: {
        //                         size: 11,
        //                         family: "Open Sans",
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#ccc',
        //                     padding: 20,
        //                     font: {
        //                         size: 11,
        //                         family: "Open Sans",
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/argon-dashboard/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->renderSection('js-component') ?>
</body>

</html>