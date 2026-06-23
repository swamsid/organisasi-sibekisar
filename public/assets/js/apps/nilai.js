$(document).ready(function () {
    $(".select2").select2();

    $("#tahun").on('change', function () {
        $('#div-spirit').html(`
            <div style="text-align: center; padding: 10px; font-size: 10pt;">Harap Tunggu ...</div>
        `);

        tabspirit();
    });

    tabspirit = function () {
        if ($.fn.DataTable.isDataTable("#main-table")) $("#main-table").DataTable().destroy();

        var url = base_url + "/apps/getRekapNilai";
        var param = {
            tahun: $('#tahun').val(),
        };

        var tahun = $("#tahun option:selected").text();

        let t = `
                <table id="main-table">
                    <thead>  
                        <tr>
                            <th rowspan="2" width="4%" class="text-left">No.</th>
                            <th rowspan="2">Perangkat Daerah</th>
                            <th class="text-center" colspan="3" width="28%">Nilai Reformasi Birokrasi</th>
                            <th class="text-center" colspan="3" width="35%">Indeks RB</th>
                        </tr>

                        <tr>
                            <th class="text-center">General</th>
                            <th class="text-center">Koefisien</th>
                            <th class="text-center">Tematik</th>

                            <th class="text-center">Tahun ${tahun}</th>
                            <th class="text-center">Sebelumnya</th>
                            <th>Kenaikan/Penurunan</th>
                        </tr>
                    </thead>

                    <tbody>
        `;

        var req = $.post(url, param).done(function (data) {            
            data.forEach((dta, index) => {
                    let status = '<i class="fa fa-arrow-up" aria-hidden="true" style="color: var(--green);"></i>';

                    if(dta.selisih < 0)
                        status = '<i class="fa fa-arrow-down" aria-hidden="true" style="color: var(--pink)"></i>';
                    else if(dta.selisih == 0)
                        status = '<i class="fa fa-minus" aria-hidden="true"></i>';
                        
                    t += `
                        <tr>
                            <td class="text-center">${index + 1}</td>  
                            <td>${dta.unit}</td>  
                            <td class="text-center">${dta.nilai_general}</td>  
                            <td class="text-center">${dta.koefisien_general}</td>  
                            <td class="text-center">${dta.nilai_tematik}</td>  
                            <td class="text-center">${dta.indeks_rb}</td>
                            <td class="text-center">${dta.indeks_sebelum}</td>
                            <td class="text-center">
                                ${status} &nbsp;
                                ${Math.abs(dta.selisih).toFixed(2)}
                            </td>
                        </tr>  
                    `;
            })

            t += `  </tbody>
                </table>`;
            
            $('#div-spirit').html(t);
            
            $('#main-table').DataTable({
                pageLength: 100,
                scrollX: true,
                autoWidth: false,

                language: {
                    lengthMenu: '_MENU_ Data'
                },
            });

            if(data.length > 0)
                $('#export-button').fadeIn(500);

        })
        .always(function () {

        });
    }
});

function exportExcel(){
    window.open(base_url + "/apps/exportNilaiExcel?tahun=" + $("#tahun").val(), '_blank');
}