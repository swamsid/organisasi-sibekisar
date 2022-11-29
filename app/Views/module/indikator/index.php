<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Manajemen Aspek & Indikator </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Manajemen aspek & Indikator</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
    <div class="row page-form" style="display:none">
        <div class="col-xl-12 div-frmindikator">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Form Indikator</h4>
                    <?php  echo view('module/indikator/frmindikator') ?>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row page-content">
        <div class="col-xl-12 div-indikator">
            <div class="card">
                <div class="card-body">
                    <div class="row" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                        <div class="col-md-7">
                            <h4 class="mb-3 header-title">Spirit & Indikator</h4>
                        </div>

                        <div class="col-md-5 text-right">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="text-right" width="70%">
                                            <div class="input-group" style="margin-top: -5px;">
                                                <div class="input-group-prepend" style="height: 20px; margin-top: -1px;">
                                                    <span class="input-group-text" id="basic-addon1" style="color: #888;">Periode Indikator</span>
                                                </div>
                                                <select class="form-control" style="height: 30px; cursor: pointer;" id="periode-tahun-show">
                                                    
                                                </select>
                                            </div>
                                        </td>
                                        <td style="text-right">
                                            <button class="btn btn-primary" id="tambah-data" style="padding: 10px 15px; font-size: 8pt; margin-top: -5px;">
                                                Tambah Data
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive-sm mt-4">
                                <table id="indikator-datatable" class="table table-striped table-centered mb-0">
                                    <thead>
                                    <tr>
                                        <th>Spirit</th>
                                        <th>Bobot Spirit</th>
                                        <th>Indikator</th>
                                        <th>Bobot</th>
                                        <th>PD Pengampu</th>
                                        <th>Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>


