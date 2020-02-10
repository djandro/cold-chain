@extends('layouts.app')

@section('content')
<!-- STATISTIC-->
<section class="statistic">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $records_count }}</h2>
                        <span class="desc">records in database</span>
                        <div class="icon">
                            <i class="zmdi zmdi-chart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $products_count }}</h2>
                        <span class="desc">products</span>
                        <div class="icon">
                            <i class="zmdi zmdi-collection-text"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $locations_count }}</h2>
                        <span class="desc">locations</span>
                        <div class="icon">
                            <i class="zmdi zmdi-pin"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $devices_count }}</h2>
                        <span class="desc">devices</span>
                        <div class="icon">
                            <i class="zmdi zmdi-smartphone"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $users_count }}</h2>
                        <span class="desc">users</span>
                        <div class="icon">
                            <i class="zmdi zmdi-account-o"></i>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->hasRole('admin'))
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $users_for_approve }}</h2>
                        <span class="desc">users for approve</span>
                        <div class="icon">
                            <i class="zmdi zmdi-account-o"></i>
                        </div>
                    </div>
                </div>
                @endif
            </div>


            <div class="row">
                <div class="col-sm-12">

                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    TODO: <br/>
                    - count records in Alarms <br/>
                    - count records in Error <br/>


                    <br/>

                    You are logged in!
                </div>
            </div>


        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection
