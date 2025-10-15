<?php

namespace App\Http\Service\Admin\governorate;

use App\Models\Governorate;

class GovernorateService
{


    public function index()
    {
        return response()->json([
            'data' => Governorate::all()
        ], 200);
    }


    public function update(array $data, $governorate)
    {
        $governorate->update($data);
        return response()->json([
            'messsage' => 'updated success'
        ]);
    }
}
