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

            @include('partials.alertbox')

            @include('partials.product')

            @include('partials.location')

            @include('partials.device')

            @include('partials.account')

        </div>
    </div>
</section>
<!-- END SETTINGS-->
@endsection

@section('scripts')
<script src="{{ asset('js/settings.js') }}" type="application/javascript" defer></script>
@endsection