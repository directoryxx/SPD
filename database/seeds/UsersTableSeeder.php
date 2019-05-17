<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'roles' => 1
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'manager@gmail.com',
            'password' => bcrypt('secret'),
            'roles' => 2
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('secret'),
            'roles' => 3
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('secret'),
            'roles' => 4
        ]);
    }
}
