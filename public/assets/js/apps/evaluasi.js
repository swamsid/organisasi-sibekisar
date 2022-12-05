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

    $("#frmsearch [name='tahun']").change(function(){
        alert('okee');
    });

    $("#frmsearch [name='id_indikator']").change(function(){
        console.log($(this).val());
        tabevaluasibyindikator();
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

    function initPage(){

        let url = base_url + "/apps/getPeriodeDanIndikator?tag="+$('#tag').val();
        let htmlOption = ""; let htmlOption2 = "";

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 
            data.periode.forEach((z, index) => { 
                htmlOption +=  `<option value="${z.id_periode}" ${ (z.tahun_periode == data.selected) ? 'selected' : '' }>${z.tahun_periode}</option>`
            });

            data.indikator.forEach((z, index) => { 
                htmlOption2 +=  `<option value="${z.id_indikator}" ${ (index == 0) ? 'selected' : '' }>${z.indikator}</option>`
            });

            $("#tahun-periode").html(htmlOption);
            $("#id_indikator_cmb").html(htmlOption2);

            $('#layout').fadeOut(300);
        });
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

    let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    initPage();
});