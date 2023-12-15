<?php
session_start();
include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/fts.php';

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

function br_to_enter($text)
{
    return str_replace("\r\n", '<br />', $text);
}

function kode_oto($field, $table, $prefix, $length)
{
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . (substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

$rows = $db->get_results("SELECT * FROM tb_periode ORDER BY id_periode");
foreach ($rows as $row) {
    $PERIODE[$row->id_periode] = $row->waktu;
}

$rows = $db->get_results("SELECT * FROM tb_jenis ORDER BY kode_jenis");
foreach ($rows as $row) {
    $JENIS[$row->kode_jenis] = $row->nama_jenis;
}

function get_jenis_option($selected = '')
{
    global $JENIS;
    $a = '';
    foreach ($JENIS as $key => $value) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_analisa()
{
    global $db;

    $rows = $db->get_results("SELECT * FROM tb_relasi r INNER JOIN tb_periode p ON p.id_periode=r.id_periode ORDER BY waktu, kode_jenis");

    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_jenis][$row->waktu] = $row->nilai;
    }
    return $arr;
}

function get_data()
{
    global $db, $PERIODE;

    $rows = $db->get_results("SELECT * 
    FROM tb_relasi r 
    ORDER BY id_periode, kode_jenis");

    $data = array();
    foreach ($rows as $row) {
        $data[$PERIODE[$row->id_periode]][$row->kode_jenis] = $row->nilai;
    }
    return $data;
}

function get_arr_next($next_periode, $min_periode, $max_periode)
{
    $arr = array();
    if ($next_periode < $min_periode) {
        for ($a = $next_periode; $a < $min_periode; $a++) {
            $arr[] = $a;
        }
    } else if ($next_periode > $max_periode) {
        for ($a = $max_periode + 1; $a <= $next_periode; $a++) {
            $arr[] = $a;
        }
    } else {
        $arr[] = $next_periode;
    }
    return $arr;
}

function get_arr_next_hasil($arr_next, $nilai_a, $nilai_b, $max_periode, $max_x)
{
    global $PERIODE;
    $arr = array();
    foreach ($nilai_a as $key => $val) {
        foreach ($arr_next as $k) {
            $a = $nilai_a[$key];
            $b = $nilai_b[$key];
            $x = count($PERIODE) % 2 == 0 ? ($k - $max_periode) * 2 + $max_x : ($k - $max_periode) + $max_x;
            $arr[$key][$k] = array(
                'a' => $a,
                'b' => $b,
                'x' => $x,
                'next' => $a + $b * $x,
            );
        }
    }
    return $arr;
}

function esc_field($str)
{
    return addslashes($str);
}

function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}

function alert($url)
{
    echo '<script type="text/javascript">alert("' . $url . '");</script>';
}

function print_msg($msg, $type = 'danger')
{
    echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        ' . $msg . '
    </div>';
}

function dd($arr)
{
    echo '<pre>' . print_r($arr, 1) . '</pre>';
}
