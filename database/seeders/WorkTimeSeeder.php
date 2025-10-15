<?php


namespace Database\Seeders;

use App\Models\Branch;
use App\Models\WorkTime;
use Illuminate\Database\Seeder;

class WorkTimeSeeder  extends Seeder{



    public function run(){
     WorkTime::create([
            'start_time' => '08:00:00',
            'end_time'   => '17:00:00',
        ]);
    }
}