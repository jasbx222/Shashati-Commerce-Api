<?php


namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder  extends Seeder{



    public function run(){
        Branch::create([
            'title'=>'الرئيسي'
        ]);
        Branch::create([
            'title'=>'الرحمانية'
        ]);
    }
}