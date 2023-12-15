<div class="mb-3">
    <h1>Login</h1>
</div>
<div class="row">
    <div class="col-md-4">
        <?php if ($_POST) include 'aksi.php' ?>
        <form method="post">
            <div class="mb-3">
                <input class="form-control" type="text" placeholder="Username" name="user" focus />
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" placeholder="Password" name="pass" />
            </div>
            <div class="mb-3">
                <button class="btn btn-primary"><span class="fa fa-right-to-bracket"></span> Login</button>
            </div>
        </form>
    </div>
</div>