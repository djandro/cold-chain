@extends('layouts.app')

@section('content')
<!-- RECORD -->
<section class="record">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-5">
                        <span>Record {{ $record->id }} {!! !empty($record->title) ? " - " . $record->title : '' !!}</span>
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
                        <p><small><i>Uploaded {{$record->user['name']}} {{ $record->created_at->diffForHumans()}}.</i></small></p>
                        <p>Comments: {{$record->comments}}</p>
                    </div>

                    <div class="alert alert-success record-alert-box" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="alert-heading">Findings!</h4>
                        <p class="card-text"></p>
                        <hr>
                        <p class="mb-0"><b>Location per time:</b></p>
                        @foreach($locationsPerTime as $loc)
                        <p class="mb-0">{{ $loc[0] }}: {{ $loc[1] }}</p>
                        @endforeach
                    </div>

                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="alert-heading">Warnings!</h4>
                        <hr>
                        <p>Alarms: {{ $record->alarms }}</p>
                        <p class="mb-0">Errors: {{ $record->errors }}</p>
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
                                    <p id="product-data" class="form-control-static badge badge-light">{{$record->product['name']}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Location:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="location-data" class="form-control-static badge badge-light">{{$locations}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Device:</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="device-data" class="form-control-static badge badge-light">{{$record->device['name']}}</p>
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
                                    <label class="form-control-label">Delay time (s):</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="delay_time-data" class="form-control-static badge badge-light">{{$record->delay_time}}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class="form-control-label">Interval (s):</label>
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
                                        <td class="project-color-1">{{ $recordLimits['min_t_value'] }}</td>
                                        <td>{{ $recordLimits['min_t_count'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hight T</td>
                                        <td class="project-color-1">{{ $recordLimits['max_t_value'] }}</td>
                                        <td>{{ $recordLimits['max_t_count'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Low H</td>
                                        <td class="project-color-1">{{ $recordLimits['min_h_value'] }}</td>
                                        <td>{{ $recordLimits['min_h_count'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hight H</td>
                                        <td class="project-color-1">{{ $recordLimits['max_h_value'] }}</td>
                                        <td>{{ $recordLimits['max_h_count'] }}</td>
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

            <hr/>

            <div class="row record-data-table-box">
                <div class="col-sm-12 m-t-20 m-b-20">

                    <div class="table-responsive">

                        <table id="recordsDataListTable" data-classes="table table-borderless table-striped table-earning"
                               data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true">

                            <thead>
                            <tr>
                                <th data-field="timestamp" data-sortable="true">Timestamp</th>
                                <th data-field="temperature" data-sortable="true">Temperature</th>
                                <th data-field="humidity" data-sortable="true">Humidity</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($recordData as $data)

                            <tr id="recordsDataRow-{{ $data->id }}">
                                <td data-field="timestamp">{{ $data->timestamp }}</td>
                                <td data-field="temperature">{{ $data->temperature }}</td>
                                <td data-field="humidity">{{ $data->humidity }}</td>
                            </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <hr/>

            <div class="row shelf-life-box">
                <div class="col-sm-12 m-t-20 m-b-20">
                    <h4>Shelf Life (SL) for product {{ $record->product['name'] }}</h4>
                    <div class="card border border-primary sl-details-box m-t-20">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label class="form-control-label">Storage T (interval):</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <p id="sl-storage-data" class="form-control-static badge badge-light">{{ $record->product['storage_t'] }}C</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label class="form-control-label">SL-Ref:</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <p id="sl-slt-data" class="form-control-static badge badge-light">{{ $record->product['slt'] }} day(s)</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="select" class=" form-control-label">Shelf Life</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <select name="sl-temp" id="sl-temp" class="form-control">
                                                <option value="0">0 days</option>
                                                <option value="1">3 days</option>
                                                <option value="2">5 days</option>
                                                <option value="3">10 days</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="d-block text-right">Remain Shelf Life - SLR (CSIRO): <span class="role member">{{ $slrCSIRO_value }} days</span></p>
                                    <p class="d-block text-right m-t-10">Remain Shelf Life - SLR (SAL): <span class="role user">{{ $slrSAL_value }} days</span></p>
                                </div>
                            </div>

                            <hr/>

                            <div class="row record-graph-box">
                                <div class="col-sm-12 m-t-40">
                                    <div id="shelfLifeChart" style="height: 500px;"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="m-t-40 m-b-20">record</h4>
                    {{ $record }}
                </div>
                <div class="col-sm-12">
                    <h4 class="m-t-40 m-b-20">record SLR (CSIRO)</h4>
                    {{ $slrCSIRO_data }}

                    <h4 class="m-t-40 m-b-20">record SLR (SAL)</h4>

                    {{ $slrSAL_data }}

                </div>
                <div class="col-sm-12">
                    <h4 class="m-t-40 m-b-20">record data</h4>

                    {{ $recordData }}

                    <h4 class="m-t-40 m-b-20">timestamps</h4>

                    {{ $recordDataTimestamp }}

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
                        useUTC: true
                    }
                });

                Highcharts.chart('lineChart', {
                    chart: { zoomType: 'x' },
                    title: { text: 'Recorded data' },
                    tooltip: { shared: true },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: {
                            second: '%Y-%m-%d<br/>%H:%M:%S',
                            minute: '%Y-%m-%d<br/>%H:%M',
                            hour: '%Y-%m-%d<br/>%H:%M',
                            day: '%Y<br/>%m-%d',
                            week: '%Y<br/>%m-%d',
                            month: '%Y-%m',
                            year: '%Y'
                        }
                    },
                    yAxis: [
                    {
                    // first line
                        opposite:true,
                        title: {
                            text: 'Humidity',
                            style: { color: Highcharts.getOptions().colors[1] }
                        },
                        tooltip: {
                            valueSuffix: ' %'
                        },
                        labels: {
                            format: '{value} %',
                            style: { color: Highcharts.getOptions().colors[1] }
                        }
                    },{
                    // second line
                        title: {
                            text: 'Temperature',
                            style: { color: Highcharts.getOptions().colors[0] }
                        },
                        tooltip: { valueSuffix: ' C' },
                        labels: {
                            format: '{value} C',
                            style: { color: Highcharts.getOptions().colors[0] }
                        }
                    }],
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]},
                            marker: { radius: 2 },
                            lineWidth: 1,
                            states: { hover: { lineWidth: 1 }},
                            threshold: null
                        }
                    },
                    series:[
                        {
                            type: 'spline',
                            name: 'Temp',
                            yAxis: 1,
                            tooltip: { valueSuffix: ' C' },
                            marker: { enabled: false },
                            data: {!! $recordDataTemperature !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!}, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!}
                        },{
                            type: 'spline',
                            name: 'Humiditee',
                            yAxis: 0,
                            tooltip: { valueSuffix: ' %' },
                            marker: { enabled: false },
                            data: {!! $recordDataHumidity !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!}, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!}
                        }]
                    });
    }

    } catch (err) {
        console.log(err);
    }
    })(jQuery);
</script>
<script>
    (function ($) {
        // Use Strict
        "use strict";
    try {
        var graph_self = document.getElementById("shelfLifeChart");
        if (graph_self) {

            Highcharts.setOptions({
                global: {
                    useUTC: true
                }
            });

            Highcharts.chart('shelfLifeChart', {
                chart: { zoomType: 'x' },
                title: { text: 'Shelf Life Graph'  },
                tooltip: {  shared: true },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        second: '%Y-%m-%d<br/>%H:%M:%S',
                        minute: '%Y-%m-%d<br/>%H:%M',
                        hour: '%Y-%m-%d<br/>%H:%M',
                        day: '%Y<br/>%m-%d',
                        week: '%Y<br/>%m-%d',
                        month: '%Y-%m',
                        year: '%Y'
                    }
                },
                yAxis: [{
                    opposite:true,
                    title: {
                        text: 'Days',
                        style: { color: Highcharts.getOptions().colors[3] }
                    },
                    labels: {
                        style: { color: Highcharts.getOptions().colors[3] }
                    }
                }, {
                    title: {
                        text: 'Temperature',
                        style: { color: Highcharts.getOptions().colors[0] }
                    },
                    tooltip: { valueSuffix: ' C' },
                    labels: {
                        format: '{value} C',
                        style: { color: Highcharts.getOptions().colors[0] }
                    }
                }, {}],
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: { x1: 0, y1: 0,x2: 0, y2: 1 },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.getOptions().colors[3]],
                                [2, Highcharts.getOptions().colors[4]]
                            ]
                        },
                        marker: { radius: 2 },
                        lineWidth: 1,
                            states: { hover: { lineWidth: 1  } },
                        threshold: null
                    }
                },
                series: [{
                            type: 'spline',
                            name: 'Temp',
                            yAxis: 0,
                            tooltip: { valueSuffix: ' C' },
                            marker: { enabled: false },
                            data: {!! $recordDataTemperature !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!}, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!}
                        },{
                            type: 'spline',
                            name: 'SL (CSIRO)',
                            yAxis: 1,
                            marker: { enabled: false },
                            data: {!! $slrCSIRO_data !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!}, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!}
                        },{
                            type: 'spline',
                            name: 'SL (SAL)',
                            yAxis: 2,
                            marker: { enabled: false },
                            data: {!! $slrSAL_data !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!}, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!}
                        }]
            });
        }

    } catch (err) {
        console.log(err);
    }
    })(jQuery);
</script>
@endsection
