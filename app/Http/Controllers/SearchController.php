<?php

namespace App\Http\Controllers;

use App\Exceptions\OmdbException;
use App\Models\SearchHistory;
use App\Services\OmdbService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function __invoke(Request $request, OmdbService $omdb): Response
    {
        $request->validate(['query' => 'required|string|max:255']);

        $query = $request->input('query');
        $sessionId = $request->session()->getId();

        try {
            $results = $omdb->search($query);
            SearchHistory::recordFor($sessionId, $query);
        } catch (OmdbException $e) {
            $results = ['Response' => 'False', 'Error' => $e->getMessage()];
        } catch (\Exception $e) {
            $results = ['Response' => 'False', 'Error' => 'UNKNOWN_ERROR'];
        }

        return Inertia::render('Index', [
            'omdbToken' => session('omdb_token'),
            'searchResults' => $results,
            'searchHistory' => SearchHistory::forSession($sessionId),
            'lastQuery' => $query,
        ]);
    }
}
