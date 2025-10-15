<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        return NotificationResource::collection(auth()->user()->notifications);
    }

    public function storeFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => ['required', 'string'],
        ]);

        auth()->user()->update([
            'fcm_token' => $request->fcm_token
        ]);

        return successResponse();
    }

    public function readAllNotifications()
    {
       auth()->user()->notifications()->update([
            'read_at' => now()
        ]);

        return successResponse();
    }
}