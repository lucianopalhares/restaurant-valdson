<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\RoleUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {/*
        // $this->call(UsersTableSeeder::class);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('12345678');
        $user->save();
        
        $role = new Role();
        $role->name = 'Admin';
        $role->slug = 'admin';
        $role->save();
        
        $roleUser = new RoleUser();
        $roleUser->user_id = $user->id;
        $roleUser->role_id = $role->id;
        $roleUser->save();*/
    }
}
