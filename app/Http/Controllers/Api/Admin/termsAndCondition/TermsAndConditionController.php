<?php

namespace App\Http\Controllers\Api\Admin\termsAndCondition;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TermsAndConditionController extends Controller
{

    /**
     * عرض جميع الشروط والأحكام
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
$terms = TermsAndCondition::first(); 
        return response()->json([
            'data' => $terms,
        ]);
    }

   
   

 
    /**
     * تحديث شرط موجود
     *
     * @param Request $request
     * @param TermsAndCondition $termsAndCondition
     * @return JsonResponse
     */
    public function update(Request $request, TermsAndCondition $term): JsonResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $term->update($validated);

        return response()->json([
            'message' => 'تم تحديث الشرط بنجاح',
        ]);
    }

}
