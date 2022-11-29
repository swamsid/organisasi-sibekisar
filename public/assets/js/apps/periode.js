$(document).ready(function (){
    let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
    $('#layout .konten').html(loadingKontent);
    $('#layout').show();

    function getData(){
        let url     = base_url + "/apps/getPeriode";
        let html    = ``;
        
        $.get(url).done(function (response) {
            const data = JSON.parse(response);
            
            data.data.forEach((z, index) => { 
                html +=  `
                    <div class="col-xl-3 div-unit konten-wrap">
                        <div class="card">
                            <div class="card-body" style="padding: 10px 15px;">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td width="60%">
                                                <span style="font-weight: 600; font-size: 11pt;">
                                                    ${z.tahun_periode}      
                                                </span>
                                                <div style="font-size: 8pt; margin-top: 5px;">
                                                    ${
                                                        (z.evaluasi != "0") ? 
                                                            `<i class="fa fa-check" style="color: var(--success)"></i> &nbsp;Sudah ada evaluasi` 
                                                        : 
                                                            '<i class="fa fa-times"></i> &nbsp;Belum ada evaluasi' }
                                                </div>
                                            </td>
                                            <td style="text-align: right;" class="button-table-wrap">
                                                ${
                                                    (z.evaluasi == "0") ? 
                                                        `<button class="delete-periode button-operate" data-id="${z.tahun_periode}" style="width: 30px; height: 30px; border: 1px solid #aaa; padding: 0px; border-radius: 10px; background: white;" title="hapus data periode">
                                                            <i class="fa fa-trash fa-fw" style="color: var(--danger); font-size: 11pt;"></i>
                                                        </button>` : ``}

                                                <button class="update-periode button-operate" data-periode="${z.tahun_periode}" data-id="${z.id_periode}" style="width: 30px; height: 30px; border: 1px solid #aaa; padding: 0px; border-radius: 10px; background: white;" title="perbarui data periode">
                                                    <i class="fa fa-edit fa-fw" style="color: var(--cyan); font-size: 11pt;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div>
                `
            })

            $('#data-wrap').html(html);
            $('#layout').fadeOut(500);
        });
    }

    $('#data-wrap').on('click', '.delete-periode', function(evt){
        const choice = $(this).data('id');

        if (confirm("Apakah anda yakin ingin menghapus periode "+choice) == true) {
            let url     = base_url + "/apps/deletePeriode";
            let params  = { periode: choice }

            let loadingKontent = `<span style="color: white;">Menghapus Data. Harap Tunggu...</span>`
            
            $('#layout .konten').html(loadingKontent);
            $('#layout').show();

            $.post(url, params).done(function (response) {
                const data = JSON.parse(response);
                
                if(data.status == 'sukses'){
                    $.toast({
                        text: 'Data periode berhasil dihapus.',
                        position: 'top-right',
                        stack: false,
                        icon: 'success'
                    });                    
    
                    getData();
                }else{
                    $.toast({
                        text: 'Server bermasalah. Hubungi developer',
                        position: 'top-right',
                        stack: false,
                        icon: 'error'
                    });
                }
    
                $('#save').removeAttr('disabled');
                $('#save').html('+ &nbsp;Tambah Periode');
            });
        }
    })

    $('#data-wrap').on('click', '.update-periode', function(evt){
        const choice = $(this).data('periode');
        const id     = $(this).data('id');

        $('#input-update-periode').val(choice);
        $('#input-update-id').val(id);
        $('#modal-edit-periode').modal('show');
    })

    $('#save').click((e) => {
        if($('#input-periode').val() == ''){
            $.toast({
                text: 'Inputan periode tidak boleh kosong.',
                position: 'top-right',
                stack: false,
                icon: 'error'
            });

            return false;
        }

        let url     = base_url + "/apps/savePeriode";
        let params  = { periode: $('#input-periode').val() }

        $('#save').attr('disabled', 'true');
        $('#save').html('Menyimpan...');

        $.post(url, params).done(function (response) {
            const data = JSON.parse(response);
            
            if(data.status == 'sukses'){
                $.toast({
                    text: 'Data periode berhasil disimpan.',
                    position: 'top-right',
                    stack: false,
                    icon: 'success'
                });

                $('#input-periode').val('');
                let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
                $('#layout .konten').html(loadingKontent);
                $('#layout').show();

                getData();
            }else{
                $.toast({
                    text: data.message,
                    position: 'top-right',
                    stack: false,
                    icon: 'error'
                });
            }

            $('#save').removeAttr('disabled');
            $('#save').html('Simpan Periode');
        });
    })

    $('#update').click((e) => {
        if($('#input-update-periode').val() == ''){
            $.toast({
                text: 'Inputan periode tidak boleh kosong.',
                position: 'top-right',
                stack: false,
                icon: 'error'
            });

            return false;
        }

        let url     = base_url + "/apps/updatePeriode";
        let params  = { id_periode: $('#input-update-id').val(), periode: $('#input-update-periode').val() }

        $('#update').attr('disabled', 'true');
        $('#update').html('Menyimpan...');

        $.post(url, params).done(function (response) {
            const data = JSON.parse(response);
            
            if(data.status == 'sukses'){
                $.toast({
                    text: 'Data periode berhasil diperbarui.',
                    position: 'top-right',
                    stack: false,
                    icon: 'success'
                });

                let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
                $('#layout .konten').html(loadingKontent);
                $('#layout').show();

                getData();
            }else{
                $.toast({
                    text: data.message,
                    position: 'top-right',
                    stack: false,
                    icon: 'error'
                });
            }

            $('#update').removeAttr('disabled');
            $('#update').html('Simpan Perubahan');
        });
    })

    $('#input-periode').keypress((evt) => {
        if(isNaN(parseFloat(evt.key)))
            return false;
        
        return true;
    })
    
    $('#tambah-periode').click((evt) => {
        $('#input-periode').val('');
        $('#modal-tambah-periode').modal('show');
    })

    $('#button-reload').click((evt) => {
        let loadingKontent = `<span style="color: white;">Sedang Mengambil Data. Harap Tunggu...</span>`
        
        $('#layout .konten').html(loadingKontent);
        $('#layout').show();

        getData();
    })

    getData();
})