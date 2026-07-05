<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SiteController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Index',[
            'omdbToken' => session('omdb_token') ?? '',
        ]);
    }
}
