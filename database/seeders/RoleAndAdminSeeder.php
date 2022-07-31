<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=RoleAndAdminSeeder

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'moderator']);
        Role::create(['name' => 'list_limiter']);
        Role::create(['name' => 'list_reader']);

        $admin = User::create([
            'name' => 'admin',
            'password' => bcrypt('adminxxx'),
            'email' => 'super@admin.com'
        ]);

        $admin->assignRole('admin');
    }
}
