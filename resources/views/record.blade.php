@extends('layouts.app')

@section('content')
<!-- RECORD -->
<section class="record">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-5">
                        <span>Record {{ $record->id }}</span>
                        <span class="btn-records-box float-right">
                            <a href="#" onclick="return;" class="btn btn-sm btn-outline-link"><i class="zmdi zmdi-edit"></i></a>
                            <a href="#" onclick="return;" class="btn btn-sm btn-outline-link"><i class="zmdi zmdi-delete"></i></a>
                            <a href="#" onclick="return;" class="btn btn-sm btn-outline-link"><i class="zmdi zmdi-download"></i></a>
                        </span>
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">

                    <div class="jumbotron record-comment-box">
                        <p><small><i>Uploaded userid {{$record->user_id}} at {{$record->created_at}}.</i></small></p>
                        <p>Comments: {{$record->comments}}</p>
                    </div>

                    <div class="alert alert-success record-alert-box" role="alert">
                        <h4 class="alert-heading">Well done!</h4>
                        <p class="card-text">
                            {{ $record }}
                        </p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    </div>

                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Well done!</h4>
                        <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so
                            that you can see how spacing within an alert works with this kind of content.</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card border border-primary record-details-box">
                        <div class="card-body">

                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">File name:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="file-name-data" class="form-control-static badge badge-light">{{$record->file_name}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Product:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="product-data" class="form-control-static badge badge-light">{{$record->product_id}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Location:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="location-data" class="form-control-static badge badge-light">{{$record->location_id}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Device:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="device-data" class="form-control-static badge badge-light">{{$record->device_id}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Samples:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="samples-data" class="form-control-static badge badge-light">{{$record->samples}}</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Start Date:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="start_date-data" class="form-control-static badge badge-light">{{$record->start_date}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">End Date:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="end_date-data" class="form-control-static badge badge-light">{{$record->end_date}}</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Delay time:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="delay_time-data" class="form-control-static badge badge-light">{{$record->delay_time}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Interval:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="intervals-data" class="form-control-static badge badge-light">{{$record->intervals}}</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="table-responsive">
                                <table class="table table-top-campaign">
                                    <thead>
                                        <tr>
                                            <th>Limits</th>
                                            <th>Value</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Low T</td>
                                        <td class="project-color-1">$70,2</td>
                                        <td>$70,2</td>
                                    </tr>
                                    <tr>
                                        <td>Hight T</td>
                                        <td class="project-color-1">$46,3</td>
                                        <td>$46,3</td>
                                    </tr>
                                    <tr>
                                        <td>Low H</td>
                                        <td class="project-color-1">$35,3</td>
                                        <td>$35,3</td>
                                    </tr>
                                    <tr>
                                        <td>Hight H</td>
                                        <td class="project-color-1">$35,3</td>
                                        <td>$35,3</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="row record-graph-box">
                <div class="col-sm-12 m-t-20 m-b-20">
                    <div id="lineChart" style="height: 500px;"></div>
                </div>
            </div>

            <div class="row record-table-box">
                <div class="col-sm-12 m-t-20 m-b-20">todo record table</div>
            </div>

            <hr/>

            <div class="row shelf-life-box">
                <div class="col-sm-12 m-t-20 m-b-20">todo Shelf Life Box</div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="m-t-40 m-b-20">record data</h4>

                    {{ $recordData }}

                    <hr/>

                    {{ $recordDataTimestamp[1] }}
                    {{ $timestamp = strtotime( $recordDataTimestamp[0] ) }}
                    {{ date('Y-m-d H-i-s', $timestamp ) }}

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
