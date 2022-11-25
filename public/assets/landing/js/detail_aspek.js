$(document).ready(function () {
    var aPos="";
    var aData="";
    $(".select2").select2();

    $(".filter-cettar").hide();
    $(".filter-aspek").show();

    $("#tahun").on('change',function(){
        tabrekap();
    });
    $("#id_unit").on('change',function(){
        tabrekap();
    });
    $("#id_aspek").on('change',function(){
        tabrekap();
    });

    tabrekap = function () {
        if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            id_unit: $('#id_unit').val(),
            id_aspek: $('#id_aspek').val(),
            tag:$("#tag").val()
        };

        var tahun=$("#tahun").val();
        var id_aspek=$("#id_aspek").val();
        var req = $.post(url, param).done(function (data) {

            if (data) grafikaspek(data, tahun,id_aspek);
            $('#div-rekap').html("");
        }).always(function () {});
    }


    tabrekap();

    grafikaspek = function(data,tahun,id_aspek){
        var a=[], b=[], c=[], d=[], e=[], f=[];
        var ma=[], mb=[], mc=[], md=[], me=[], mf=[];
        var kategori = [],aspek=[];
        var flags=[],flag=[],series=[],seriesa=[],seriesb=[], seriesc=[],seriesd=[],seriese=[],seriesf=[], jml=[],unit=[],kategoriunit=[];

        for(var i = 0; i < data.length; i++){
            if( aspek[data[i].aspek]) continue;
            aspek[data[i].aspek] = true;
            kategori.push(data[i]['aspek']);
        }

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit]) continue;
            flags[data[i].unit] = true;
            unit.push(data[i]['unit']);
        }

        for(var i = 0; i < kategori.length; i++) {
            jml[i] = 0;
            a[j] = 0, b[j] = 0, c[j] = 0, d[j] = 0, e[j] = 0;
            for (var j = 0; j < unit.length; j++) {
                kategoriunit[i] = unit[j];
                if (flag[kategoriunit[i]]) continue;
                flag[kategoriunit[i]] = true;

                if (data) {
                    $.each(data, function (key, value) {
                        if (unit[j] == value['unit']) {
                            if (value['id_aspek'] == 'C01' || value['id_aspek'] == 'K01'){
                                a[j] = parseFloat(value['nilai_akhir']);
                                ma.push({unit:value['unit'], 'nilai':a[j]});
                            }
                            if (value['id_aspek'] == 'C02' || value['id_aspek'] == 'K02') {
                                b[j] = parseFloat(value['nilai_akhir']);
                                mb.push({unit:value['unit'], 'nilai':b[j]});
                            }
                            if (value['id_aspek'] == 'C03' || value['id_aspek'] == 'K03') {
                                c[j] = parseFloat(value['nilai_akhir']);
                                mc.push({unit:value['unit'], 'nilai':c[j]});
                            }
                            if (value['id_aspek'] == 'C04' || value['id_aspek'] == 'K04') {
                                d[j] = parseFloat(value['nilai_akhir']);
                                md.push({unit:value['unit'], 'nilai':d[j]});
                            }
                            if (value['id_aspek'] == 'C05' || value['id_aspek'] == 'K05') {
                                e[j] = parseFloat(value['nilai_akhir']);
                                me.push({unit:value['unit'], 'nilai':e[j]});
                            }
                            if (value['id_aspek'] == 'C06' || value['id_aspek'] == 'K06') {
                                f[j] = parseFloat(value['nilai_akhir']);
                                mf.push({unit:value['unit'], 'nilai':f[j]});
                            }
                        }
                    });
                }
            }
            if (kategori[i] == 'Cepat' && (id_aspek=='C01' || id_aspek=='K01')){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[], flags=[];

                ma.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < ma.length; x++) {
                    //if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && ma[x]['nilai'] == value['nilai_akhir'] && ma[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tercepat").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                        }
                    //}

                }
                var judul= $("#lblunit").val() + ' Tercepat dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: ma
                });*/

            }
            if (kategori[i] == 'Efektif & Efisien' && (id_aspek=='C02' || id_aspek=='K02')){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                mb.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mb.length; x++) {
                   // if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mb[x]['nilai'] == value['nilai_akhir'] && mb[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terefektif").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                       // }
                    }

                }
                var judul= $("#lblunit").val() + ' Terefektif & Efisien dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: mb
                });*/
            }
            if (kategori[i] == 'Tanggap' && (id_aspek=='C03' || id_aspek=='K03')){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                mc.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mc.length; x++) {
                    //if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mc[x]['nilai'] == value['nilai_akhir'] && mc[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tertanggap").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                        //}
                    }

                }
                var judul= $("#lblunit").val() + ' Tertanggap dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);

                /* series.push({
                     name: kategori[i], data: mc
                 });*/
            }
            if (kategori[i] == 'Transparan' && (id_aspek=='C04' || id_aspek=='K04')){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                md.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < md.length; x++) {
                   // if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && md[x]['nilai'] == value['nilai_akhir'] &&  md[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tertransparan").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                        //}
                    }

                }
                var judul= $("#lblunit").val() + ' Tertransparan dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: md
                });*/
            }
            if (kategori[i] == 'Akuntabel' && (id_aspek=='C05' || id_aspek=='K05')){
                var chartSeriesData=[];
                var chartSeriesColor=[];
                var chartUnit=[];
                me.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < me.length; x++) {
                    if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && me[x]['nilai'] == value['nilai_akhir'] && me[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terakuntabel").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                        }
                    }

                }
                var judul= $("#lblunit").val() + ' Terakuntabel dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: me
                });*/
            }
            if (kategori[i] == 'Responsive' && (id_aspek=='C06' || id_aspek=='K06')){
                var chartSeriesData=[];
                var chartSeriesColor=[];
                var chartUnit =[];
                mf.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mf.length; x++) {
                    if(x < 56){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mf[x]['nilai'] == value['nilai_akhir'] && mf[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terresponsif").html(value['unit']);
                                   var l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
                                    var seriesColor = color;
                                    var series = [l, parseFloat(value['nilai_akhir'])];
                                    chartSeriesData.push(series);
                                    chartSeriesColor.push(color);
                                    chartUnit.push(l);
                                }
                            });
                        }
                    }

                }
                var judul= $("#lblunit").val() + ' Terresponsif dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chart',judul,chartSeriesData, chartSeriesColor, chartUnit);
            }
        }


    }

    generatechart = function(chart, judul, chartSeriesData, chartSeriesColor, chartUnit){
        $('#'+chart).highcharts({
            title: {
                text: judul,
                style: {
                    fontFamily: 'oswald',
                    fontSize: '20px'
                }
            },
            chart: {
                renderTo: 'container',
                type: 'bar',
                backgroundColor: '#fff',
                events: {
                    load: function() {
                        let categoryHeight = 35;
                        this.update({
                            chart: {
                                height: categoryHeight * this.pointCount + (this.chartHeight - this.plotHeight)
                            }
                        })
                    }
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    },
                    stacking: 'normal',
                    /*colors: ['#FF530D', '#E82C0C', '#FF0000', '#E80C7A', '#E80C7A']*/
                },
                series: {
                    dataLabels: {
                        enabled:false,
                    },
                    events: {
                        legendItemClick: function() {
                            return false;
                        }
                    }
                }
            },
            xAxis: {
                categories: chartUnit,
                title: {
                    text: null
                },
                crosshair : true,
                gridLineWidth: 18,
                paddingWidth: 6,
                labels: {
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || '#333333'
                    }
                }

            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                },
                labels: {
                    overflow: 'justify'
                }
            },
            series: [{
                name: 'Nilai',
                pointWidth: 28,
                data:chartSeriesData,
                dataLabels: {
                    enabled: false,
                    rotation: 0,
                    color: '#000',
                    align: 'center',
                    format: '{point.y:.2f}', // one decimal
                    y: 0
                },
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#003399'],
                        [1, '#ff66AA']
                    ]
                }
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        navigator: {
                            enabled: false
                        }
                    }
                }]
            }
        });
    }
    grafikcettar = function(data,tahun,id_aspek){
        var a=[], b=[], c=[], d=[], e=[], f=[], g=[];
        var ma=[], mb=[], mc=[], md=[], me=[], mf=[], mg=[];
        var kategori = [],aspek=[];
        var flags=[],flag=[],series=[],jml=[],unit=[],kategoriunit=[];

        if(id_aspek==''){
            for(var i = 0; i < data.length; i++){
                if( aspek[data[i].aspek]) continue;
                aspek[data[i].aspek] = true;
                kategori.push(data[i]['aspek']);
            }
        }else{
            for(var i = 0; i < data.length; i++){
                if(data[i].id_aspek==id_aspek) {
                    if (aspek[data[i].aspek]) continue;
                    aspek[data[i].aspek] = true;
                    kategori.push(data[i]['aspek']);
                }
            }
        }

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit]) continue;
            flags[data[i].unit] = true;
            unit.push(data[i]['unit']);
        }

        for(var i = 0; i < kategori.length; i++) {
            jml[i] = 0;
            for (var j = 0; j < unit.length; j++) {
                kategoriunit[i] = unit[j];
                if (flag[kategoriunit[i]]) continue;
                flag[kategoriunit[i]] = true;
                a[j] = null, b[j] = null, c[j] = null, d[j] = null, e[j] = null;
                if (data) {
                    $.each(data, function (key, value) {
                        if (unit[j] == value['unit']) {
                            if (value['id_aspek'] == 'C01'){
                                a[j] = parseFloat(value['total_nilai']);
                                ma[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C02') {
                                b[j] = parseFloat(value['total_nilai']);
                                mb[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C03') {
                                c[j] = parseFloat(value['total_nilai']);
                                mc[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C04') {
                                d[j] = parseFloat(value['total_nilai']);
                                md[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C05') {
                                e[j] = parseFloat(value['total_nilai']);
                                me[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == 'C06') {
                                f[j] = parseFloat(value['total_nilai']);
                                mf[j] = parseFloat(value['nilai_maks']);
                            }
                            if (value['id_aspek'] == id_aspek) {
                                g[j] = parseFloat(value['total_nilai']);
                                mg[j] = parseFloat(value['nilai_maks']);
                            }
                        }
                    });
                }
                if(j==unit.length-1) {
                    if(id_aspek=='') {
                        var spline = {
                            type: 'spline',
                            name: 'Nilai Maks',
                            data: [ma[j], mb[j], mc[j], md[j], me[j], mf[j]],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'white'
                            }
                        }

                        series.push({
                            type: 'column', name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j], f[j]]
                        }, spline);
                    }else{
                        var spline = {
                            type: 'spline',
                            name: 'Nilai Maks',
                            data: [mg[j]],
                            marker: {
                                lineWidth: 2,
                                lineColor: Highcharts.getOptions().colors[3],
                                fillColor: 'black'
                            }
                        }

                        series.push({
                            type: 'column', name: kategoriunit[i], data: [g[j]]
                        }, spline);
                    }
                }else{
                    if(id_aspek=='') {
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [a[j], b[j], c[j], d[j], e[j], f[j]]
                        });
                    }else{
                        series.push({
                            type: 'column', name: kategoriunit[i], data: [g[j]]
                        });
                    }
                }

            }
        }

        $('#chart').highcharts({
            title: {
                text: 'Rekap Rangking OPD dalam Spirit Tahun '+ $("#tahun").val()
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    },
                    pointPadding: 0.1,
                    borderWidth: 0,
                    ignoreNulls: 'normal'
                },
                spline: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false,
                    ignoreNulls: 'normal'
                }
            },
            labels: {
                items: [{
                    html: 'Nilai Maks',
                    style: {
                        left: '50px',
                        top: '15px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },

            xAxis: {
                categories: kategori,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },
            legend: {
                enabled: true
            },
            series: series
        });
    }
});