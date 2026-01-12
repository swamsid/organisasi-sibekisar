$(document).ready(function () {
    var aPos="";
    var aData="";
    
    $(".select2").select2();

    $(".filter-cettar").hide();
    $(".filter-aspek").show();

    $("#tahun").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    $("#tag").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap(true);
        // alert('okee');
    });

    $("#id_unit").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });
    $("#id_aspek").on('change',function(){
        $('#layout').fadeIn(500);
        tabrekap();
    });

    tabrekap = function (resetUnit = false) {
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

            if(resetUnit){
                let html = `<option value="">- Semua ${ $('#tag').val() } -</option>`;

                data.eval.forEach(function(data, index){
                    html += `<option value="${data['id_unit']}">${data['unit']}</option>`    
                })

                $('#id_unit').html(html);
            }

            if (data) grafikaspek(data.eval, tahun, id_aspek);
            $('#div-rekap').html("");
            $('#layout').fadeOut(500);
        }).always(function () {});
    }


    tabrekap(true);

    grafikaspek = function(data,tahun,id_aspek){

        let chartSeriesData=[];
        let chartSeriesColor=[], chartUnit=[], flags=[];

        data.sort(function(a, b){ return parseFloat(b.nilai_akhir) - parseFloat(a.nilai_akhir) }).forEach((z, alpha) => {
            let l = '<a href="'+base_url +'/read/'+$("#tag").val()+'/'+z['id_unit_hash']+'?t='+$('#tahun').val()+'">'+z['unit'].toUpperCase()+'</a>';
            let seriesColor = (alpha == 0) ? '#127a2c' : '#a9c7ff';
            let series = [l, parseFloat(z['nilai_akhir'])];
            chartSeriesData.push(series);
            // chartSeriesColor.push(seriesColor);
            chartUnit.push(l);
        })

        let judul = $("#lblunit").val() + ' dalam CETTAR Tahun '+ $("#tahun").val();
        generatechart('chart', judul, chartSeriesData, chartSeriesColor, chartUnit);
    }

    generatechart = function(chart, judul, chartSeriesData, chartSeriesColor, chartUnit){
        $('#'+chart).highcharts({
            title: {
                text: '',
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
                gridLineWidth: 5,
                paddingWidth: 6,
                labels: {
                    enabled: false,
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
                    enabled: true,
                    align: 'left',
                    format: '{x}',
                    style: {
                        color       : '#fff !important',
                        textOutline : 'none',
                        lineWidth   : 1,
                        width       : 2,
                        fontWeight  : '600'

                    }
                },
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#03e694'],
                        [1, '#026e47']
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
});