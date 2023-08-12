<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = 
        [
            ['name' =>'shakil','email' =>'shakil@gmail.com' ,'password'=>'123456'],
            ['name' =>'shoriful','email' =>'shoriful@gmail.com' ,'password'=>'123456'],
            ['name' =>'raj','email' =>'raj@gmail.com' ,'password'=>'123456'],
        ];
        User::insert($user); 
    }
}
