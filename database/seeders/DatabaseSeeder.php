<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $this->call(RolesPermissionsSeeder::class);

       
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'status' => 'active', 
            ]
        );

        
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole($superAdminRole);
        }
    }
}
