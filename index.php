<?php
include 'functions.php';
//if(empty($_SESSION[login]))
//header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" />

    <title>Fuzzy Time Series PHP</title>
    <link href="assets/css/default-bootstrap.min.css" rel="stylesheet" />
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" />
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/highcharts.js"></script>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="?">Fuzzy Time Series</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (_session('login')) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=jenis"><span class="fa fa-th-large"></span> Jenis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=periode"><span class="fa fa-calendar"></span> Periode</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=hitung"><span class="fa fa-signal"></span> Perhitungan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=hasil"><span class="fa fa-chart-bar"></span> Hasil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=password"><span class="fa fa-lock"></span> Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aksi.php?act=logout"><span class="fa fa-right-from-bracket"></span> Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=hitung"><span class="fa fa-calendar"></span> Perhitungan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=tentang"><span class="fa fa-circle-info"></span> Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?m=login"><span class="fa fa-right-to-bracket"></span> Login</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-shrink-0">
        <div class="container my-4">
            <?php
            if (!_session('login') && !in_array($mod, array('', 'home', 'hitung', 'login', 'tentang')))
                $mod = 'login';

            if (file_exists($mod . '.php'))
                include $mod . '.php';
            else
                include 'home.php';
            ?>
        </div>
    </main>
    <footer class="mt-auto bg-primary text-light py-3">
        <div class="container">
            Copyright &copy; <?= date('Y') ?> RumahSourceCode.Com <em class="float-end">Updated 15 November 2023</em>
        </div>
    </footer>
    <script type="text/javascript">
        $('.form-control').attr('autocomplete', 'off');
    </script>
</body>

</html>