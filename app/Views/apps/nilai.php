<style>
    body{
        font-size: 9pt !important;
    }

    .table-responsive{
        padding-bottom: 20px;
    }

    .dataTables_wrapper select,
    .dataTables_filter label input{
        height: 30px !important;
    }

    .dataTables_scroll .dataTables_scrollHead th{
        padding: 10px;
        border: 0px solid #eee;
    }

    .dataTables_scroll .dataTables_scrollHead th.grey{
        background: #f5f5f5;
    }

    .dataTable thead > tr > th.sorting{
        padding-right: 10px !important;
    }

    .btn-table{
        padding: 10px 15px;
        font-size: 8pt;
    }

    #main-table{
        font-size: 9pt !important;
        border-collapse: collapse;
        table-layout: fixed;
        width: 130%;
    }

    #main-table tr td,
    #main-table tr th{
        border: 1px solid #eee;
        padding: 10px;
    }

    #main-table tr th{
        background: #eee;
    }
</style>

<div class="content-wrapper">
    <div class="card" id="divDataEvaluasi">
        <div class="card-body" >
            <div class="row">
                <div class="col-md-8">
                    <h4 class="card-title">Rekap Nilai <?php echo $label ?></h4>
                </div>
                <div class="col-md-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="text-align: right; border: 0px !important; margin-top: -10px;">
                            <li class="breadcrumb-item"><a href="#">Rekap Nilai <?php echo $label ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <input type="hidden" id="tmp-indikator" value="<?php echo (isset($id_indikator)?$id_indikator:'') ?>">
            <input type="hidden" id="tag" value="<?php echo (isset($tag) ? $tag : 'opd') ?>" readonly>
            
            <div class="row">
                <div class="col-12">
                    <blockquote class="blockquote blockquote-primary">
                        <form id="frmsearch" class="forms-sample form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tahun Periode</label>
                                    <select name="tahun" class="form-control" id="tahun">
                                        <option value="null" disabled selected>Pilih Periode</option>
                                        <?php
                                        foreach($periode as $key => $p ){
                                            echo '<option value="'.$p->id_periode.'">'.$p->tahun_periode.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-8 text-right" style="padding-top: 40px;">
                                    <div id="export-button" style="display: none;">
                                        <button class="btn btn-dark btn-table" onclick="exportExcel()">Export Excel</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </blockquote>
                    <div class="row" id="divFormEvaluasi">
                        <div class="col-md-12">
                             <div class="table-responsive" id="div-spirit" style="margin-top: 20px; width: 100%;">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>