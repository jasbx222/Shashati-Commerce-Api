<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $this->call([
        

                 GovernorateSeeder::class,
                 BranchSeeder::class,
                     UserSeeder::class,
                    ClientsSeeder::class,
                    OrderPreparerSeeder::class,
            TermsAndConditionSeeder::class,  
             CategoriesSeeder::class ,
            ProductsSeeder::class,   
            WorkTimeSeeder::class,
            AdsSeeder::class,
            RoleSeeder::class,
            AddressSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class
        
           
        ]);
    }
}