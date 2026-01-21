<?php


namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name'=>'Super Admin']);
        $admin      = Role::firstOrCreate(['name'=>'Admin']);
        $staff      = Role::firstOrCreate(['name'=>'Staff']);

        $permissions = [

            ['module'=>'Dashboard','name'=>'view-dashboard'],

            // Inventory
            ['module'=>'Motorcycle','name'=>'motorcycle-list'],
            ['module'=>'Motorcycle','name'=>'add-motorcycle'],
            ['module'=>'Motorcycle','name'=>'edit-motorcycle'],
            ['module'=>'Motorcycle','name'=>'delete-motorcycle'],
            ['module'=>'Motorcycle','name'=>'csv-motorcycle'],

            // add on
            ['module'=>'Add On','name'=>'addon-list'],
            ['module'=>'Add On','name'=>'add-addon'],
            ['module'=>'Add On','name'=>'edit-addon'],
            ['module'=>'Add On','name'=>'delete-addon'],



            // brands
            ['module'=>'Brands','name'=>'brand-list'],
            ['module'=>'Brands','name'=>'add-brand'],
            ['module'=>'Brands','name'=>'edit-brand'],
            ['module'=>'Brands','name'=>'delete-brand'],
            

            // Tours
            ['module'=>'Tours','name'=>'tour-list'],
            ['module'=>'Tours','name'=>'add-tour'],
            ['module'=>'Tours','name'=>'edit-tour'],
            ['module'=>'Tours','name'=>'delete-tour'],

            // motor Bookings
            ['module'=>'Motorcycle Booking','name'=>'motorcycle-booking-list'],
            ['module'=>'Motorcycle Booking','name'=>'add-motorcycle-booking'],
            ['module'=>'Motorcycle Booking','name'=>'edit-motorcycle-booking'],
            ['module'=>'Motorcycle Booking','name'=>'delete-motorcycle-booking'],


            // tour bookings
            ['module'=>'Tour Booking','name'=>'tour-booking-list'],
            ['module'=>'Tour Booking','name'=>'add-tour-booking'],
            ['module'=>'Tour Booking','name'=>'edit-tour-booking'],
            ['module'=>'Tour Booking','name'=>'delete-tour-booking'],

            // Customers
            ['module'=>'Customers','name'=>'customer-list'],
            ['module'=>'Customers','name'=>'add-customer'],
            ['module'=>'Customers','name'=>'edit-customer'],
            ['module'=>'Customers','name'=>'delete-customer'],

            // Users
            ['module'=>'Users','name'=>'user-list'],
            ['module'=>'Users','name'=>'add-user'],
            ['module'=>'Users','name'=>'edit-user'],
            ['module'=>'Users','name'=>'delete-user'],

            // Roles
            ['module'=>'Roles & Permission','name'=>'role-list'],
            ['module'=>'Roles & Permission','name'=>'add-role'],
            ['module'=>'Roles & Permission','name'=>'delete-role'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name'=>$perm['name'], 'guard_name'=>'web'],
                ['module'=>$perm['module']]
            );
        }

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions(
            Permission::whereNotIn('name',['delete-role'])->get()
        );

        $staff->syncPermissions([
            'view-dashboard',
            'motorcycle-list',
            'customer-list',
        ]);
    }
}

