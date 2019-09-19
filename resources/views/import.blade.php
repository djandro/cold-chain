@extends('layouts.app')

@section('content')


<section class="import m-t-30">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 importBox1">

                    <form class="form-horizontal" method="post" id="parseRecordForm" action="{{ route('import_parse') }}" enctype="multipart/form-data" accept-charset="UTF-8">

                        <div class="sufee-alert alert with-close alert-success alert-dismissible fade d-none" id="successBoxAlert">
                            <span class="badge badge-pill badge-success">Success</span>
                            You successfully save record data with ID {ID}. <a href="/records/{ID}" class="alert-link">See details on this link.</a>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                        </div>

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

                                <span class="text-small m-l-10 m-r-10">or</span>

                                <button type="button" class="btn btn-secondary" id="generateRecordBtn">
                                    <i class="fa fa-circle"></i>
                                    Generate data
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
                                                <input type="hidden" id="user-id" name="user-id" value="{{ Auth::user()->id }}" />
                                                <label class="form-control-label">File name:</label>
                                            </div>
                                            <div class="col-12 col-md-9 m-b-10">
                                                <p id="file-name-data" class="form-control-static badge badge-light"></p>
                                            </div>

                                            <div class="col col-md-3 m-b-10">
                                                <label class="form-control-label">Device:</label>
                                            </div>
                                            <div class="col-12 col-md-9 m-b-10">
                                                <p id="device-data" class="form-control-static badge badge-light"></p>
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

                                    <div class="col-sm-12">
                                        <div class="alert alert-danger m-b-0 d-none" role="alert"></div>
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

    function getProductSelectList(id, data){
        $select = '<select name="'+ id + '" id="' + id + '" class="form-control">';
        $.each(data,function(key, value)
        {
            $select += ('<option value=' + value.id + '>' + value.name + '</option>');
        });
        $select += '</select>';

        return $select;
    }

    function checkHeaderSelectedData(element) {
        var $element = element;
        var value = $element.val();
        var $headersSelect = jQuery('#csvDataTable tr:last-child select');

        jQuery.each($headersSelect.not($element), function() { //loop all remaining select elements
            var subValue = jQuery(this).val();
            if ((subValue === value) && (value != '--ignore--')) { // if value is same reset
                alert(value + " header column already selected.");
                console.log('resetting ' + $(this).attr('id')); // demo purpose
            }
        });
    }

    function getHeaderSelectedData(){
        var tempArr = [], $headersSelect = jQuery('#csvDataTable tr:last-child select');

        jQuery.each($headersSelect, function(key, value){
            tempArr.push({id: value.name, value: value.value});
        });

        return tempArr;
    }

    jQuery( document ).ready( function( jQuery ) {

        jQuery('#parseRecordForm').on('submit', function(e) {
            e.preventDefault();

            jQuery("#successBoxAlert").addClass('d-none');

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
                    jQuery('#device-data').html(data.device);
                    jQuery('#product-data').html(getProductSelectList('product-select', data.product.original));
                    jQuery('#location-data').html(getProductSelectList('location-select', data.location.original));

                    jQuery('#temporary-table-id').val(data.temporary_table_id);
                    jQuery('#samples-data').html(data.samples);
                    jQuery('#start-date-data').html(data.start_date);
                    jQuery('#end-date-data').html(data.end_date);
                    jQuery('#delay-data').html(data.delay);
                    jQuery('#interval-data').html(data.interval);

                    jQuery('#parseRecordForm div.alert-danger').addClass('d-none');

                    jQuery('#csvDataTable tr:last-child select').on('change', function (e) {
                        checkHeaderSelectedData(jQuery(this));
                    });
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
            params['url'] = "{{ route('save_import') }}";
            params['data'] = JSON.stringify({
                headers_data: getHeaderSelectedData(),

                title: jQuery('#title-input').val(),
                comment: jQuery('#comment-input').val(),
                file_name: jQuery('#file-name-data').text(),

                product: jQuery('#product-select').val(),
                location: jQuery('#location-select').val(),

                temporary_table_id: jQuery('#temporary-table-id').val(),
                user_id: jQuery('#user-id').val(),
                samples: jQuery('#samples-data').text(),
                start_date: jQuery('#start-date-data').text(),
                end_date: jQuery('#end-date-data').text(),
                delay: jQuery('#delay-data').text(),
                interval: jQuery('#interval-data').text()
            });
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    jQuery('#successBoxAlert').html(jQuery('#successBoxAlert').html().replace(/{ID}/g, data.details.id));
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                    jQuery("#submitRecordForm").trigger('reset');
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#submitRecordForm .alert').text(jqXHR.responseText);
                jQuery('#submitRecordForm .alert').removeClass('d-none');
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
            jQuery('#submitRecordForm .alert').addClass('d-none');
            setTimeout(function(){
                jQuery('.importBox2').addClass('d-none');
            }, 600);
        });

    });
</script>
@endsection

