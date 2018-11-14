$(document).ready(function () {

});

function echarPie(div, info)
{
    var echartDonut = echarts.init(document.getElementById(div), theme);

    echartDonut.setOption({
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        calculable: true,
        legend: {
            x: 'center',
            y: 'bottom',
            /*data: ['Direct Access', 'E-mail Marketing', 'Union Ad', 'Video Ads', 'Search Engine']*/
            data: info[0]
        },
        toolbox: {
            show: true,
            feature: {
                magicType: {
                    show: true,
                    type: ['pie', 'funnel'],
                    option: {
                        funnel: {
                            x: '25%',
                            width: '50%',
                            funnelAlign: 'center',
                            max: 1548
                        }
                    }
                },
                restore: {
                    show: true,
                    title: "Restore"
                },
                saveAsImage: {
                    show: true,
                    title: "Save Image"
                }
            }
        },
        series: [{
            name: 'Access to the resource',
            type: 'pie',
            radius: ['30%', '55%'],
            itemStyle: {
                normal: {
                    label: {
                        show: true
                    },
                    labelLine: {
                        show: true
                    }
                },
                emphasis: {
                    label: {
                        show: true,
                        position: 'center',
                        textStyle: {
                            fontSize: '14',
                            fontWeight: 'normal'
                        }
                    }
                }
            },
            data: info[1]
        }]
    });
}

function echarHorizontalBar(div,info)
{
    var echartBar = echarts.init(document.getElementById(div), theme);

    echartBar.setOption({
        title: {
            text: 'Bar Graph',
            subtext: 'Graph subtitle'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            x: 200,
            data: ['Evento']
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: {
                    show: true,
                    title: "Guardar imagen"
                }
            }
        },
        calculable: false,
        xAxis: [{
            type: 'value',
            boundaryGap: [0, 0.01]
        }],
        yAxis: [{
            type: 'category',
            data: info[0]
        }],
        series: [{
            name: 'Evento',
            type: 'bar',
            data: info[1]
        }]
    });
}