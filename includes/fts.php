<?php

class FuzzyTimeSeries
{
    public $data;
    public $u;
    public $jumlah_interval;
    public $lebar_interval;
    public $interval;
    public $fuzzifikasi;
    public $relationship;
    public $defuzzifikasi;
    public $prediksi;

    function __construct($data, $d1, $d2)
    {
        $this->data = $data;
        $this->u = array(
            min($data) - $d1,
            max($data) + $d2,
        );
        $this->jumlah_interval = 1 + 3.322 * log(count($data), 10);
        $this->lebar_interval = ($this->u[1] - $this->u[0]) / round($this->jumlah_interval);
        for ($a = 0; $a < ceil($this->jumlah_interval); $a++) {
            $bb = $this->u[0] + $a * $this->lebar_interval;
            $ba = $bb + $this->lebar_interval;
            $this->interval[$a + 1] = array($bb, $ba, ($ba + $bb) / 2);
        }
        $this->get_fuzzifikasi();
        $this->get_relationship();
        $this->get_defuzzifikasi();
        $this->get_prediksi();
        // dd($this);
    }

    function get_prediksi()
    {
        $this->prediksi = array();
        foreach ($this->defuzzifikasi as $key => $val) {
            asort($this->defuzzifikasi[$key]);
            $penyebut = count($val);
            $this->prediksi[$key] = 0;
            foreach ($val as $v) {
                $this->prediksi[$key] += 1 / $penyebut * $this->interval[$v][2];
            }
        }
    }

    function get_defuzzifikasi()
    {
        $this->defuzzifikasi = array();
        foreach ($this->relationship as $key => $val) {
            $this->defuzzifikasi[key($val)][] = current($val);
        }
        ksort($this->defuzzifikasi);
    }
    function get_relationship()
    {
        $this->relationship = array();
        $val = array_values($this->fuzzifikasi);
        $key = array_keys($this->fuzzifikasi);
        for ($a = 1; $a < count($val); $a++) {
            $this->relationship[$key[$a]][$val[$a - 1]] = $val[$a];
        }
    }

    function get_fuzzifikasi()
    {
        $this->fuzzifikasi = array();
        foreach ($this->data as $key => $val) {
            foreach ($this->interval as $k => $v) {
                if ($val >= $v[0]) {
                    $this->fuzzifikasi[$key] = $k;
                } else {
                    break;
                }
            }
        }
    }
}

function get_mape($data, $hasil)
{
    $arr = array();
    foreach ($hasil as $key => $val) {
        $arr[$key] = $data[$key] == 0 ? 0 : (abs($data[$key] - $val) / $data[$key]);
    }
    return $arr;
}

function get_hasil($defuzzifikasi, $prediksi)
{
    $arr = array();
    $keys = array_keys($defuzzifikasi);
    $arr1 = array_values($defuzzifikasi);
    for ($a = 1; $a < count($arr1); $a++) {
        $arr[$keys[$a]] = $prediksi[$arr1[$a - 1]];
    }
    return $arr;
}

function get_fuzzifikasi($data, $uod)
{
    $arr = array();
    foreach ($data as $key => $val) {
        foreach ($uod as $k => $v) {
            if ($val >= $v[0]) {
                $arr[$key] = $k;
            } else {
                break;
            }
        }
    }
    return $arr;
}

function get_f($f)
{
    global $defuzzifikasi;
    foreach ($defuzzifikasi as $key => $val) {
        if (in_array($f, $val))
            return $key;
    }
}
