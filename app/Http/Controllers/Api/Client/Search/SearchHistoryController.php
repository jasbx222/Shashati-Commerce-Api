<?php

namespace App\Http\Controllers\Api\Client\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\Search\SearchHistoryResource;
use App\Models\SearchHistory;
use Illuminate\Http\Request;

class SearchHistoryController extends Controller
{
    /**
     * Handle the incoming request to retrieve the last 10 search history entries for the client.
     */
    public function __invoke(Request $request)
    {
        $client = auth()->user();

        $searchHistory = SearchHistory::where('client_id', $client->id)
            ->latest()
            ->take(10)
            ->get();
        
        return SearchHistoryResource::collection($searchHistory);
    }
}
