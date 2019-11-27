<div class="col-sm-12 importBox3 m-t-20 d-none no-opacity">
    <form class="form-horizontal" method="POST" id="generateRecordForm" action="{{ route('generate_data') }}" enctype="multipart/form-data" accept-charset="UTF-8">

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
                                <select name="product-select-gen-data" id="product-select-gen-data" class="form-control" required>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col col-md-3 m-b-10">
                                <label class="form-control-label" for="timestamp-input-gen-data">Start timestamp:</label>
                            </div>
                            <div class="col-12 col-md-9 m-b-10">
                                <input type="datetime" id="timestamp-input-gen-data" name="timestamp-input-gen-data" value="{{ Carbon\Carbon::now()->toDateTimeString() }}" class="form-control" aria-required="true" required>
                            </div>

                            <div class="col col-md-3 m-b-10">
                                <label class="form-control-label" for="interval-input-gen-data">Interval (s):</label>
                            </div>
                            <div class="col-12 col-md-9 m-b-10">
                                <input type="number" id="interval-input-gen-data" name="interval-input-gen-data" placeholder="60" min="1" step="1" class="form-control" aria-required="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h4 class="display-5">Title:</h4>
                        <div class="form-group">
                            <input type="text" id="title-input" name="title-input" placeholder="Title" class="form-control" required>
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

                        <div class="form-group">
                            <label class="form-control-label" for="rec-gen-data_1">Records: </label>
                            <input type="number" class="form-control my-1 mr-2 ml-2" name="rec-gen-data_1" id="rec-gen-data_1" placeholder="100" min="1" step="1" aria-required="true" required>
                        </div>

                        <span class="determiniter">-</span>

                        <div class="form-group">
                            <label class="form-control-label" for="temp-gen-data_1">Temp: </label>
                            <input type="number" class="form-control my-1 mr-2 ml-2" name="temp-gen-data_1" id="temp-gen-data_1" placeholder="10 C" step="0.01" aria-required="true" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="hum-gen-data_1">Hum: </label>
                            <input type="number" class="form-control my-1 mr-2 ml-2" name="hum-gen-data_1" id="hum-gen-data_1" placeholder="30 H" step="0.01" aria-required="true" required>
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="location-select-gen-data_1">Locations:</label>
                            <select name="location-select-gen-data_1" id="location-select-gen-data_1" class="form-control my-1 mr-2 ml-2">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="btn-gen-box my-1 ml-3">
                            <a href class="btn-automated-action add-action text-success"><i class="fas fa-plus-circle"></i></a>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="alert alert-danger m-t-20 m-b-0 d-none" role="alert"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="generateRecordBtn">
                    <i class="fa fa-plus-circle"></i> Generate Data
                </button>
                <button type="reset" class="btn btn-danger" id="generateRecordBtnReset">
                    <i class="fa fa-ban"></i> Cancel
                </button>
            </div>
        </div>
    </form>
</div>