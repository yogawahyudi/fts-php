<?php
$row = $db->get_row("SELECT * FROM tb_jenis WHERE kode_jenis='$_GET[ID]'");
?>
<div class="mb-3">
    <h1>Ubah Jenis</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if ($_POST) include 'aksi.php' ?>
        <form method="post">
            <div class="mb-3">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_jenis" readonly="readonly" value="<?= $row->kode_jenis ?>" />
            </div>
            <div class="mb-3">
                <label>Nama Jenis <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_jenis" value="<?= $row->nama_jenis ?>" />
            </div>
            <div class="mb-3">
                <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=jenis"><span class="fa fa-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>