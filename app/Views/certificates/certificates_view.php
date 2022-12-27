<!DOCTYPE html>
<html id="htmlContent">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF from View in CodeIgniter Example</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a35fe366cf.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>

    <!-- MomentJs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"
        integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <style media="all">
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap");

        body {
            padding: 0 26px;
        }

        h1 {
            font-size: 20px;
            line-height: 36px;
        }

        h2 {
            font-size: 12px;
            line-height: 36px;
        }

        h3 {
            font-size: 12px;
            line-height: 15.12px;
        }

        .content {
            padding: 0 13px;
        }

        .rtl {
            direction: rtl;
        }

        .bg-black {
            background-color: black;
            color: white;
        }

        .bg-green {
            background-color: #2F5B33;
            color: white;
        }

        .bg-light-green {
            background-color: #3FAB49;
            color: white;
        }

        .bold {
            font-weight: 800;
        }

        .col-25px {
            flex: 0 0 auto;
            width: 25px;
        }

        .text-right {
            text-align: right;
        }

        .container {
            background-image: url("/image/profile/A2.svg");
            width: 842px;
            height: 595px;
            position: relative;
        }

        .content-certificate {
            position: absolute;
            top: 200px;
            left: 55px;
        }

        .date-certificate {
            position: absolute;
            width: 140px;
            text-align: center;
            bottom: 25px;
            left: 55px;
        }
    </style>
    <div id="certificate" class="p-0">
        <div class="container">
            <div class="content-certificate">
                <h1>THIS CERTIFICATE IS PRESENTED TO</h1>
                <div id="detail-certificate">

                </div>
            </div>
            <div class="date-certificate" id="date">

            </div>
        </div>
    </div>
    <div id="raport">
        <h1 class="text-center bg-black bold">Laporan Pembelajaran</h1>
        <div class="row py-4">
            <div class="col-3">
                <h3>Nama Lengkap</h3>
                <h3>Enroll Date</h3>
                <h3>Course</h3>
                <h3>Status</h3>
            </div>
            <div class="col-25px">
                <h3>:</h3>
                <h3>:</h3>
                <h3>:</h3>
                <h3>:</h3>
            </div>
            <div class="col bold" id="biodata">
                <h3 id="nama_lengkap"></h3>
                <h3 id="enroll_date"></h3>
                <h3 id="course"></h3>
                <h3 id="status"></h3>
            </div>
        </div>
        <div class="content">
            <div class="row bg-green">
                <div class="col-3">
                    <h2>Pembelajaran</h2>
                </div>
                <div class="col-2">
                    <h2>Score</h2>
                </div>
                <div class="col">
                    <h2>Resume</h2>
                </div>
            </div>
        </div>
        <div id="video">
            <div class="row pt-4">
                <div class="col-3">
                    <h3>Perkenalan</h3>
                </div>
                <div class="col-2">
                    <h3>89</h3>
                </div>
                <div class="col">
                    <h3>Lorem ipsum dolor sit amet consectetur. Convallis integer id nibh leo et quam. Nulla lorem amet id
                        viverra blandit donec. Malesuada ut mauris ullamcorper interdum ut turpis eget.</h3>
                </div>
            </div>
        </div>
        <hr>
        <div class="content">
            <div class="row bg-light-green">
                <div class="col">
                    <h2 class="bold">Final Score</h2>
                </div>
                <div class="col text-right">
                    <h2 class="bold" id="final-score">100</h2>
                </div>
            </div>
        </div>
        <div class="row rtl">
            <div class="col-6">
                <h2 id="tanggal">Yogyakarta, 12 Desember 2022</h2>
                <img src="/image/profile/signature.svg" alt="">
                <h2>Stufast Learning Center</h2>
            </div>
        </div>
    </div>
    
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- js cookie -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script src="../../../js/api/certificate/index.js"></script>
</body>

</html>