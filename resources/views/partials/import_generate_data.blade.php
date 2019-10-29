<div class="col-sm-12 importBox3 m-t-20">
    <form class="form-horizontal" method="POST" id="generateRecordForm" action="{{ route('save_import') }}" enctype="multipart/form-data" accept-charset="UTF-8">

        <div class="card border border-secondary">
            <div class="card-header"><strong>Generate</strong> record data</div>
            <div class="card-body">

                <div class="otherDataBox row m-b-10">
                    <div class="col-sm-6">
                        <h4 class="display-5">Required data:</h4>
                        <div class="row form-group">
                            <div class="col col-md-3 m-b-10">
                                <input type="hidden" id="user-id-gen-data" name="user-id-gen-data" value="{{ Auth::user()->id }}" />
                                <label class="form-control-label">Product:</label>
                            </div>
                            <div class="col-12 col-md-9 m-b-10">
                                <select name="product-select-gen-data" id="product-select-gen-data" class="form-control">
                                    <option value="5">Govedo</option>
                                    <option value="12">Ribe - brancin</option>
                                    <option value="13">Govedo mleto</option>
                                    <option value="15">Svinina</option>
                                    <option value="17">Tuna</option>
                                </select>
                            </div>

                            <div class="col col-md-3 m-b-10">
                                <label class="form-control-label" for="timestamp-input-gen-data">Start timestamp:</label>
                            </div>
                            <div class="col-12 col-md-9 m-b-10">
                                <input type="text" id="timestamp-input-gen-data" name="timestamp-input-gen-data" placeholder="2019-01-09 00:00:00" class="form-control">
                            </div>

                            <div class="col col-md-3 m-b-10">
                                <label class="form-control-label" for="interval-input-gen-data">Interval:</label>
                            </div>
                            <div class="col-12 col-md-9 m-b-10">
                                <input type="number" id="interval-input-gen-data" name="interval-input-gen-data" placeholder="5" class="form-control">
                            </div>
                        </div>
                    </div>
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


                    <div class="col-sm-12">
                        <hr/>
                    </div>

                    <div class="col-sm-12 generateDataBox form-inline">
                        <label class="form-control-label" for="r1-gen-data-1">R: </label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="r1-gen-data-1" placeholder="0">

                        <label class="sr-only" for="r1-gen-data-1">R2</label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="r2-gen-data-1" placeholder="100">

                        <span class="determiniter">-</span>

                        <label class="form-control-label" for="t-gen-data-1">T: </label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="t-gen-data-1" placeholder="10 C">

                        <label class="form-control-label" for="h-gen-data-1">H: </label>
                        <input type="number" class="form-control mb-2 mr-sm-2" id="h-gen-data-1" placeholder="30 H">

                        <label class="sr-only" for="location-select-gen-data">Locations:</label>
                        <select name="location-select-gen-data" id="location-select-gen-data" class="form-control">
                            <option value="5">Hladilnik 1</option>
                            <option value="12">Hladilnik 2</option>
                        </select>

                        <div class="btn-gen-box">
                            <a href="#" class="btn-automated-action text-success" onclick="return;"><i class="fas fa-plus-circle"></i></a>
                            <a href="#" class="btn-automated-action text-secondary" onclick="return;"><i class="fas fa-times-circle"></i></a>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="alert alert-danger m-b-0 d-none" role="alert"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="generateRecordBtn">
                    <i class="fa fa-plus-circle"></i> Generate Data
                </button>
                <button type="reset" class="btn btn-danger">
                    <i class="fa fa-ban"></i> Reset
                </button>
            </div>
        </div>
    </form>
</div>