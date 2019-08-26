@extends('layouts.app')

@section('content')
<!-- RECORD -->
<section class="record">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-3">Record {{ $record->id }}</h3>
                    <div class="jumbotron">
                        todo record comments, buttons
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <p>{{ $record }}</p>
                </div>
            </div>


        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection