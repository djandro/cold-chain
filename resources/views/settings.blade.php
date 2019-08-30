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

            @include('partials.product')

            @include('partials.location')

            @include('partials.account')

        </div>
    </div>
</section>
<!-- END SETTINGS-->
@endsection