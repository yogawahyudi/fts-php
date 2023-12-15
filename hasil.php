<div class="mb-3">
    <h1>Rekap Hasil Perhitungan</h1>
</div>
<div class="card mb-3">
    <div class="card-header">
        <strong>Data</strong>
    </div>
    <div class=table-responsive">
        <table class="table table-bordered table-hover table-striped m-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <?php foreach ($JENIS as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            $db->query("DELETE FROM tb_hasil WHERE kode_jenis NOT IN (SELECT kode_jenis FROM tb_jenis)");
            $rows = $db->get_results("SELECT * FROM tb_hasil ORDER BY periode, kode_jenis");
            $arr = array();
            $kolom = array();
            $categories = array();
            $series = array();
            foreach ($rows as $row) {
                $arr[$row->periode][$row->kode_jenis] = $row->jumlah;
                $kolom[$row->kode_jenis] = $row->kode_jenis;
                $categories[$row->periode] = $key;
                $series[$row->kode_jenis]['name'] = $JENIS[$row->kode_jenis];
                $series[$row->kode_jenis]['data'][$row->periode] = $row->jumlah * 1;
            }
            foreach ($series as $key => $val) {
                $series[$key]['data'] = array_values($val['data']);
            }
            $no = 0;
            foreach ($arr as $key => $val) :  ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $key ?></td>
                    <?php foreach ($kolom as $k => $v) : ?>
                        <td><?= round(isset($val[$k]) ? $val[$k] : 0) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="card">
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
            text: 'Grafik Hasil Peramalan'
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

        series: <?= json_encode(array_values($series)) ?>,

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