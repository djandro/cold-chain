<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where("name", "viewer")->first();
        $role_manager = Role::where("name", "editor")->first();
        $role_admin  = Role::where("name", "admin")->first();

        $user = new User();
        $user->name = "User";
        $user->email = "user@example.com";
        $user->password = bcrypt("secret");
        $user->approved_at = now();
        $user->save();
        $user->roles()->attach($role_user);

        $manager = new User();
        $manager->name = "Editor";
        $manager->email = "editor@example.com";
        $manager->password = bcrypt("secret");
        $manager->approved_at = now();
        $manager->save();
        $manager->roles()->attach($role_manager);

        $admin = new User();
        $admin->name = "Andraz Hostnik";
        $admin->email = "djandro90@gmail.com";
        $admin->password = bcrypt("secret");
        $admin->approved_at = now();
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
