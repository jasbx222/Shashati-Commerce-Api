<?php

namespace App\Http\Controllers\Api\Admin\WorkTime;

use App\Http\Controllers\Controller;
use App\Models\WorkTime;
use Illuminate\Http\Request;
use PDO;

class WorkTimeController extends Controller
{

    public function store(Request $request) {
        $data = $request->validate([
            'start_time' => 'required|string',
            'end_time'   => 'required|string',
        ]);

        WorkTime::create($data);

        return response()->json([
            'message' => 'تم الاضافة بنجاح'
        ]);
    }
    public function update(Request $request, WorkTime $work_time)
    {
        $data = $request->validate([
            'start_time' => 'required|string',
            'end_time'   => 'required|string',
        ]);

        $work_time->update($data);

        return response()->json([
            'message' => 'تم التحديث بنجاح'
        ]);
    }

    public function index()
    {
        $workTime = WorkTime::first();

        return response()->json([
            'data' => $workTime
        ]);
    }
}
