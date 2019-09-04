@extends('layouts.app')

@section('content')
<!-- SETTINGS -->
<section class="settings modal_on_page">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-3">Settings</h3>
                </div>
            </div>

            @if ($errors->any())
            <div id="settingsAlertBox" class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger m-t-10 m-b-30" role="alert">
                        <ul id="errors">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="sufee-alert alert with-close alert-success alert-dismissible m-t-10 m-b-30 fade d-none" id="successBoxAlert">
                        <span class="badge badge-pill badge-success">Success</span>
                        <span class="successText">You successfully save data with ID {ID}.</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                </div>
            </div>

            @include('partials.product')

            @include('partials.location')

            @include('partials.account')

        </div>
    </div>
</section>
<!-- END SETTINGS-->
@endsection

@section('scripts')
<script src="{{ asset('js/settings.js') }}" type="application/javascript" defer></script>
@endsection