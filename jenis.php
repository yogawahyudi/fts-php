<div class="mb-3">
    <h1>Jenis</h1>
</div>
<div class="card panel-default">
    <div class="card-header">
        <form class="row g-1 align-items-center">
            <input type="hidden" name="m" value="jenis" />
            <div class="col-auto">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= _get('q') ?>" />
            </div>
            <div class="col-auto">
                <button class="btn btn-success"><span class="fa fa-refresh"></span> Refresh</button>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="?m=jenis_tambah"><span class="fa fa-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover table-striped m-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Jenis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $q = esc_field(_get('q'));
        $rows = $db->get_results("SELECT * FROM tb_jenis WHERE nama_jenis LIKE '%$q%' ORDER BY kode_jenis");
        $no = 0;
        foreach ($rows as $row) : ?>
            <tr>
                <td><?= $row->kode_jenis ?></td>
                <td><?= $row->nama_jenis ?></td>
                <td>
                    <a class="btn btn-sm btn-warning" href="?m=jenis_ubah&ID=<?= $row->kode_jenis ?>"><span class="fa fa-edit"></span></a>
                    <a class="btn btn-sm btn-danger" href="aksi.php?act=jenis_hapus&ID=<?= $row->kode_jenis ?>" onclick="return confirm('Hapus data?')"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>