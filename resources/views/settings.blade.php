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

            <!-- modal warning delete -->
            <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body"><p></p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-delete-item">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- END SETTINGS-->
@endsection

@section('scripts')
<script src="{{ asset('js/settings.js') }}" type="application/javascript" defer></script>
@endsection