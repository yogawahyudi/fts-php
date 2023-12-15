<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" />

    <title>Source Code Forecasting EMA</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" />
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-secondary h-100">
    <div class="container d-flex h-100">
        <div class="row align-items-center w-100">
            <div class="col-md-4 mx-auto">
                <form method="POST" action="?m=login">
                    <div class="card ">
                        <div class="card-header">
                            <strong>Silakan Login</strong>
                        </div>
                        <div class="card-body">
                            <?php if ($_POST) include 'aksi.php' ?>
                            <div class="mb-3">
                                <input class="form-control" type="text" placeholder="Username" name="user" focus />
                            </div>
                            <div>
                                <input class="form-control" type="password" placeholder="Password" name="pass" />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary"><span class="fa fa-right-to-bracket"></span> Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>