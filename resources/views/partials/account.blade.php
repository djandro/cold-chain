<!-- ROW ACCOUNT -->
<div class="row">
    <div class="col-md-12">
        <div id="accountsBox" class="user-data m-b-30">
            <h3 class="title-3 m-b-30">
                <i class="zmdi zmdi-account-calendar"></i>user data
            </h3>


            <div class="table-responsive table-data">
                <table id="account-table" data-classes="table table-hover" data-toggle="table" data-url="{{ route('settings.users') }}">
                    <thead>
                    <tr>
                        <th class="table-data__info" data-field="name" data-formatter="settingsUserName">Name</th>
                        <th data-field="roles" data-formatter="settingsUserRoles">Role</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>