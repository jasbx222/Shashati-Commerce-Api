<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
   public function run(){
  User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'role'=>'super-admin',
            'password'=>bcrypt('password')

        ]);
   }

}