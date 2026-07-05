<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['token' => 'required|string|max:255']);
        session(['omdb_token' => $request->input('token')]);
        return back();
    }

    public function destroy()
    {
        session()->forget('omdb_token');
        return back();
    }
}
