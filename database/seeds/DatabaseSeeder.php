<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\RoleUser;
use App\Restaurant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('12345678');
        $user->save();
        
        $admin = new Role();
        $admin->id = '1';
        $admin->name = 'Admin';
        $admin->slug = 'admin';
        $admin->save();
        
        $cliente = new Role();
        $cliente->id = '2';
        $cliente->name = 'Cliente';
        $cliente->slug = 'cliente';
        $cliente->save();
        
        $userAdmin = new RoleUser();
        $userAdmin->user_id = $user->id;
        $userAdmin->role_id = $admin->id;
        $userAdmin->save();
                
        $restaurant = new Restaurant();
        $restaurant->name = 'Restaurant Test';
        $restaurant->slug = str_slug($restaurant->name);
        $restaurant->address = 'Rua Almeida Prado';
        $restaurant->number = '88';
        $restaurant->district = 'Sao Carlos';
        $restaurant->state = 'SP';
        $restaurant->city = 'Sao Paulo';
        $restaurant->opening_hours_start = '08:00';
        $restaurant->opening_hours_end = '17:00';
        $restaurant->phone = '(11)94589-89898';
        $restaurant->mobile = '(11)94589-89898';
        $restaurant->whatsapp = '(11)94589-89898';
        $restaurant->logo = 'default.png';
        $restaurant->logo_path = 'public/frontend/images/restaurants';
        $restaurant->cnpj = '4548484848484848';
        $restaurant->insc_est = '4545554585488594465';
        $restaurant->about_us = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sodales, nisi non pharetra gravida, risus nisl fringilla ligula, sed laoreet diam dui nec ipsum. Nulla maximus tristique leo, id interdum ex sagittis sed. Quisque dui erat, euismod quis mollis sit amet, posuere ut neque. Curabitur vehicula tristique dolor, eget ultrices nisl efficitur et. Aenean non accumsan nisl. Curabitur felis tellus, vulputate dignissim pellentesque non, interdum suscipit erat. Quisque vulputate sapien nec elementum interdum. Sed lacus neque, placerat et vulputate vitae, tincidunt vel sem. Nam semper dolor vel convallis euismod. Nunc tincidunt, neque a finibus hendrerit, magna dui fringilla ante, id eleifend quam mauris.';
        $restaurant->save();
    }
}
