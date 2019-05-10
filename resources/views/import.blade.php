@extends('layouts.app')

@section('content')


<section class="import">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 importBox1">

                    <form class="form-horizontal" method="post" id="parseRecordForm" action="{{ route('import_parse') }}" enctype="multipart/form-data" accept-charset="UTF-8">
                        {{ csrf_field() }}
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
                    <form class="form-horizontal" method="POST" id="submitRecordForm" action="{{ route('import_process') }}">
                        {{ csrf_field() }}
                        
                        <div class="card border border-secondary">
                            <div class="card-header"><strong>Complete</strong> record data</div>
                            <div class="card-body">

                                <h4 class="display-5">Define headers data:</h4>
                                <div class="csvDataBox m-b-10"></div>

                                <h4 class="display-5">File report:</h4>
                                <div class="otherDataBox row m-b-10">
                                    <div class="col-sm-6">

                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label class="form-control-label">Product</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <p id="product-data" class="form-control-static"></p>
                                            </div>
                                        </div>

                                        <p>Location TBD</p>
                                        <p>ID TBD</p>
                                        <p>No.Samples TBD</p>
                                        <p>Start/End date TBD</p>
                                        <p>Delay time TBD</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="title-input" name="title-input" placeholder="Title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="comment-input" id="comment-input" rows="5" placeholder="Comment..." class="form-control"></textarea>
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
                        jQuery('#parseRecordForm div.alert-danger').removeClass('d-none').text('Something goes wrong.');
                    }
                    else {
                        jQuery('.importBox1').addClass('disableBox');
                        jQuery('.importBox2').removeClass('d-none').removeClass('no-opacity');
                        jQuery('.importBox2 .csvDataBox').html(data.headers_data);
                        jQuery('#title-input').val(data.title);
                        jQuery('#comment-input').val(data.comment);
                        jQuery('#product-data').html(data.product);
                        jQuery('#parseRecordForm div.alert-danger').addClass('d-none');
                    }
                },
                error: function( xhr, status, error ){
                    jQuery('#parseRecordForm div.alert-danger').removeClass('d-none').text(xhr.responseText);
                }
            });
        });

        jQuery('#submitRecordForm').on('reset', function(e) {
            e.preventDefault();
            jQuery('#parseRecordForm').trigger("reset");
            jQuery('.importBox1').removeClass('disableBox');
            jQuery('.importBox2').addClass('no-opacity');
            setTimeout(function(){
                jQuery('.importBox2').addClass('d-none');
            }, 600);
        });

    });
</script>
@endsection

