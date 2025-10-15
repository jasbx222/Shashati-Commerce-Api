<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addresses')->insert([
            [
                'client_id' => 1,
                'governorate_id' => 1,
                'longitude' => '44.4215',
                'latitude' => '33.3152',
                'created_at' => now(),
                'updated_at' => now(),
            ],
          
        ]);
    }
}
