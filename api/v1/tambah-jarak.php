<?php
    header('Content-Type: application/json');
    require_once "../../functions.php";
    date_default_timezone_set('Asia/Jakarta');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validasi dan sanitasi data input
        $kode_jenis = isset($_POST["kode_jenis"]) ? $_POST["kode_jenis"] : null;
        $jarak = isset($_POST["jarak"]) ? $_POST["jarak"] : null;

        if (!$kode_jenis || !$jarak) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter tidak lengkap'
            ]);
            exit;
        }

        // Memperoleh timestamp
        $timestamp = time();
        $date = date('Y-m-d H:i:s', $timestamp);

        try {
            // Menyimpan data ke dalam tabel tb_periode
            $db->query("INSERT INTO tb_periode (waktu) VALUES ('$date')");
            $id_periode = $db->insert_id;

            // Menjalankan query untuk memeriksa keberadaan kode_jenis
            $checkJenis = $db->get_var("SELECT * FROM tb_jenis WHERE kode_jenis='$kode_jenis'");
            if (!$checkJenis) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Kode tidak ditemukan'
                ]);
                exit;
            }

            // Menyimpan data ke dalam tabel tb_relasi
            $db->query("INSERT INTO tb_relasi(id_periode, kode_jenis, nilai) VALUES ('$id_periode', '$kode_jenis', '$jarak')");

            // Mengembalikan respons JSON
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan ke database'
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
        
        // Menutup prepared statement dan koneksi
        exit;
    }

    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Halaman tidak ditemukan'
    ]);
?>
