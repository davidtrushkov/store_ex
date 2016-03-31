<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'davidisback4good@hotmail.com',
            'password' => Hash::make('d16331633'),
            'name' => 'John Doe',
            'admin'=>0
        ));

        User::create(array(
            'email' => 'admin@store.com',
            'password' => Hash::make('password'),
            'name' => 'Jeniffer Taylor',
            'admin'=>1
        ));

    }

}