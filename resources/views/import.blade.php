@extends('layouts.app')

@section('content')


<section class="import">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 importBox1">

                    <form class="form-horizontal" method="post" id="parseRecordForm" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="card-header"><strong>Import</strong> record data</div>
                            <div class="card-body">
                                <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                    <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                                    <div class="col-md-6">
                                        <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                        @if ($errors->has('csv_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('csv_file') }}</strong>
                                        </span>
                                        @endif
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


                <div class="col-sm-12 importBox2 d-none">
                    <form class="form-horizontal" method="POST" id="submitRecordForm" action="{{ route('import_process') }}">
                        {{ csrf_field() }}

                        <importrecord-component></importrecord-component>

                        <button type="submit" class="btn btn-primary" id="submitRecordBtn">
                            Import Data
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script type="application/javascript" defer>
    jQuery( document ).ready( function( jQuery ) {

        jQuery('#parseRecordForm').on('submit', function(e) {
            e.preventDefault();

            jQuery.ajax({
                type: "POST",
                url: '{{ route('import_parse') }}',
                contentType: false,
                processData: false,
                data: new FormData(this),
                success: function( data ) {
                    if (data.fail) {
                        jQuery('#parseRecordForm span.help-block').text('Something goes wrong.');
                    }
                    else {
                        jQuery('.importBox2').removeClass('d-none');
                        jQuery('.importBox2 .form-horizontal').append(data.csv_data);
                    }
                },
                error: function( xhr, status, error ){
                    jQuery('#parseRecordForm span.help-block').text(xhr.responseText);
                }
            });
        });

    });
</script>
@endsection

