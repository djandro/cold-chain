@extends('layouts.app')

@section('content')
<!-- RECORD -->
<section class="record">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-3">Record {{ $record->id }}</h3>
                    <div class="jumbotron">
                        todo record comments, buttons
                    </div>
                </div>
            </div>

            {{ $recordDataTimestamp[1] }}
            {{ $timestamp = strtotime( $recordDataTimestamp[0] ) }}
            {{ date('Y-m-d H-i-s', $timestamp ) }}

            <div class="row">
                <div class="col-sm-12">
                    <p>{{ $record }}</p>
                </div>

                <div class="col-sm-8 m-t-20">
                    <h4 class="m-t-20">Graph</h4>

                    <div id="lineChart" style="height: 500px;"></div>

                </div>

                <div class="col-sm-12">
                    <h4 class="m-t-20 m-b-10">record data</h4>

                    {{ $recordData }}
                </div>

            </div>


        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection

@section('scripts')
<script>
    (function ($) {
        // Use Strict
        "use strict";
        try {

            var graph = document.getElementById("lineChart");
            if (graph) {

                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });

                Highcharts.chart('lineChart', {
                    chart: {
                        zoomType: 'x'
                    },
                    title: {
                        text: 'Recorded data'
                    },
                    tooltip: {
                        shared: true
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            format: '{value:%Y-%b-%e. %H:%M:%S}',
                            align: 'right',
                            rotation: -30
                        },
                        categories: {!! $recordDataTimestamp !!}
                        //min: {!! strtotime($recordDataTimestamp[0]) !!},
                        //tickInterval: 1000 * 10
                    },
                    yAxis: [{
                        title: {
                            text: 'Humidity',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        },
                        labels: {
                            format: '{value} %',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        }
                    }, {
                        title: {
                            text: 'Temperature',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        tooltip: {
                            valueSuffix: ' C'
                        },
                        labels: {
                            format: '{value} C',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        }
                    }],
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                                states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                    },
                    series: [{
                        type: 'spline',
                        name: 'Temp',
                        yAxis: 1,
                        tooltip: {
                            valueSuffix: ' C'
                        },
                        marker: {
                            enabled: false
                        },
                        data: {!! $recordDataTemperature !!}
                    },{
                        type: 'spline',
                        name: 'Humiditee',
                        yAxis: 0,
                        tooltip: {
                            valueSuffix: ' %'
                        },
                        marker: {
                            enabled: false
                        },
                        data: {!! $recordDataHumidity !!}
                    }]
                });
            }

        } catch (err) {
            console.log(err);
        }
    })(jQuery);
</script>
@endsection
