<!-- ROW LOCATIONS -->
<div class="row">
    <div class="col-sm-12">
        <div id="locationsBox" class="user-data m-b-30">
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
                        <th data-field="storage_t" data-formatter="nameFormatter">Storage T</th>
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
                                <option value="green">Green</option>
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