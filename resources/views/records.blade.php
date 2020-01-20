@extends('layouts.app')

@section('content')
<!-- RECORDS-->
<section class="records">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <h3 class="mb-3">Records</h3>
            <div class="row">
                <div class="col-sm-12">

                    <h5 class="mt-4 mb-2">Filters:</h5>
                    <div class="jumbotron filter-box">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group search-form-group">
                                    <label for="recordSearch" class="form-control-label">Keywords</label>
                                    <input name="search" type="hidden" id="recordSearch" placeholder="Insert search keyword" class="form-control">
                                </div>

                                <p class="form-control-label">Devices</p>
                                <ul class="nav nav-pills" id="filter-device-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-outline-secondary active show" id="device-all-tab" data-toggle="pill" href="#device-all-tab"  onclick="onDropDownFilter(this, 'device')" role="tab" aria-controls="device-all-tab" aria-selected="true">All</a>
                                    </li>
                                    @foreach (getDevices() as $device)
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-outline-secondary" id="device-{{$device->id}}-tab" data-toggle="pill" href="#device-{{$device->id}}-tab" onclick="onDropDownFilter(this, 'device')" role="tab" aria-controls="device-{{$device->id}}-tab" aria-selected="false">{{ $device->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>

                            </div>
                            <div class="col-sm-3 offset-sm-1">
                                <div class="form-group">
                                    <label for="productFilterSelect" class="form-control-label">Product</label>
                                    <select name="productFilterSelect" id="productFilterSelect" class="form-control-sm form-control" onchange="onDropDownFilter(this, 'product');">
                                        <option value="0">All</option>
                                        @foreach (getProducts() as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="locationFilterSelect" class="form-control-label">Location</label>
                                    <select name="locationFilterSelect" id="locationFilterSelect" class="form-control-sm form-control" onchange="onDropDownFilter(this, 'location');">
                                        <option value="0">All</option>
                                        @foreach (getLocations() as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="button" id="filterClearBtn" class="btn btn-outline-link btn-sm text-secondary float-right">
                                    <i class="zmdi zmdi-delete"></i> Clear filters
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @include('partials.alertbox')

            <div class="row">
                <div class="col-sm-12">

                    <div class="table-responsive">

                        <table id="recordListTable" data-classes="table table-borderless table-striped table-earning"
                               data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true"
                               data-search="true" data-filter-control="true" data-toolbar=".filter-box">

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
                            @foreach (getRecords() as $record)

                                <tr id="recordRow-{{ $record->id }}">
                                    <td data-field="id">{{ $record->id }}</td>
                                    <td data-field="type">{{ $record->device['name'] }}</td>
                                    <td data-field="start_date">{{ $record->start_date }}</td>
                                    <td data-field="location">{{ $record->location['name'] }}</td>
                                    <td data-field="product">{{ $record->product['name'] }}</td>
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
                    {{ getRecords()->links() }}
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
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/filter-control/bootstrap-table-filter-control.min.js" crossorigin="anonymous"></script>
<script>
    jQuery( document ).ready( function( jQuery ) {
        var $table = jQuery('#recordListTable');

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

        // filter reset btn
        jQuery("#filterClearBtn").click(function () {
            jQuery('#recordSearch').val('');
            jQuery('.table-responsive .search-input').val('');
            jQuery("#device-all-tab").trigger('click');
            jQuery("#productFilterSelect").val(0).attr("selected","selected");
            jQuery("#locationFilterSelect").val(0).attr("selected","selected");
            $table.bootstrapTable('resetSearch');
        });

    });

    // filter function for device, product and location
    function onDropDownFilter(element, selectObj){
        var $table = jQuery('#recordListTable');
        var $el = jQuery(element).find(':selected').text();
        var filter = 'and';
        var obj = { product: [$el] };

        if(selectObj == 'device') { $el = jQuery(element).text(); obj = { type: [$el] } }
        if(selectObj == 'location') { obj = { location: [$el] }; }
        if($el == 'All') { filter = function(){ return true; } }

        $table.bootstrapTable('refreshOptions', {
            filterOptions: {
                filterAlgorithm: filter
            }
        });
        $table.bootstrapTable('filterBy', obj);
    }

</script>
@endsection