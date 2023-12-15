<?php
$row = $db->get_row("SELECT * FROM tb_periode WHERE id_periode='$_GET[ID]'");
?>
<div class="mb-3">
    <h1>Ubah Periode</h1>
</div>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="mb-3">
                <label>Waktu <span class="text-danger">*</span></label>
                <input class="form-control" type="datetime-local" name="waktu" value="<?= set_value('waktu', $row->waktu) ?>" step="0.01" />
            </div>
            <?php
            $rows = $db->get_results("SELECT * FROM tb_relasi r 
                INNER JOIN tb_jenis k ON k.kode_jenis=r.kode_jenis
            WHERE id_periode='$row->id_periode' ORDER BY r.kode_jenis");
            foreach ($rows as $row) : ?>
                <div class="mb-3">
                    <label><?= $row->nama_jenis ?></label>
                    <input type="number" class="form-control" name="nilai[<?= $row->ID ?>]" value="<?= $row->nilai ?>" />
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
        <a class="btn btn-danger" href="?m=periode"><span class="fa fa-arrow-left"></span> Kembali</a>
    </div>
</form>