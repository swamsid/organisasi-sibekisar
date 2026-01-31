<?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=nilai_indikator_".$nmind."_tahun_".$nmthn.".xls");
?>

<style>
    #data-table{
        width: 100%;
        border-collapse: collapse;
    }

    #data-table th{
        font-weight: bold;
    }

    #data-table td,
    #data-table th{
        border: 1px solid #ccc;
    }
</style>

<table id="data-table">
    <thead>
        <tr>
            <th colspan="5" style="vertical-align: top; text-align: left; font-size: 16pt;">
                <strong><?= $nmind ?></strong>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="vertical-align: top; text-align: left; font-weight: normal;">
                Tahun <?= $nmthn ?>
            </th>
        </tr>
        <tr>
            <th colspan="5">&nbsp;</th>
        </tr>
        <tr>
            <th style="vertical-align: top; border: 1px solid #333;">Nama Perangkat Daerah</th>
            <th style="vertical-align: top; border: 1px solid #333;">Nilai Input</th>
            <th style="vertical-align: top; border: 1px solid #333;">Nilai Akhir</th>
            <th style="vertical-align: top; border: 1px solid #333;">Catatan</th>
            <th style="vertical-align: top; border: 1px solid #333;">Rekomendasi</th>
        </tr>
    </thead>

    <tbody>
        <?php 
            foreach($data as $key => $nilai){
        ?>
        
            <tr>
                <td style="vertical-align: top; border: 1px solid #333;"><?= $nilai->unit ?></td>
                <td style="vertical-align: top; text-align: center; border: 1px solid #333;"><?= $nilai->nilai_input ?></td>
                <td style="vertical-align: top; text-align: center; border: 1px solid #333;"><?= $nilai->nilai_akhir ?></td>
                <td style="vertical-align: top; border: 1px solid #333;"><?= ltrim(strip_tags($nilai->catatan_indikator)) ?></td>
                <td style="vertical-align: top; border: 1px solid #333;"><?= ltrim(strip_tags($nilai->rekomendasi_indikator)) ?></td>
            </tr>

        <?php } ?>
    </tbody>
</table>