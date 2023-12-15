<div class="mb-3">
    <h1>Perhitungan Fuzzy Time Series</h1>
</div>
<?php
$success = false;

if ($_POST) {
    $next_periode = $_POST['next_periode'];
    if ($next_periode == '') {
        print_msg('Isikan next periode');
    } elseif ($next_periode < 1) {
        print_msg('Masukkan periode minimal 1');
    } else {
        $success = true;
    }
    $_SESSION['POST'] = $_POST;
}
?>
<form method="post">
    <div class="card mb-3">
        <div class="card-header">
            Masukkan periode
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label>Jenis <span class="text-danger">*</span></label>
                        <select class="form-select" name="kode_jenis">
                            <?= get_jenis_option(set_value('kode_jenis')) ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>D1 <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" name="d1" value="<?= set_value('d1', 0) ?>" />
                    </div>
                    <div class="mb-3">
                        <label>D2 <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" name="d2" value="<?= set_value('d2', 1) ?>" />
                    </div>
                    <div class="mb-3">
                        <label>Periode Peramalan Berikutnya <span class="text-danger">*</span></label>
                        <input class="form-control" type="number" name="next_periode" value="<?= set_value('next_periode', 3) ?>" />
                    </div>
                    <button class="btn btn-primary"><span class="fa fa-signal"></span> Hitung</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
if ($success)
    include 'hitung_hasil.php';
