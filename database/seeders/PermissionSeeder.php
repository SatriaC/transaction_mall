<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'boarding-list']);
         Permission::create(['name' => 'boarding-add']);
         Permission::create(['name' => 'boarding-update']);
         Permission::create(['name' => 'boarding-delete']);
         Permission::create(['name' => 'boarding-show']);
         Permission::create(['name' => 'boarding-search']);
         Permission::create(['name' => 'boarding-availability']);

         // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'user']);
        $role1->givePermissionTo('boarding-show');
        $role1->givePermissionTo('boarding-search');
        $role1->givePermissionTo('boarding-availability');
        $role2 = Role::create(['name' => 'owner']);
        $role2->givePermissionTo('boarding-list');
        $role2->givePermissionTo('boarding-add');
        $role2->givePermissionTo('boarding-update');
        $role2->givePermissionTo('boarding-delete');


        // create demo users
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => bcrypt('1234567890'),
            'phone' => '081234567890',
            'profession' => 'Student',
            'gender' => 'male',
            'birthdate' => '1999-07-23',
            'isPremium' => 1,
            'credits' => 40
        ]);
        $user->assignRole($role1);

        $user1 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@test.com',
            'password' => bcrypt('1234567890'),
            'phone' => '081234567899',
            'profession' => 'Student',
            'gender' => 'female',
            'birthdate' => '1999-07-24',
            'isPremium' => 0,
            'credits' => 20
        ]);
        $user1->assignRole($role1);

        $user2 = User::create([
            'name' => 'Peter Parkour',
            'email' => 'peter@test.com',
            'password' => bcrypt('1234567890'),
            'phone' => '081234567891',
            'profession' => '',
            'gender' => 'male',
            'birthdate' => '1999-07-23',
            'isPremium' => 0,
            'credits' => 0
        ]);
        $user2->assignRole($role2);


    }
}
