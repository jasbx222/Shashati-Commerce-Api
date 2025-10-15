<?php


namespace Database\Seeders;

use App\Models\Ads;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class AdsSeeder  extends Seeder{



    public function run(){
        Ads::create([
            'title'=>'ads one',
        'image'=>null,
        'type'=>'slider',
        'video_url'=>'http://localhost:5173',
        'product_id'=>3,

        ]);
    }
}