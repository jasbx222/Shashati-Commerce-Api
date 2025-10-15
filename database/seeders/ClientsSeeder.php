<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
     
  
            Client::create([
                'name'                       => 'jassim',
                'phone'                      => '07711223344' ,
                'merchant'                      => 'التاجر جاسم محمد' ,
                // 'branch_id'                      => '1' ,
                  'password'=>bcrypt('password'),
                'is_active'                  => true,    
 ]);
    
    }
}
