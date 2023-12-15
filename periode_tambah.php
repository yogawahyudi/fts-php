<div class="mb-3">
    <h1>Tambah Periode</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="mb-3">
                <label>Waktu <span class="text-danger">*</span></label>
                <input class="form-control" type="datetime-local" name="waktu" value="<?= set_value('waktu', date('Y-m-d H:i')) ?>" />
            </div>
            <?php foreach ($JENIS as $key => $val) : ?>
                <div class="mb-3">
                    <label><?= $val ?></label>
                    <input class="form-control" type="number" name="nilai[<?= $key ?>]" value="<?= isset($_POST['nilai'][$key]) ? $_POST['nilai'][$key] : '' ?>" step="0.01" />
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
        <a class="btn btn-danger" href="?m=periode"><span class="fa fa-arrow-left"></span> Kembali</a>
    </div>
</form>