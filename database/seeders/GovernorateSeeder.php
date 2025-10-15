<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
     /**
     * Run the database seeds.
     */
    public function run()
    {
        $governorats = [
            "دهوك",
            "أربيل",
            "السليمانية",
            "كركوك",
            "بغداد",
            "الأنبار",
            "نينوى",
            "صلاح الدين",
            "المثنى",
            "البصرة",
            "ميسان",
            "واسط",
            "كربلاء",
            "بابل",
            "النجف",
            "الديوانية",
            "ذي قار"
        ];

        foreach ($governorats as $governorat) {
            Governorate::create([
                'name' => $governorat,
            ]);
        }
    }
}
