$(document).ready(function () {

    tabcettar = function () {
        // if ($.fn.DataTable.isDataTable("table.display")) $("table.display").DataTable().destroy();
        var url = base_url + "/apps/gridrekapcettar";
        var param = {
            tahun: $('#tahun').val(),
            tag:'kab',
            limit:10
        };

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {
            if (data) grafikcettar(data, tahun,'');
        });
    }

    grafikcettar = function(data,tahun,predikat){

        var flags=[],unit=[];

        for(var i = 0; i < data.length; i++){
            if( flags[data[i].unit.toUpperCase()]) continue;
            flags[data[i].unit.toUpperCase()] = true;
            unit.push(data[i]['unit'].toUpperCase());
        }

        var  data_r=[];
        var chartSeriesData=[];
        var chartSeriesColor=[];
        var chartSeries =[];
        if (data) {
            var j=0;
            $.each(data, function (key, value) {
                j++;
                if(j==1) color = '#FF530D';
                else color = '#333333';
                var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';

                data_r.push({
                    y:value['nilai'],
                    label:l,
                    colors:color
                });
                var seriesColor = color;
                var series = [l,parseFloat(value['nilai'])];
                chartSeriesData.push(series);
                chartSeriesColor.push(color);
            });
        }

        //console.log(data_r);


        $('#chart').highcharts({
            /*title: {
                text: '10 Kabupaten/Kota Terbaik dalam CETTAR Tahun '+ $("#tahun").val()
            },*/
            title:{
                text:''
            },
            chart: {
                renderTo: 'container',
                type: 'bar',
                backgroundColor: '#fff',

            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    },
                    stacking: 'normal',
                    /*colors: ['#FF530D', '#E82C0C', '#FF0000', '#E80C7A', '#E80C7A']*/
                }
            },
            legend: {
                enabled:false
            },
            xAxis: {
                categories: unit,
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
                type: 'bar',
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
                }
            }]
        },function(chart){
            var j = 9;

            $.each(chart.series[0].data, function(i,data){
                for (var n = 0; n <= j; n++) {
                    /*if(n % 2 == 0) chart.series[0].data[n].update({color:'#44a441'});
                    else chart.series[0].data[n].update({color:'#a9c7ff'});*/
                    if(n % 2 == 0) chart.series[0].data[n].update({
                        color: {
                            linearGradient: {
                                x1: 0,
                                x2: 0,
                                y1: 0,
                                y2: 1
                            },
                            stops: [
                                [0, '#127a2c'],
                                [1, '#ffc226']
                            ]
                        }
                    });
                    else chart.series[0].data[n].update({color:'#5470C6'});
                }
            });
        });
    }

    tabcettar();

    tabaspek = function () {
        var url = base_url + "/apps/gridrekapaspek";
        var param = {
            tahun: $('#tahun').val(),
            tag:'kab'
        };

        var tahun=$("#tahun").val();
        var req = $.post(url, param).done(function (data) {
            if (data) grafikaspek(data, tahun);
        });
    }
    grafikaspek = function(data,tahun){
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
                            if (value['id_aspek'] == 'K01'){
                                a[j] = parseFloat(value['nilai_akhir']);
                                ma.push({unit:value['unit'], 'nilai':a[j]});
                            }
                            if (value['id_aspek'] == 'K02') {
                                b[j] = parseFloat(value['nilai_akhir']);
                                mb.push({unit:value['unit'], 'nilai':b[j]});
                            }
                            if (value['id_aspek'] == 'K03') {
                                c[j] = parseFloat(value['nilai_akhir']);
                                mc.push({unit:value['unit'], 'nilai':c[j]});
                            }
                            if (value['id_aspek'] == 'K04') {
                                d[j] = parseFloat(value['nilai_akhir']);
                                md.push({unit:value['unit'], 'nilai':d[j]});
                            }
                            if (value['id_aspek'] == 'K05') {
                                e[j] = parseFloat(value['nilai_akhir']);
                                me.push({unit:value['unit'], 'nilai':e[j]});
                            }
                            if (value['id_aspek'] == 'K06') {
                                f[j] = parseFloat(value['nilai_akhir']);
                                mf.push({unit:value['unit'], 'nilai':f[j]});
                            }
                        }
                    });
                }
            }
            if (kategori[i] == 'Cepat'){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[], flags=[];

                ma.sort(function(a,b){ return b.nilai-a.nilai});
                console.log(ma);
                for (var x = 0; x < ma.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && ma[x]['nilai'] == value['nilai_akhir'] && ma[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tercepat").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Tercepat dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTercepat',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: ma
                });*/

            }
            if (kategori[i] == 'Efektif & Efisien'){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                mb.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mb.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mb[x]['nilai'] == value['nilai_akhir'] && mb[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terefektif").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Terefektif & Efisien dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTerefektif',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: mb
                });*/
            }
            if (kategori[i] == 'Tanggap'){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                mc.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mc.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mc[x]['nilai'] == value['nilai_akhir'] && mc[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tertanggap").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Tertanggap dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTertanggap',judul,chartSeriesData, chartSeriesColor, chartUnit);

                /* series.push({
                     name: kategori[i], data: mc
                 });*/
            }
            if (kategori[i] == 'Transparan'){
                var chartSeriesData=[];
                var chartSeriesColor=[], chartUnit=[];
                md.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < md.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && md[x]['nilai'] == value['nilai_akhir'] &&  md[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-tertransparan").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Tertransparan dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTertransparan',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: md
                });*/
            }
            if (kategori[i] == 'Akuntabel'){
                var chartSeriesData=[];
                var chartSeriesColor=[];
                var chartUnit=[];
                me.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < me.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && me[x]['nilai'] == value['nilai_akhir'] && me[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terakuntabel").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Terakuntabel dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTerakuntabel',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: me
                });*/
            }
            if (kategori[i] == 'Responsive'){
                var chartSeriesData=[];
                var chartSeriesColor=[];
                var chartUnit =[];
                mf.sort(function(a,b){ return b.nilai-a.nilai});
                for (var x = 0; x < mf.length; x++) {
                    if(x < 5){
                        if(x==0) color = '#127a2c';
                        else color = '#a9c7ff';
                        if (data) {
                            y=0;
                            $.each(data, function (key, value) {
                                if(kategori[i]==value['aspek'] && mf[x]['nilai'] == value['nilai_akhir'] && mf[x]['unit'] == value['unit']) {
                                    y++;
                                    //if(x==0) $(".lbl-terresponsif").html(value['unit']);
                                    var l = '<a href="'+base_url +'/read/kab/'+value['id_unit_hash']+'">'+value['unit'].toUpperCase()+'</a>';
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
                var judul= '5 Kabupaten/Kota Terresponsif dalam CETTAR Tahun '+ $("#tahun").val();
                generatechart('chartTerresponsif',judul,chartSeriesData, chartSeriesColor, chartUnit);
                /*series.push({
                    name: kategori[i], data: mf
                });*/
            }
        }


    }

    tabaspek();

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

            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false
                    },
                    stacking: 'normal',
                    /*colors: ['#FF530D', '#E82C0C', '#FF0000', '#E80C7A', '#E80C7A']*/
                }
            },
            legend: {
                enabled:false
            },
            xAxis: {
                categories: chartUnit,
                title: {
                    text: null
                },
                crosshair : true,
                labels: {
                    style: {
                        fontTransform: 'uppercase',
                        fontWeight: 'normal',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || '#000'
                    },
                    formatter: function() {
                        return  this.value.toUpperCase();
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
                type: 'bar',
                name: 'Nilai',
                pointWidth: 40,
                data:chartSeriesData,
                dataLabels: {
                    enabled: false,
                    rotation: 0,
                    color: '#444',
                    align: 'center',
                    format: '{point.y:.2f}', // one decimal
                    y: 0
                }
            }]
        },function(chart){
            var j = 4;

            $.each(chart.series[0].data, function(i,data){
                for (var n = 0; n <= j; n++) {
                    /*if(n % 2 == 0) chart.series[0].data[n].update({color:'#44a441'});
                    else chart.series[0].data[n].update({color:'#a9c7ff'});*/
                    if(n % 2 == 0) chart.series[0].data[n].update({
                        /*color:'#a90000'*/
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
                    });
                    else chart.series[0].data[n].update({color:'#5470C6'});
                }
            });
        });
    }

});