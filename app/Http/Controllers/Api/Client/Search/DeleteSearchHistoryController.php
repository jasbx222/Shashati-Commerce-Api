<?php

namespace App\Http\Controllers\Api\Client\Search;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use Illuminate\Http\Request;

class DeleteSearchHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SearchHistory $searchHistory)
    {
        $searchHistory->delete();

        return successResponse('تم بنجاح');
    }
}
