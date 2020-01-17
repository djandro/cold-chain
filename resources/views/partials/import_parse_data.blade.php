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
                            <input type="text" id="title-input-parseForm" name="title-input-parseForm" placeholder="Title" class="form-control">
                        </div>
                        <h4 class="display-5">Comment:</h4>
                        <div class="form-group">
                            <textarea name="comment-input-parseForm" id="comment-input-parseForm" rows="5" placeholder="Comment..." class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="display-5">File report:</h4>
                        <div class="row form-group">
                            <div class="col col-md-3 m-b-10">
                                <input type="hidden" id="temporary-table-id" name="temporary-table-id" />
                                <input type="hidden" id="headers_nr_rows" name="headers_nr_rows" />
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
                                <label class="form-control-label">Delay time (s):</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="delay-data" class="form-control-static badge badge-light"></p>
                            </div>

                            <div class="col col-md-3">
                                <label class="form-control-label">Interval (s):</label>
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