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
                                    Parse file
                                </button>

                                <span class="text-small m-l-10 m-r-10">or</span>

                                <button type="button" class="btn btn-secondary" id="generateRecordBtn-12">
                                    <i class="fa fa-circle"></i>
                                    Generate data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @include('partials.import_parse_data')

                @include('partials.import_generate_data')

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

                    jQuery('#title-input-parseForm').val(data.title);
                    jQuery('#comment-input-parseForm').val(data.comment);

                    jQuery('#file-name-data').html(data.file_name);
                    jQuery('#device-data').html(data.device);
                    jQuery('#product-data').html(getProductSelectList('product-select', {!! getProducts() !!}));
                    jQuery('#location-data').html(getProductSelectList('location-select', {!! getLocations() !!}));

                    jQuery('#temporary-table-id').val(data.temporary_table_id);
                    jQuery('#headers_nr_rows').val(data.headers_nr_rows);
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

                title: jQuery('#title-input-parseForm').val(),
                comment: jQuery('#comment-input-parseForm').val(),
                file_name: jQuery('#file-name-data').text(),

                device: jQuery('#device-data').text(),
                product: jQuery('#product-select').val(),
                location: jQuery('#location-select').val(),

                temporary_table_id: jQuery('#temporary-table-id').val(),
                headers_nr_rows: jQuery('#headers_nr_rows').val(),

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

        jQuery('#generateRecordBtn-12').on('click', function(e) {
            e.preventDefault();

            jQuery("#successBoxAlert").addClass('d-none');
            jQuery('.importBox1').addClass('disableBox');
            jQuery('.importBox3').removeClass('d-none').removeClass('no-opacity');
        });

        jQuery('.btn-automated-action.add-action').click(function(e){
            e.preventDefault();
            // Selecting last id
            var lastname_id = jQuery('.generateDataBox input[type=number]').last().attr('name');
            var split_id = lastname_id.split('_');

            // New index
            var index = Number(split_id[1]) + 1;

            // Create clone
            var newel = jQuery('.generateDataBox:last').clone(true);

            // Set id of new element
            jQuery(newel).find('input[type=number]').eq(0).attr({"id":"rec-gen-data_"+index, "name":"rec-gen-data_"+index});
            jQuery(newel).find('input[type=number]').eq(1).attr({"id":"temp-gen-data_"+index, "name":"temp-gen-data_"+index});
            jQuery(newel).find('input[type=number]').eq(2).attr({"id":"hum-gen-data_"+index, "name":"hum-gen-data_"+index});
            jQuery(newel).find('select').attr({"id":"location-select-gen-data_"+index, "name":"location-select-gen-data_"+index});

            if(!jQuery(newel).find('.btn-gen-box .btn-automated-action.remove-action').length){
                jQuery(newel).find('.btn-gen-box').append('<a href class="btn-automated-action remove-action text-secondary"><i class="fas fa-times-circle"></i></a>');
            }

            // Insert element
            jQuery(newel).insertAfter(".generateDataBox:last");
        });

        jQuery('.generateDataBox').on('click', '.btn-automated-action.remove-action', function(e) {
            e.preventDefault();
            jQuery(this).closest('.generateDataBox').remove();
        });

        jQuery('#generateRecordForm').on('submit', function(e) {
            e.preventDefault();

            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            var params = jQuery.extend({}, doAjax_params_default);
            params['url'] = "{{ route('generate_data') }}";
            params['contentType'] = false;
            params['data'] = new FormData(this);
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    jQuery('#successBoxAlert').html(jQuery('#successBoxAlert').html().replace(/{ID}/g, data.details.id));
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                    jQuery("#generateRecordForm").trigger('reset');
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#generateRecordForm .alert').text(jqXHR.responseText);
                jQuery('#generateRecordForm .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);

        });

        jQuery('#generateRecordForm').on('reset', function(e) {
            e.preventDefault();

            jQuery('.importBox1').removeClass('disableBox');
            jQuery('.importBox3').addClass('no-opacity');
            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            setTimeout(function(){
                jQuery('.importBox3').addClass('d-none');
            }, 600);
        });

    });
</script>
@endsection

