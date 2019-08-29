@extends('layouts.app')

@section('content')
<!-- RECORDS-->
<section class="records">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-3">Records</h3>
                    <div class="jumbotron">
                        todo records search filter
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">

                    <div class="table-responsive">

                        <table data-classes="table table-borderless table-striped table-earning" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-pagination="true" data-search="true">

                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="type" data-sortable="true">Type</th>
                                <th data-field="start_date" data-sortable="true">Start Date</th>
                                <th data-field="location">Location</th>
                                <th data-field="product">Product</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($records as $record)

                                <tr>
                                    <td data-field="id">{{ $record->id }}</td>
                                    <td data-field="type">{{ $record->device_id }}</td>
                                    <td data-field="start_date">{{ $record->start_date }}</td>
                                    <td data-field="location">{{ $record->location_id }}</td>
                                    <td data-field="product">{{ $record->product_id }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-primary" href="/records/{{ $record->id }}" role="button"><b>Details</b></a>
                                        <button type="button" class="btn btn-sm btn-outline-link text-secondary">
                                            Delete
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    {{ $records->links() }}
                </div>
            </div>


        </div>
    </div>
</section>
<!-- END STATISTIC-->
@endsection