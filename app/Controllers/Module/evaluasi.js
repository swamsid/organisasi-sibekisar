$(document).ready(function () {
    document.addEventListener("wheel", function(event) {
        if (document.activeElement.type === "number") {
            document.activeElement.blur();
        }
    });

    var aPos="";
    var aData="";

    $(".select2").select2();
    
    $("#table-data").on("keyup", '.nilai_konversi',function(){

        // alert($(this).val().replaceAll(',', '.'));

        if(parseFloat($(this).val().replaceAll(',', '.')) > 100 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai maksimal adalah 100',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });
            $(this).val(100);
        }else if($(this).val() < 0 ) {
            $.toast({
                heading: 'Danger',
                text: 'Nilai minimal adalah 1',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
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
        $('#tahun').val($("#frmsearch [name='tahun'] option:selected").text());
        $('#periode').val($("#frmsearch [name='tahun']").val());

        $('#id_indikator').val('');
        $('.btn-hide-first').fadeOut(300);

        $('#nilai_maks').val('');
        $('#bobot').val('');

        getIndikator();
    });

    $("#frmsearch [name='id_indikator']").change(function(){
        $('#id_indikator').val($("#frmsearch [name='id_indikator']").val());
        $('.btn-hide-first').fadeIn(300);

        $('#nilai_maks').val($("#frmsearch [name='id_indikator'] option:selected").data('nmaks'));
        $('#bobot').val($("#frmsearch [name='id_indikator'] option:selected").data('bobot'));
        getDataByIndikator();
    });

    function getIndikator(){
        periode = $("#frmsearch [name='tahun']").val();

        let url = base_url + "/apps/getIndikatorByPeriode?tag="+$('#tag').val()+'&periode='+periode;
        let htmlOption2 = "<option value='00000' selected disabled> -- Pilih indikator</option>";

        let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 

            data.indikator.forEach((z, index) => { 
                htmlOption2 +=  `<option value="${z.id_indikator}" data-nmaks="${z.nilai_maks}" data-bobot="${z.bobot}">${z.indikator}</option>`
            });

            $("#id_indikator_cmb").html(htmlOption2);
            $('#table-data tbody').html(`
                <tr>
                    <td colspan="3" class="text-center" id="data-text-info">Pilih indikator menggunakan pilihan diatas</td>
                </tr>
            `);

            $('#layout').fadeOut(300);
        });
    };

    $("#submit-form").click(function(){
        let url     = base_url + "/apps/simpanevaluasi";
        let params  = $('#formEvaluasi').serialize();

        $('#submit-form').attr('disabled', 'true');
        $('#submit-form').html('Menyimpan...');
        $('.btn-hide-first.cancel').fadeOut();
        
        $.post(url, params).done(function (response) {
            var rest = JSON.parse(response);

            $('#submit-form').removeAttr('disabled');
            $('#submit-form').html('Simpan');
            $('.btn-hide-first.cancel').fadeIn();
            
            if(rest.status == 'ok'){
                const data = rest.data;
                $.toast({
                    // heading: 'success',
                    text: 'Penilaian berhasil disimpan',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
            }else{

            }
        })
    });

    $('#table-data').on('keypress', '.nilai_konversi', function(e){
        const value = $(this).val();

        if(isNaN(e.key) && e.key != ','){
            $.toast({
                // heading: 'success',
                text: 'Inputan harus berupa angka',
                icon: 'error',
                loaderBg: '#f96868',
                position: 'top-right'
            });

            return false;
        }else if(e.key == ',' && value.indexOf(',') > 0){
            return false
        }
    });

    function getDataByIndikator(){
        let url     = base_url + "/apps/finddetailbyindikator";
        let params  = {
            tahun           : $("#frmsearch [name='tahun']").val(),
            tag             : $('#tag').val(),
            id_indikator    : $("#frmsearch [name='id_indikator']").val()
        };

        let id_indikator = $("#frmsearch [name='id_indikator']").val();

        let loadingKontent = `<span style="color: white;">Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        $.get(url, params).done(function (response) {
            var rest = JSON.parse(response);
            
            if(rest.status == 'success'){
                const data = rest.data;

                if (data) {
                    let html = '';

                    data.forEach((z, alpha) => {
                        html += `
                        <tr>
                            <td>
                                <input type="hidden" name="id_unit[]" value="${z.unit_id}" readonly>
                                ${z.unit}
                            </td>
                            <td>
                                <input type="text" class="form-control nilai_awal" style="height: 30px; text-align: center;" placeholder="Input nilai Awal" name="nilai_awal[]" value="${(z.nilai_awal) ? z.nilai_awal : '' }">
                            </td>
                            <td>
                                <input type="text" class="form-control nilai_konversi" style="height: 30px; text-align: center;" placeholder="Input nilai" name="nilai_konversi[]" value="${(z.nilai_konversi) ? z.nilai_konversi.replaceAll('.', ',') : 0 }">
                            </td>
                        </tr>
                        `;
                    })

                    $('#table-data tbody').html(html);

                    setTimeout(() => {
                        $('#layout').fadeOut(300);
                    }, 0);

                    // console.log($('#table-data tbody').html());
                } else {
                    $('#data-text-info').text('Tidak ditemukan data di indikator ini. coba muat ulang halaman')
                }
            }
        });
    }

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
        let htmlOption = ""; let htmlOption2 = "<option value='00000' selected disabled> -- Pilih indikator</option>";

        $.get(url).done(function (response) {
            const data = JSON.parse(response) 
            data.periode.forEach((z, index) => { 
                htmlOption +=  `<option value="${z.id_periode}" ${ (z.tahun_periode == data.selected) ? 'selected' : '' }>${z.tahun_periode}</option>`
            });

            data.indikator.forEach((z, index) => { 
                htmlOption2 +=  `<option value="${z.id_indikator}" data-nmaks="${z.nilai_maks}" data-bobot="${z.bobot}">${z.indikator}</option>`
            });

            $("#tahun").val(data.selected)
            $("#periode").val(data.periode[(data.periode.length - 1)].id_periode)
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