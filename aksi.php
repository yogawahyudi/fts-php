<?php
require_once 'functions.php';

/** LOGIN */
if ($mod == 'login') {
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$user' AND user='$pass'");
    if ($row) {
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else {
        print_msg("Salah kombinasi username dan password.");
    }
} elseif ($act == 'logout') {
    unset($_SESSION['login']);
    header("location:index.php?m=login");
} else if ($mod == 'password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $row = $db->get_row("SELECT * FROM tb_user WHERE user='$_SESSION[login]' AND pass='$pass1'");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '')
        print_msg('Field bertanda * harus diisi.');
    elseif (!$row)
        print_msg('Password lama salah.');
    elseif ($pass2 != $pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else {
        $db->query("UPDATE tb_user SET pass='$pass2' WHERE user='$_SESSION[login]'");
        print_msg('Password berhasil diubah.', 'success');
    }
}

/** periode */
elseif ($mod == 'periode_tambah') {
    $waktu = $_POST['waktu'];
    if ($waktu == '')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif ($db->get_row("SELECT * FROM tb_periode WHERE waktu='$waktu'"))
        print_msg("waktu sudah ada!");
    else {
        $db->query("INSERT INTO tb_periode (waktu) VALUES ('$waktu')");
        $id_periode = $db->insert_id;
        foreach ($_POST['nilai'] as $key => $val) {
            $db->query("INSERT INTO tb_relasi(id_periode, kode_jenis, nilai) VALUES ('$id_periode', '$key', '$val')");
        }
        redirect_js("index.php?m=periode");
    }
} else if ($mod == 'periode_ubah') {
    $waktu = $_POST['waktu'];
    if ($waktu == '')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_periode SET waktu='$waktu' WHERE id_periode='$_GET[ID]'");
        foreach ($_POST['nilai'] as $key => $val) {
            $db->query("UPDATE tb_relasi SET nilai='$val' WHERE id='$key'");
        }
        redirect_js("index.php?m=periode");
    }
} else if ($act == 'periode_hapus') {
    $id_periode = $_GET['ID'];
    $db->query("DELETE FROM tb_periode WHERE id_periode='$id_periode'");
    $db->query("DELETE FROM tb_relasi WHERE id_periode='$id_periode'");
    header("location:index.php?m=periode");
}

/** jenis */
elseif ($mod == 'jenis_tambah') {
    $kode_jenis = $_POST['kode_jenis'];
    $nama_jenis = $_POST['nama_jenis'];

    if ($kode_jenis == '' || $nama_jenis == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM tb_jenis WHERE kode_jenis='$kode_jenis'"))
        print_msg("Kode sudah ada!");
    else {
        $db->query("INSERT INTO tb_jenis (kode_jenis, nama_jenis) VALUES ('$kode_jenis', '$nama_jenis')");
        $db->query("INSERT INTO tb_relasi(id_periode, kode_jenis) SELECT id_periode, '$kode_jenis'  FROM tb_periode");
        redirect_js("index.php?m=jenis");
    }
} else if ($mod == 'jenis_ubah') {
    $kode_jenis = $_POST['kode_jenis'];
    $nama_jenis = $_POST['nama_jenis'];

    if ($kode_jenis == '' || $nama_jenis == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_jenis SET nama_jenis='$nama_jenis' WHERE kode_jenis='$_GET[ID]'");
        redirect_js("index.php?m=jenis");
    }
} else if ($act == 'jenis_hapus') {
    $db->query("DELETE FROM tb_jenis WHERE kode_jenis='$_GET[ID]'");
    $db->query("DELETE FROM tb_relasi WHERE kode_jenis='$_GET[ID]'");
    header("location:index.php?m=jenis");
}
