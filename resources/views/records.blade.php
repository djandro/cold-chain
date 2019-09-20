@extends('layouts.app')

@section('content')
<!-- RECORDS-->
<section class="records">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-3">Records</h3>
                    <div class="jumbotron">
                        todo records search filter
                    </div>
                </div>
            </div>

            @include('partials.alertbox')

            <div class="row">
                <div class="col-sm-12">

                    <div class="table-responsive">

                        <table id="recordListTable" data-classes="table table-borderless table-striped table-earning" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-search="true">

                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="type" data-sortable="true">Type</th>
                                <th data-field="start_date" data-sortable="true">Start Date</th>
                                <th data-field="location">Location</th>
                                <th data-field="product">Product</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($records as $record)

                                <tr id="recordRow-{{ $record->id }}">
                                    <td data-field="id">{{ $record->id }}</td>
                                    <td data-field="type">{{ $record->device_id }}</td>
                                    <td data-field="start_date">{{ $record->start_date }}</td>
                                    <td data-field="location">{{ $record->location_id }}</td>
                                    <td data-field="product">{{ $record->product_id }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="/records/{{ $record->id }}" role="button"><b>Details</b></a>
                                        <button type="button" class="btn btn-sm btn-outline-link text-secondary" data-toggle="modal" data-target="#deleteRecordModal" data-backdrop="false" data-recordid="{{ $record->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    {{ $records->links() }}
                </div>
            </div>

            <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body"><p></p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-delete-record">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection

@section('scripts')
<script>
    jQuery( document ).ready( function( jQuery ) {
        jQuery('#deleteRecordModal').on('show.bs.modal', function (event) {
            var button = jQuery(event.relatedTarget);
            var recordId = button.data('recordid');
            var modal = jQuery(this);
            modal.data('recordid', recordId);
            modal.find('.modal-body p').text("Are you sure you want to delete record " + recordId + "?");
        });
        // DELETE RECORD
        jQuery("#deleteRecordModal").on('click', "button.btn-delete-record", function(){
            var $modal = jQuery("#deleteRecordModal");
            var id = $modal.data("recordid");
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
                    jQuery('#successBoxAlert .successText').text("You successfully delete data with ID " + data.id);
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    jQuery('#recordRow-' + id).remove();
                    console.log(data);
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
    });
</script>
@endsection