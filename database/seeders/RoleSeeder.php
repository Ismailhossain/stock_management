<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
           [
               [
                'name' => 'Admin',
                'email' =>'admin@gmail.com',
                'type' =>'admin',
                'password' => Hash::make('123456'),
                ],
                [
                'name' => 'Employee',
                'email' =>'employee@gmail.com',
                'type' =>'employee',
                'password' => Hash::make('123456'),
                ],
                [
                'name' => 'Store Executive',
                'email' =>'store_executive@gmail.com',
                'type' =>'store_executive',
                'password' => Hash::make('123456'),
                ]
           ]
        );
    }
}
