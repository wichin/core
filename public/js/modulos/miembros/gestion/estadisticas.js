$(document).ready(function () {

});

function echarPie(div, info,ttl)
{
    var echartDonut = echarts.init(document.getElementById(div), theme);

    echartDonut.setOption({
        title: {
            textStyle: {
                color:'#395067'
            },
            text: ttl
        },
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
        grid: {
            left: '1%',
            right: '1%',
            bottom: '2%',
            containLabel: true
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
                saveAsImage: {
                    show: true,
                    title: "Descargar"
                }
            }
        },
        series: [{
            name: ttl,
            type: 'pie',
            radius: ['40%', '65%'],
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

function echarHorizontalBar(div,info,ttl)
{
    var echartBar = echarts.init(document.getElementById(div), theme);

    echartBar.setOption({
        title: {
            textStyle: {
                color:'#395067'
            },
            text: ttl
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            show: false,
            x: 200,
            data: ['Evento']
        },
        grid: {
            left: '1%',
            right: '1%',
            bottom: '2%',
            containLabel: true
        },
        toolbox: {
            show: true,
            feature: {
                saveAsImage: {
                    show: true,
                    title: "Descargar"
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