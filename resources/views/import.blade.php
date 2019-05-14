@extends('layouts.app')

@section('content')


<section class="import m-t-30">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 importBox1">

                    <form class="form-horizontal" method="post" id="parseRecordForm" action="{{ route('import_parse') }}" enctype="multipart/form-data" accept-charset="UTF-8">

                        <div class="card">
                            <div class="card-header"><strong>Import</strong> record data</div>
                            <div class="card-body">
                                <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                    <label for="csv_file" class="col-md-4 control-label"><i>{{ 'Support ' . implode(', ', config('app.record_mimes')) . ' files' }}</i></label>

                                    <div class="col-md-6">
                                        <input id="csv_file" type="file" class="form-control-file m-t-10 m-b-10" name="csv_file" required>

                                        <div class="alert alert-danger m-t-20 d-none" role="alert"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="header" checked> File contains header row?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="parseRecordBtn">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Parse CSV
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="col-sm-12 importBox2 m-t-20 d-none no-opacity">
                    <form class="form-horizontal" method="POST" id="submitRecordForm" action="{{ route('save_import') }}" enctype="multipart/form-data" accept-charset="UTF-8">

                        <div class="card border border-secondary">
                            <div class="card-header"><strong>Complete</strong> record data</div>
                            <div class="card-body">

                                <h4 class="display-5">Define headers data:</h4>
                                <div class="csvDataBox m-b-20"></div>

                                <div class="otherDataBox row m-b-10">
                                    <div class="col-sm-6">
                                        <h4 class="display-5">Title:</h4>
                                        <div class="form-group">
                                            <input type="text" id="title-input" name="title-input" placeholder="Title" class="form-control">
                                        </div>
                                        <h4 class="display-5">Comment:</h4>
                                        <div class="form-group">
                                            <textarea name="comment-input" id="comment-input" rows="5" placeholder="Comment..." class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4 class="display-5">File report:</h4>
                                        <div class="row form-group">
                                            <div class="col col-md-3 m-b-10">
                                                <input type="hidden" id="temporary-table-id" name="temporary-table-id" />
                                                <label class="form-control-label">File name:</label>
                                            </div>
                                            <div class="col-12 col-md-9 m-b-10">
                                                <p id="file-name-data" class="form-control-static badge badge-light"></p>
                                            </div>
                                            <div class="col col-md-3 m-b-10">
                                                <label class="form-control-label">Product:</label>
                                            </div>
                                            <div class="col-12 col-md-9 m-b-10" id="product-data">
                                            </div>

                                            <div class="col col-md-3 m-b-10">
                                                <label class="form-control-label">Location:</label>
                                            </div>
                                            <div class="col-12 col-md-9 m-b-10" id="location-data">
                                            </div>

                                            <div class="col-sm-12">
                                                <hr/>
                                            </div>

                                            <div class="col col-md-3">
                                                <label class="form-control-label">Start Date:</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="start-date-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                            <div class="col col-md-3">
                                                <label class="form-control-label">End Date:</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="end-date-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                            <div class="col-sm-12">
                                                <hr/>
                                            </div>

                                            <div class="col col-md-3">
                                                <label class="form-control-label">No.Samples:</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="samples-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                            <div class="col col-md-3">
                                                <label class="form-control-label">Delay time:</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="delay-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                            <div class="col col-md-3">
                                                <label class="form-control-label">Interval:</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="interval-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="submitRecordBtn">
                                    <i class="fa fa-plus-circle"></i> Import Data
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    <i class="fa fa-ban"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script type="application/javascript" defer>

    var doAjax_params_default = {
        'url': null,
        'requestType': "POST",
        'contentType': 'application/json',
        'headers': { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
        'dataType': 'json',
        'data': {},
        'beforeSendCallbackFunction': null,
        'successCallbackFunction': null,
        'completeCallbackFunction': null,
        'errorCallBackFunction': null
    };

    function doAjax(doAjax_params) {

        var url = doAjax_params['url'];
        var requestType = doAjax_params['requestType'];
        var contentType = doAjax_params['contentType'];
        var headers = doAjax_params['headers'];
        var dataType = doAjax_params['dataType'];
        var data = doAjax_params['data'];
        var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
        var successCallbackFunction = doAjax_params['successCallbackFunction'];
        var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
        var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

        jQuery.ajax({
            url: url,
            type: requestType,
            contentType: contentType,
            processData: false,
            headers: headers,
            dataType: dataType,
            data: data,
            xhr: function(){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        jQuery('.progress.header-progress .progress-bar').css({
                            width: percentComplete * 100 + '%'
                        });
                        if (percentComplete === 1) {
                            jQuery('.progress.header-progress .progress-bar').addClass('hide');
                        }
                    }
                }, false);
                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        jQuery('.progress.header-progress .progress-bar').css({
                            width: percentComplete * 100 + '%'
                        });
                    }
                }, false);
                return xhr;
            },
            beforeSend: function(jqXHR, settings) {
                if (typeof beforeSendCallbackFunction === "function") {
                    beforeSendCallbackFunction();
                }
            },
            success: function(data, textStatus, jqXHR) {
                if (typeof successCallbackFunction === "function") {
                    successCallbackFunction(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (typeof errorCallBackFunction === "function") {
                    errorCallBackFunction(jqXHR);
                }

            },
            complete: function(jqXHR, textStatus) {
                if (typeof completeCallbackFunction === "function") {
                    completeCallbackFunction();
                }
            }
        });
    }

    function getProductSelectList(id, data){
        $select = '<select name="'+ id + '" id="' + id + '" class="form-control">';
        $.each(data,function(key, value)
        {
            $select += ('<option value=' + key + '>' + value + '</option>');
        });
        $select += '</select>';

        return $select;
    }

    jQuery( document ).ready( function( jQuery ) {

        jQuery('#parseRecordForm').on('submit', function(e) {
            e.preventDefault();

            var params = jQuery.extend({}, doAjax_params_default);
            params['url'] = '{{ route('import_parse') }}';
            params['contentType'] = false;
            params['data'] = new FormData(this);
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    jQuery('#parseRecordForm div.alert-danger').removeClass('d-none').text('Something goes wrong.');
                }
                else {
                    jQuery('.importBox1').addClass('disableBox');
                    jQuery('.importBox2').removeClass('d-none').removeClass('no-opacity');
                    jQuery('.importBox2 .csvDataBox').html(data.headers_data);

                    jQuery('#title-input').val(data.title);
                    jQuery('#comment-input').val(data.comment);

                    jQuery('#file-name-data').html(data.file_name);
                    jQuery('#product-data').html(getProductSelectList('product-select', data.product.original));
                    jQuery('#location-data').html(getProductSelectList('location-select', data.location.original));

                    jQuery('#temporary-table-id').val(data.temporary_table_id);
                    jQuery('#samples-data').html(data.samples);
                    jQuery('#start-date-data').html(data.start_date);
                    jQuery('#end-date-data').html(data.end_date);
                    jQuery('#delay-data').html(data.delay);
                    jQuery('#interval-data').html(data.interval);

                    jQuery('#parseRecordForm div.alert-danger').addClass('d-none');
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                jQuery('#parseRecordForm div.alert-danger').removeClass('d-none').text(jqXHR.responseText);
            };
            doAjax(params);
        });


        jQuery('#submitRecordForm').on('submit', function(e) {
            e.preventDefault();

            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            var params = jQuery.extend({}, doAjax_params_default);
            params['url'] = '{{ route('save_import') }}';
            params['data'] = JSON.stringify({
                headers_data: null,

                title: jQuery('#title-input').val(),
                comment: jQuery('#comment-input').val(),
                file_name: jQuery('#file-name-data').text(),

                product: jQuery('#product-select').val(),
                location: jQuery('#location-select').val(),

                temporary_table_id: jQuery('#temporary-table-id').val(),
                samples: jQuery('#samples-data').text(),
                start_date: jQuery('#start-date-data').text(),
                end_date: jQuery('#end-date-data').text(),
                delay: jQuery('#delay-data').text(),
                interval: jQuery('#interval-data').text()
            });
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo prit failed data
                    console.log(data.fail);
                }
                else {
                    // todo print success
                   console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                console.log(jqXHR);
            };
            doAjax(params);

        });

        jQuery('#submitRecordForm').on('reset', function(e) {
            e.preventDefault();
            jQuery('#parseRecordForm').trigger("reset");
            jQuery('.importBox1').removeClass('disableBox');
            jQuery('.importBox2').addClass('no-opacity');
            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            setTimeout(function(){
                jQuery('.importBox2').addClass('d-none');
            }, 600);
        });

    });
</script>
@endsection

