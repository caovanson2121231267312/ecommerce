<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-menu',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'role-menu',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'permission-menu',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // \App\Models\User::factory(10)->create();
        $faker = FakerFactory::create();
        $minDate = '1978-03-27';
        $maxDate = '2023-04-23';
        $user = User::create([
            "name" => "cao văn sơn",
            "email" => "son1669063793@gmail.com",
            "phone_number" => "0338910238",
            "password" => bcrypt('123123123'),
            "dob" => '2001-06-11',
        ]);
        $role = Role::create(['name' => 'Super-Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Technical support']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


        // Tạo 10 user
        for ($i = 0; $i < 1000000; $i++) {
            $user = new User;
            $user->name = $faker->name;
            $user->email = $faker->unique()->email;
            $user->password = bcrypt('password');
            $user->dob = $faker->dateTimeBetween($minDate, $maxDate)->format('Y-m-d');;
            $user->phone_number = $faker->phoneNumber;
            $user->save();

            $k = rand(1, 3);
            for ($k; $k > 0; $k--) {
                $user->assignRole([rand(1, 3)]);
            }
        }
    }
}
