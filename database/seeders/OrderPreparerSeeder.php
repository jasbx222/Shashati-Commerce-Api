<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\OrderPreparer;
use App\Policies\OrderPolicy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class OrderPreparerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
     
  
            OrderPreparer::create([
                'name'                       => 'jassim',
                'phone'                      => '07853578186' ,
                'branch_id'                      => '1' ,
                'password'=>bcrypt('password'),
                'is_active'                  => true,


 ]);
    
    }
}
