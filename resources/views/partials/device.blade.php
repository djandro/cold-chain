<!-- ROW DEVICE -->
<div class="row">
    <div class="col-md-12">
        <div id="devicesBox" class="user-data m-b-30">
            <h3 class="title-3 m-b-30">
                <i class="zmdi zmdi-dock"></i>Devices
            </h3>


            <div class="table-responsive table-data">
                <table id="devices-table" data-classes="table table-hover" data-toggle="table" data-sortable="true" data-sort-class="table-active" data-url="{{ route('settings.devices') }}">
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">Id</th>
                        <th data-field="name" data-sortable="true">Name</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>