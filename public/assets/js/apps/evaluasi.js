$(document).ready(function () {
    document.addEventListener("wheel", function(event) {
        if (document.activeElement.type === "number") {
            document.activeElement.blur();
        }
    });

    var aPos="";
    var aData="";
    $(".select2").select2();
    $(".nilai_konversi").on("keyup",function(){

        if($(this).val() > 100 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai maksimal adalah 100',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-center'
            });
            $(this).val(100);
        }else if($(this).val() < 0 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai minimal adalah 1',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-center'
            });
            $(this).val(0);
        }
    });
    $("#sync-serapan").on("click",function(){
         swal({
            title: "Apakah Anda yakin?",
            text: 'Sistem akan melakukan sinkronisasi nilai serapan anggaran dengan BPKAD.',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willSave) => {
                if (willSave) {
                    $("body").loading('start');
                    $.ajax({
                        url: base_url+"/apps/sync_serapan",
                        data: {
                            tahun: $("#frmsearch [name='tahun']").val()
                        },
                        type:'post',
                        dataType: "json"
                    }).then(function (response) {
                        $("body").loading('stop');
                        var m = response;
                        if (m.status=='ok') {
                            $.toast({
                                heading: 'Success',
                                text: 'Proses sinkronisasi berhasil dilakukan',
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            })
                        } else {
                            //swal("Error", "Proses Sinkronisasi Tidak Berhasil!", "error");
                            $.toast({
                                heading: 'Danger',
                                text: 'Proses Sinkronisasi Tidak Berhasil Dilakukan',
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            })
                        }
                    });
         } else {
             swal("Batal", "Proses Sinkronisasi Dibatalkan!", "info");
         }
     });
})

/*$("#frmsearch [name='id_aspek']").val($("#tmp-indikator").val().substring(0,3)).trigger('change');
$("#frmsearch [name='id_indikator']").val($("#tmp-indikator").val()).trigger('change');

$("#frmsearch [name='id_unit']").change(function(){
 $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
 tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
});*/

$("#frmsearch [name='tahun']").change(function(){
    tabevaluasibyindikator();
 //$("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
 //tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
});

/*$("#frmsearch [name='id_aspek']").change(function(){
 filterSelectOptions($("#layout-select"), "data-aspek", $(this).val());
 $("#tmp-indikator").val($("#frmsearch [name='id_indikator']").val());
 tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
});
*/

$("#frmsearch [name='id_indikator']").change(function(){
    console.log($(this).val())
    tabevaluasibyindikator();
 //$("#frmsearch [name='id_aspek']").val($("#frmsearch [name='id_indikator']").val().substring(0,3)).trigger('change');
 //$("#id_indikator").val($("#frmsearch [name='id_indikator']").val());
 //tabevaluasibyindikator();
 //tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),$("#frmsearch [name='id_aspek']").val(),$("#frmsearch [name='id_indikator']").val());
});


tabevaluasibyindikator = function(){
    $("#divFormEvaluasi").hide();
    var str = $('#id_indikator_cmb').val();
    //console.log(str);
    var strsplit = str.split('#');
    var id_indikator=strsplit[0];
    var nilai_maks=strsplit[1];
    var bobot=strsplit[2];

    var tahun = $("#frmsearch [name='tahun']").val();
    $('#formEvaluasi [name=tahun]').val(tahun);
    $('.nilai_maks').val(nilai_maks);
    $('.bobot').val(bobot);
    $('.nilai_konversi').val(0);
    if(id_indikator) {
        $("#divFormEvaluasi").show();
        $.ajax({
            url: base_url + "/apps/finddetailbyindikator/",
            type: 'POST',
            data: {
                tahun: tahun,
                tag: $('#tag').val(),
                id_indikator: id_indikator
            },
        }).then(function (data) {
            if (data) {
                // $(".div-data").html("");
                $('#formEvaluasi [name=id_indikator]').val(id_indikator);
                for (i = 0; i < data.length; i++) {
                    var u = data[i];
                    if (id_indikator == u.id_indikator) {
                        for (var key in u) {
                            try {
                                $('#formEvaluasi [id=' + key + ']').val(u[key]);
                                $('#formEvaluasi [id=' + key + u.id_unit + ']').val(u[key]);
                                if (key == 'bobot') $('#formEvaluasi [id=' + key + u.id_unit + ']').val((u[key] / 100).toFixed(2));
                            } catch (err) {
                            }
                        }
                    }
                }
            } else {
                $('.nilai_maks').val(nilai_maks);
                $('.bobot').val(bobot);
                $('.nilai_konversi').val(0);
            }
        });
    }
}
function filterSelectOptions(selectElement, attributeName, attributeValue) {
 if (selectElement.data("currentFilter") != attributeValue) {
     selectElement.data("currentFilter", attributeValue);
     var originalHTML = selectElement.data("originalHTML");
     if (originalHTML)
         selectElement.html(originalHTML)
     else {
         var clone = selectElement.clone();
         clone.children("option[selected]").removeAttr("selected");
         selectElement.data("originalHTML", clone.html());
     }
     if (attributeValue) {
         selectElement.children("option:not([" + attributeName + "='" + attributeValue + "'],:not([" + attributeName + "]))").remove();
     }
 }
}

$("#divFormEvaluasi").hide();
var tabevaluasi= {
 init: function (id_unit,tahun, id_aspek, id_indikator) {
     $("#divDataEvaluasi").show();
     if(id_unit) $("#divFormEvaluasi").show();
     $("#divFormEvaluasi #formEvaluasi")[0].reset();
     $("#formEvaluasi [name='id_evaluasi']").val("");
     $("#formEvaluasi [name='id_unit']").val(id_unit);
     $("#formEvaluasi [name='tahun']").val(tahun);

     $.ajax({
         url: base_url+"/apps/finddetail/",
         type:'POST',
         data: {
             tahun: tahun,
             tag:$('#tag').val(),
             id_unit:id_unit
         },
     }).then(function (data) {
         if(data){
             for (i = 0; i < data.length; i++) {
                 var u = data[i];
                 for (var key in u) {
                     try {
                         $('#formEvaluasi [id=' + key+']').val(u[key]);
                         $('#formEvaluasi [id=' + key+u.id_indikator+']').val(u[key]);
                         if(u.is_verify==1 && u.id_indikator){
                             if(key=='nilai_awal' || key=='nilai_konversi') $('#formEvaluasi [id=' + key+u.id_indikator+']').attr('readonly','readonly');
                         }else{
                             if($("#id_role").val()=='1'){
                                 if(key=='nilai_awal' || key=='nilai_konversi') $('#formEvaluasi [id=' + key+u.id_indikator+']').removeAttr('readonly');
                             }
                         }

                         /*if((u.is_verify==1 || ($("#id_role").val()!='1' && u.id_opd!=$("#id_opd").val())) && u.id_indikator){
                             if(key=='nilai_awal' || key=='nilai_konversi') $('#formEvaluasi [id=' + key+u.id_indikator+']').attr('readonly','readonly');
                         }else{
                             if(key=='nilai_awal' || key=='nilai_konversi') $('#formEvaluasi [id=' + key+u.id_indikator+']').removeAttr('readonly');
                         }*/
                                if(key=='bobot')  $('#formEvaluasi [id=' + key+u.id_indikator+']').val((u[key]/100).toFixed(2));
                            } catch (err) {}
                        }
                    }
                }
            });



        }
    }

    $('#formEvaluasi').submit(function(e) {
        e.preventDefault();
        // var fileName= $('#formEvaluasi input[name="dokumen"]').val();
        var formData = new FormData($("#formEvaluasi")[0]);
        $("body").loading('start');
        $.ajax({
            url: base_url+"/apps/simpanevaluasi",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $("body").loading('stop');
                m= JSON.parse(response);
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
                //tabevaluasi.init($("#frmsearch [name='id_unit']").val(),$("#frmsearch [name='tahun']").val(),'','');
            }
        })
    });

   // tabevaluasi.init('',$("#frmsearch [name='tahun']").val(),'','');

    $(".btn-cancel").click(function() {
        $("#divFormEvaluasi #formEvaluasi")[0].reset();
        $("#divDataEvaluasi").show();
        $("#divFormEvaluasi").hide();
    });

    validateTipeDokumen = function (fileName) {
        var file_array = fileName.split(".");
        var file_array1 = file_array[1].toLowerCase();
        if (file_array1 == 'pdf' || file_array1 == 'jpeg' || file_array1 == 'jpg' || file_array1 == 'png') {
            return true;
        }
        else {
            toastr.error("", 'Upload gagal. Ekstensi dokumen tidak sesuai.', {
                showMethod: "slideDown",
                progressBar: "true"
            });
            return false;
        }
    }




});