<?php

namespace App\Http\Controllers\Api\Admin\contactInfo;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactInfoController extends Controller
{
    /**
     * جلب معلومات الاتصال (يوجد سجل واحد فقط)
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $info = ContactInfo::first();

        return response()->json([
            'data' => $info,
        ]);
    }

    /**
     * تحديث معلومات الاتصال
     *
     * @param Request $request
     * @param ContactInfo $contact
     * @return JsonResponse
     */
    public function update(Request $request, ContactInfo $contact): JsonResponse
    {
        $validated = $request->validate([
            'whatsappLink' => 'required|string|url',
     
        ]);

        $contact->update($validated);

        return response()->json([
            'message' => 'تم تحديث بيانات الاتصال بنجاح',
        ]);
    }


}
