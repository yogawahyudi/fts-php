<div class="mb-3">
    <h1>Periode</h1>
</div>
<div class="card panel-default">
    <div class="card-header">
        <form class="row g-1 align-items-center">
            <input type="hidden" name="m" value="periode" />
            <div class="col-auto">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= _get('q') ?>" />
            </div>
            <div class="col-auto">
                <button class="btn btn-success"><span class="fa fa-refresh"></span> Refresh</button>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="?m=periode_tambah"><span class="fa fa-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <?php foreach ($JENIS as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field(_get('q'));
            $rows = $db->get_results("SELECT * FROM tb_periode WHERE waktu LIKE '%$q%' ORDER BY id_periode");
            $no = 0;
            $analisa = get_data();
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->id_periode ?></td>
                    <td><?= $row->waktu ?></td>
                    <?php foreach ($analisa[$PERIODE[$row->id_periode]] as $k => $v) : ?>
                        <td><?= $v ?></td>
                    <?php endforeach ?>
                    <td>
                        <a class="btn btn-sm btn-warning" href="?m=periode_ubah&ID=<?= $row->id_periode ?>"><span class="fa fa-edit"></span></a>
                        <a class="btn btn-sm btn-danger" href="aksi.php?act=periode_hapus&ID=<?= $row->id_periode ?>" onclick="return confirm('Hapus data?')"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>