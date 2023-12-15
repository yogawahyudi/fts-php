<?php
$kode_jenis = set_value('kode_jenis');
$d1 = set_value('d1');
$d2 = set_value('d2');
$analisa = get_analisa();
$data = $analisa[$kode_jenis];
$fts = new FuzzyTimeSeries($data, $d1, $d2);
?>

<div class="card mb-3">
    <div class="card-header">
        <strong>Data</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($data as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= round($val) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" class="text-right">Semesta (U)</td>
                <td>[<?= round($fts->u[0]) ?>, <?= round($fts->u[1]) ?>]</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Jumlah Interval</td>
                <td><?= round($fts->jumlah_interval, 2) ?> &equiv; <?= round($fts->jumlah_interval) ?></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Lebar Interval</td>
                <td><?= round($fts->lebar_interval, 2) ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong>Interval</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>U</th>
                    <th>Batas Bawah</th>
                    <th>Batas Atas</th>
                    <th>Titik Tengah (m)</th>
                    <th>A</th>
                </tr>
            </thead>
            <?php foreach ($fts->interval as $key => $val) : ?>
                <tr>
                    <td>U<sub><?= $key ?></sub></td>
                    <td><?= round($val[0], 0) ?></td>
                    <td><?= round($val[1], 0) ?></td>
                    <td><?= round($val[2], 2) ?></td>
                    <td>A<sub><?= $key ?></sub></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong>Fuzzifikasi</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Fuzzifikasi</th>
                    <th>Relationship</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($data as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= round($val) ?></td>
                    <td>A<?= $fts->fuzzifikasi[$key] ?></td>
                    <td>
                        <?php if (isset($fts->relationship[$key])) : ?>
                            A<?= key((array) $fts->relationship[$key]) ?>=&gt;A<?= current((array) $fts->relationship[$key]) ?></td>
                <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <strong>Defuzzifikasi</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Current State</th>
                    <th>Next State</th>
                    <th>Perhitungan</th>
                    <th>Prediksi</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($fts->defuzzifikasi as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>A<?= $key ?></td>
                    <td>
                        <?php
                        $arr = array();
                        foreach ($val as $k => $v) {
                            $arr[] = 'A' . $v;
                        }
                        echo implode(', ', $arr);
                        ?>
                    </td>
                    <td><code>
                            <?php
                            $arr = array();
                            foreach ($val as $k => $v) {
                                $arr[] = '(1/' . count($val) . ')(' . round($fts->interval[$v][2]) . ')';
                            }
                            echo implode('+', $arr);
                            ?></code>
                    </td>
                    <td><?= round($fts->prediksi[$key], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header">
        <strong>Hasil Akhir</strong>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Jumlah</th>
                    <th>Prediksi</th>
                    <th>|A<sub>t</sub>-F<sub>t</sub>|</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            $hasil = get_hasil($fts->fuzzifikasi, $fts->prediksi);
            $mape = get_mape($data, $hasil);
            $mape_hasil = array_sum($mape) / count($mape);
            $categories = array();
            $series[] = array();
            foreach ($data as $key => $val) :
                $categories[$key] = $key;
                $series[0][$key] = $val * 1;
                $series[1][$key] = isset($hasil[$key]) ? round($hasil[$key], 2) : null;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $val ?></td>
                    <td><?= isset($hasil[$key]) ? round($hasil[$key], 2) : '' ?></td>
                    <td><?= isset($mape[$key]) ? (round($mape[$key] * 100, 2)) . '%'  : '' ?></td>
                </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="4" class="text-end">MAPE (Mean Absolute Percentage Error) = <code><?= round(array_sum($mape), 2) ?> / <?= round(count($mape), 2) ?> * 100% = </code></td>
                <td><?= round($mape_hasil * 100, 2) ?>%</td>
            </tr>
        </table>
    </div>
    <div class="card-body">
        <p>Peramalan <?= $next_periode ?> Bulan Berikutnya</p>
    </div>
    <div class="table-responsive">
        <?php
        $next = array();
        $max_periode = max(array_keys($data));

        $temp_current_state = end($fts->fuzzifikasi);

        $db->query("DELETE FROM tb_hasil WHERE kode_jenis='$kode_jenis'");
        for ($a = 1; $a <= $next_periode; $a++) {
            $key = date('Y-m-d H:i', strtotime($max_periode) + $a * $INTERVAL);
            $next[$key] = 0;
            $current_state[$key] = $temp_current_state;

            if (isset($fts->defuzzifikasi[$current_state[$key]])) { //jika ada next_statenya                      
                $temp_next_state = $fts->defuzzifikasi[$current_state[$key]];
                $next_state[$key] = $temp_next_state;
                $arr = array();
                foreach ($temp_next_state as $k => $v) {
                    $arr[] =  $fts->interval[$v][2];
                }
                $next[$key] = array_sum($arr) / count($arr);
            } else {
                $temp_next_state = $current_state[$key];
                $next_state[$key][] = $current_state[$key];
                $next[$key] =  $fts->interval[$temp_next_state][2];
            }

            $x = get_fuzzifikasi(array($next[$key]), $fts->interval);
            $temp_current_state = $x[0];
            $hasil[$key] = $next[$key];
            $categories[$key] = $key;
            $series[0][$key] = null;
            $series[1][$key] = round($next[$key], 2);

            $db->query("INSERT INTO tb_hasil (periode, kode_jenis, jumlah) VALUES ('$key', '$kode_jenis', '{$next[$key]}')");
        }

        ?>
        <table class="table table-bordered table-striped table-hover m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Current State</th>
                    <th>Next State</th>
                    <th>Peramalan</th>
                    <th>Keterangan</th>
                </tr>
                <?php
                $no = 1;
                foreach ($next as $key => $val) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $key ?></td>
                        <td>A<?= $current_state[$key] ?></td>
                        <td>A[<?= implode(', ', $next_state[$key]) ?>]</td>
                        <td><?= round($next[$key], 2) ?></td>
                        <td><?= $next[$key] >= $MIN_YA ? 'Ya' : 'Tidak' ?></td>
                    </tr>
                <?php endforeach ?>
            </thead>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header with-border">
        <strong>Grafik</strong>
    </div>
    <div class="card-body">
        <div id="chart1"></div>
    </div>
</div>
<style>
    .highcharts-credits {
        display: none;
    }
</style>
<script>
    Highcharts.chart('chart1', {
        title: {
            text: 'Hasil Peramalan'
        },
        xAxis: {
            categories: <?= json_encode(array_values($categories)) ?>
        },

        yAxis: {
            title: {
                text: 'Total'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
            }
        },

        series: [{
            name: 'Aktual',
            data: <?= json_encode(array_values($series[0])) ?>
        }, {
            name: 'Prediksi',
            data: <?= json_encode(array_values($series[1])) ?>
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>