<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger m-t-10 m-b-30 d-none" role="alert" id="errorAlertBox">
            @if ($errors->any())
            <ul id="errors">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    <div class="col-sm-12">
        <div class="sufee-alert alert with-close alert-success alert-dismissible m-t-10 m-b-30 fade d-none" role="alert" id="successBoxAlert">
            <span class="badge badge-pill badge-success">Success</span>
            <span class="successText">You successfully save data with ID {ID}.</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
            </button>
        </div>
    </div>

    @if (session('status'))
    <div class="col-sm-12">
        <div class="sufee-alert alert with-close alert-success alert-dismissible m-t-10 m-b-30" role="alert">
            <span class="successText">{{ session('status') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
            </button>
        </div>
    </div>
    @endif

</div>