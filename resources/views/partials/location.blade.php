<!-- ROW LOCATIONS -->
<div class="row">
    <div class="col-sm-12">
        <div class="user-data m-b-30">
            <h3 class="title-3 m-b-30">
                <i class="fas fa-map-marker-alt"></i>Locations

                <button class="au-btn au-btn-icon au-btn--green au-btn--small pull-right" data-toggle="modal" data-target="#addLocationModal">
                    <i class="zmdi zmdi-plus"></i>add location
                </button>
            </h3>

            <div class="table-responsive table-data">
                <table id="locations-table" data-classes="table table-hover" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-page-size="5" data-url="{{ route('locations') }}">
                    <thead>
                    <tr>
                        <th data-field="name" data-sortable="true">Name</th>
                        <th data-field="t_alert_min" data-sortable="true" data-formatter="nameFormatter">T_alert_Min</th>
                        <th data-field="t_alert_max" data-sortable="true" data-formatter="nameFormatter">T_alert_Max</th>
                        <th data-field="description">Description</th>
                        <th data-field="color" data-formatter="colorFormatter">Color</th>
                        <th data-field="id" data-formatter="btnFormatter"></th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- modal add location -->
<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <form id="addLocationForm" action="{{ route('locations.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal" _lpchecked="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Add new location</h5>
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
                            <small class="form-text text-muted">Insert a small name of location.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="location-input-storage-min" class="form-control-label">Storage T *</label>
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" step="0.1" id="location-input-t_alert_min" name="location-input-t_alert_min" placeholder="min" class="form-control" required>
                        </div>
                        <div class="col-12 col-sm-2">
                            <input type="number" step="0.1" id="location-input-t_alert_max" name="location-input-t_alert_max" placeholder="min" class="form-control" required>
                        </div>
                        <div class="col-12 offset-sm-3 col-sm-12">
                            <small class="form-text text-muted">Insert a min-max alert temerature of location.</small>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="select" class="form-control-label">Select color</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="location-input-color" id="location-input-color" class="form-control">
                                <option value="yellow">Yellow</option>
                                <option value="red">Red</option>
                                <option value="blue">Blue</option>
                                <option value="orange">Orange</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3 text-right">
                            <label for="location-input-desc" class="form-control-label">Description</label>
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
<!-- end modal add location -->

@section('scripts')
<script type="application/javascript" defer>

    jQuery( document ).ready( function( jQuery ) {

        jQuery('#addLocationModal').on('hidden.bs.modal', function (e) {
            jQuery('#addProductModal .modal-title').text('Add new location');
            jQuery("#addLocationForm").trigger('reset');
            jQuery('#location-input-id').val('');
        });

        // ADD Location
        jQuery('#addLocationForm').on('submit', function(e) {
            e.preventDefault();
            jQuery('.progress.header-progress .progress-bar').removeAttr('style');
            var id = jQuery('#location-input-id').val();
            var params = jQuery.extend({}, doAjax_params_default);

            var tempData = {
                name: jQuery('#location-input-name').val(),
                color: jQuery('#location-input-color').val(),
                description: jQuery('#location-input-desc').val(),
                t_alert_min: jQuery('#location-input-t_alert_min').val(),
                t_alert_max: jQuery('#location-input-t_alert_max').val()
            };

            if(id != '') tempData.id = id;

            params['url'] = "{{ route('locations.store') }}";
            params['data'] = JSON.stringify(tempData);

            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    jQuery("#btnCancelLocationFrom").trigger('click');
                    jQuery("#addLocationForm").trigger('reset');
                    jQuery('#location-input-id').val('');
                    jQuery('#successBoxAlert .successText').text("You successfully save data with ID " + data.details.id);
                    jQuery("#successBoxAlert").removeClass('d-none').addClass('show');
                    jQuery("body").animate({ scrollTop: 0 }, "slow");
                    jQuery('#locations-table').bootstrapTable('refresh');
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#addLocationForm .alert').text(jqXHR.responseText);
                jQuery('#addLocationForm .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);
        });

        // DELETE PRODUCT
        jQuery("#addLocationForm").on('click', "button.btnItemDelete", function(){
            var id = jQuery(this).data("location-id");
            console.log(jQuery(this));
            var params = jQuery.extend({}, doAjax_params_default);
            params['url'] = "/api/locations/delete/"+id;
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
                    jQuery("body").animate({ scrollTop: 0 }, "slow");
                    jQuery('#locations-table').bootstrapTable('refresh');
                    console.log(data);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#settingsAlertBox .alert').text(jqXHR.responseText);
                jQuery('#settingsAlertBox .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);
        });

        // EDIT LOCATION
        jQuery("#addLocationForm").on('click', "button.btnItemEdit", function(){
            jQuery('#addLocationModal').modal('toggle');
            jQuery('#addLocationModal .modal-title').text('Edit location');

            var id = jQuery(this).data("location-id");
            var params = jQuery.extend({}, doAjax_params_default);

            params['url'] = "/api/locations/edit/"+id;
            params['requestType'] = "GET";
            params['successCallbackFunction'] = function( data ) {
                if (data.fail) {
                    // todo print failed data
                    console.log(data.fail);
                }
                else if(data.status == '200'){
                    // print success
                    var storage_t = data.details.storage_t.split(';');
                    jQuery('#location-input-id').val(id);
                    jQuery('#location-input-name').val(data.details.name);
                    jQuery('#location-input-desc').val(data.details.description);
                    jQuery('#location-input-color').val(data.details.color);
                    jQuery('#location-input-t_alert_min').val(storage_t[0]);
                    jQuery('#location-input-t_alert_max').val(storage_t[1]);
                }
            };
            params['errorCallBackFunction'] = function( jqXHR ){
                // todo error print
                jQuery('#settingsAlertBox .alert').text(jqXHR.responseText);
                jQuery('#settingsAlertBox .alert').removeClass('d-none');
                console.log(jqXHR);
            };
            doAjax(params);
        });


    });
</script>
@endsection