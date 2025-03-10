<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([

            'name' => 'Hardik Savani',

            'email' => 'admin@gmail.com',

            'password' =>   bcrypt('123456')

        ]);



        $role = Role::create(['name' => 'Admin']);



        $permissions = Permission::pluck('id','id')->all();



        $role->syncPermissions($permissions);



        $user->assignRole([$role->id]);
    }
}
