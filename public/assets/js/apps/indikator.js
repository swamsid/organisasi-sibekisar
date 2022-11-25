$(document).ready(function (){
    $(".select2").select2();
    var tabindikator = {
        init: function () {
            $(".page-form").hide();
            $(".page-content").show();
            var param = {
                "responsive": true,
                "sAjaxSource": base_url + "/module/master/gridindikator?tag="+$('#tag').val(),
                "aoColumns": [

                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.aspek;
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.nilai_maks;
                        }
                    },

                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.indikator +
                                (row.is_aktif==1?' <span class="badge badge-success">Aktif</span>':' <span class="badge badge-warning">Non Aktif</span>' );
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.bobot;
                        }
                    },
                    { //Level
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return row.opd_pengampu;
                        }
                    },

                    {
                        "mData": null,
                        "mRender": function (data, type, row) {
                            return "<button class='btn btn-primary btn btn-sm btn-icon btn-pure btn-edit'><i class='icon-note'></i></button> ";
                        }
                    }
                ],
                dom: 'Bfrtip',
                width:'100%',
                responsive:true,
                buttons: [
                    {
                        text: 'Tambah',
                        action: function (e, dt, node, config) {
                            $(".page-form #formindikator")[0].reset();
                            $(".page-content").slideUp();
                            $(".page-form").fadeIn();
                        }
                    }
                ],
                "fnDrawCallback": function (oSettings) {

                }
            };
            var oTable = $("#indikator-datatable").DataTable(param);


            $(document).on('click', '#formindikator .btn-cancel', function () {
                $(".page-form #formindikator")[0].reset();
                $(".page-form").hide();
                $(".page-content").fadeIn();
            });

            $(document).on('click', '#indikator-datatable .btn-edit', function () {
                // var aData = oTable.row(this).data();
                var aData = oTable.row($(this).closest('tr')).data();
                if(!aData) var aData = oTable.row(this).data();

                console.log(aData);
                for (var key in aData) {
                    try {
                        if(key=='id_opd') $("#formindikator [name='id_opd']").val(aData[key]).trigger('change');
                        $('#formindikator [name=' + key + ']').val(aData[key]);

                        if (aData['is_aktif'] == 0) $('#formindikator [name="is_aktif"]').prop('checked', false);
                        else $('#formindikator [name="is_aktif"]').prop('checked', true);
                    } catch (err) {}
                }
                $(".page-content").hide();
                $(".page-form").fadeIn();

            });

            $(document).on('click', '#indikator-datatable .btn-delete', function () {
                var aData = oTable.row(this).data();
                $.ajax({
                    url: base_url + "/module/master/delete_indikator",
                    type: "post",
                    data: $.param({id_indikator: aData.id_indikator}),
                    success: function (response) {
                        m = JSON.parse(response);
                        if(m.type=='success') toastr.success("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        else toastr.error("", m.message, {showMethod: "slideDown", progressBar: "true"});
                        oTable.ajax.reload();
                    }
                })
            });

            $('#formindikator [name="is_aktif"]').on('click',function(){
                if($(this).is(':checked')) $('#formindikator [name="is_aktif"]').val(1);
                else $('#formindikator [name="is_aktif"]').val(0);
            });
            $('#formindikator [name="id_opd"]').on('change',function() {
                $('#formindikator [name="id_opd"] :selected').each(function () {
                    $("#opd_pengampu").val($(this).text());
                })
            });

            $('#formindikator').submit(function (e) {
                e.preventDefault();

                var formData = new FormData($("#formindikator")[0]);

                $.ajax({
                    url: base_url + "/module/master/simpan_indikator",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var m = JSON.parse(response);
                        if (m.status === "ok") {
                            $.toast({
                                heading: 'Success',
                                text: m.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            })
                        } else {
                            $.toast({
                                heading: 'Danger',
                                text: m.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            })
                        }
                        $(".page-form #formindikator")[0].reset();
                        $(".page-form").hide();
                        $(".page-content").show();
                        oTable.ajax.reload();
                    }
                });
            });
        }
    }

    tabindikator.init();
});
