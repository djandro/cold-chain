@extends('layouts.app')

@section('content')
<!-- RECORD -->
<section class="record">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-5">
                        <span id="recordTitle" data-id="{{ $record->id }}">Record {{ $record->id }} {!! !empty($record->title) ? " - " . $record->title : '' !!}</span>
                        <span class="btn-records-box float-right">
                            <button type="button" class="btn btn-sm btn-outline-link" data-toggle="modal" data-target="#editRecordModal" data-backdrop="false"><i class="zmdi zmdi-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-link" data-toggle="modal" data-target="#deleteRecordModal" data-backdrop="false"><i class="zmdi zmdi-delete"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-link" id="btnDownloadPdf"><i class="zmdi zmdi-download"></i></button>
                        </span>
                    </h3>
                </div>
            </div>

            @include('partials.alertbox')

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
                                            <label class="form-control-label" title="Recommended Storage temperature">Storage T (interval):</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <p id="sl-storage-data" class="form-control-static badge badge-light" title="Recommended Storage temperature">{{ $record->product['storage_t'] }}C</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label class="form-control-label" title="Shelf Life at recommended temperature in days">SL-Ref:</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <p id="sl-slt-data" class="form-control-static badge badge-light" title="Shelf Life at recommended temperature in days">{{ $record->product['slt'] }} day(s)</p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-4">
                                            <label for="select" class=" form-control-label" title="Previously used Shelf Life in days">Shelf Life</label>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <select name="sl-temp" id="sl-temp" class="form-control">
                                                @for ($i = 0; $i < count($prev_sl_range); $i++)
                                                    <option value="{{ $prev_sl_range[$i] }}">{{ $prev_sl_range[$i] }} days</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="d-block text-right">Remain Shelf Life - SLR (CSIRO): <span class="role admin" id="slrCsiroValue">{{ $slrCSIRO_value }} days</span></p>
                                    <p class="d-block text-right m-t-10">Remain Shelf Life - SLR (SAL): <span class="role member" id="slrSalValue">{{ $slrSAL_value }} days</span></p>
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

            <!-- modal edit record -->
            <div class="modal fade" id="editRecordModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                <form id="editRecordForm" action="#" method="post" enctype="multipart/form-data" class="form-horizontal" _lpchecked="1">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediumModalLabel">Edit record {{ $record->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col col-md-3 text-right">
                                        <label for="location-input-name" class="form-control-label">Name *</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="location-input-name" name="location-input-name" placeholder="Refrigerator" class="form-control" required>
                                        <input type="hidden" id="location-input-id" name="location-input-id">
                                        @csrf
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3 text-right">
                                        <label for="select" class="form-control-label">Product</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="location-input-color" id="location-input-color" class="form-control">
                                            <option value="yellow">Yellow</option>
                                            <option value="red">Red</option>
                                            <option value="blue">Blue</option>
                                            <option value="green">Green</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3 text-right">
                                        <label for="location-input-desc" class="form-control-label">Comments</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <textarea name="location-input-desc" id="location-input-desc" rows="4" placeholder="Content..." class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-12">
                                        <div class="alert alert-danger m-b-0 d-none" role="alert"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnCancelLocationFrom" type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                                <button id="btnSaveLocationForm" type="submit" class="btn btn-success"><i class="fa fa-dot-circle-o"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end modal edit record -->

            <!-- modal delete record -->
            <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body"><p>Are you sure you want to delete record {{ $record->id }} ?</p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-delete-record">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal delete record -->

            <div id="elementH"></div>

            @if(Auth::user()->hasRole('admin'))

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

            @endif

        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js" crossorigin="anonymous"></script>
<script src="http://code.highcharts.com/modules/exporting.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha256-c3RzsUWg+y2XljunEQS0LqWdQ04X1D3j22fd/8JCAKw=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha256-DupmmuWppxPjtcG83ndhh/32A9xDMRFYkGOVzvpfSIk=" crossorigin="anonymous"></script>
<script>
    (function ($) {
        // Use Strict
        "use strict";
        try {

            var graph = document.getElementById("lineChart");
            if (graph) {
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
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!} -1, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}), // -1 in month because js start month with 0
                            pointInterval: {!! $record->intervals !!} * 1000 // miliseconds
                        },{
                            type: 'spline',
                            name: 'Humiditee',
                            yAxis: 0,
                            tooltip: { valueSuffix: ' %' },
                            marker: { enabled: false },
                            data: {!! $recordDataHumidity !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!} -1, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!} * 1000
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
                    visible: false
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
                }, {
                    opposite:true,
                    title: {
                        text: 'Days',
                        style: { color: '#e14f5d' }
                    },
                    labels: {
                        style: { color: '#e14f5d' }
                    }
                }],
                plotOptions: {
                    area: {
                        marker: { radius: 2 },
                        lineWidth: 1,
                            states: { hover: { lineWidth: 1  } },
                        threshold: null
                    },
                    series: { fillOpacity: 0.2 }
                },
                series: [{
                            type: 'area',
                            name: 'Temp',
                            yAxis: 1,
                            color: '#7cb5ec',
                            tooltip: { valueSuffix: ' C' },
                            marker: { enabled: false },
                            data: {!! $recordDataTemperature !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!} -1, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!} * 1000
                        },{
                            type: 'spline',
                            name: 'SL (CSIRO)',
                            yAxis: 2,
                            color: '#e14f5d',
                            marker: { enabled: false },
                            data: {!! $slrCSIRO_data !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!} -1, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!} * 1000
                        },{
                            type: 'spline',
                            name: 'SL (SAL)',
                            yAxis: 2,
                            color: '#36ac51',
                            marker: { enabled: false },
                            data: {!! $slrSAL_data !!},
                            pointStart: Date.UTC({!!$recordDataStartDate[0]!!}, {!!$recordDataStartDate[1]!!} -1, {!!$recordDataStartDate[2]!!}, {!!$recordDataStartDate[3]!!}, {!!$recordDataStartDate[4]!!}, {!!$recordDataStartDate[5]!!}),
                            pointInterval: {!! $record->intervals !!} * 1000
                        }]
            });
        }

    } catch (err) {
        console.log(err);
    }
    })(jQuery);
</script>
<script>
    jQuery( document ).ready( function( jQuery ) {

        // ON CHANGE SL DROPDOWN
        jQuery('#sl-temp').on('change', function(e) {

            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            var days = this.value;
            var recordId = jQuery("#recordTitle").data('id');
            var params = jQuery.extend({}, doAjax_params_default);

            params['url'] = "/api/record/update_sldata/" + recordId + "/" + days;
            params['requestType'] = "GET";

            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success

                    jQuery("#slrCsiroValue").text(data.slrCSIRO_value + " Days");
                    jQuery("#slrSalValue").text(data.slrSAL_value + " Days");

                    var chart = jQuery('#shelfLifeChart').highcharts();

                    chart.series[1].update({
                        data: data.slrCSIRO_data
                    }, false);

                    chart.series[2].update({
                        data: data.slrSAL_data
                    }, false);

                    chart.redraw();
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                console.log(jqXHR);
            };
            doAjax(params);

        });

        // DELETE RECORD
        jQuery("#deleteRecordModal").on('click', "button.btn-delete-record", function(){
            var $modal = jQuery("#deleteRecordModal");
            var id = jQuery("#recordTitle").data('id');
            var params = jQuery.extend({}, doAjax_params_default);
            params['url'] = "/api/record/delete/"+id;
            params['requestType'] = 'DELETE';
            params['data'] = JSON.stringify({
                "id": id
            });
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    jQuery('#successBoxAlert .successText').text("You successfully delete data with ID " + data.id + ". Redirecting to Records...");
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    window.location = "/records";
                }
                $modal.modal('hide');
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#errorAlertBox').text(jqXHR.responseText);
                jQuery('#errorAlertBox').removeClass('d-none');
                $modal.modal('hide');
                console.log(jqXHR);
            };
            doAjax(params);
        });

        // PDF
        var doc = new jsPDF();
        //var elementHTML = jQuery('.record').html();

        jQuery('#btnDownloadPdf').click(function () {
            doc.html(document.body, {
                callback: function (doc) {
                    doc.save('Record-{{ $record->id }}.pdf');
                }
            });
        });
    });
</script>
@endsection
