<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SearchHistory;

class SiteController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Index', [
            'omdbToken' => session('omdb_token') ?? '',
            'searchHistory' => SearchHistory::forSession(session()->getId()),
        ]);
    }
}
