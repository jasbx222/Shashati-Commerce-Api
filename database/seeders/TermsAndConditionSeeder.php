<?php

namespace Database\Seeders;

use App\Models\TermsAndCondition;
use Illuminate\Database\Seeder;

class TermsAndConditionSeeder extends Seeder
{
     /**
     * Run the database seeds.
     */
    public function run()
    {

      TermsAndCondition::create([
            'title'=>'test',
            'content'=>'test'
        ]);
       

      
    }
}
