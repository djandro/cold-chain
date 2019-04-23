<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_manager = new Role();
        $role_manager->name = "manager";
        $role_manager->description = "A Manager Use";
        $role_manager->save();

        $role_admin = new Role();
        $role_admin->name = "admin";
        $role_admin->description = "A Admin Use";
        $role_admin->save();
    }
}
