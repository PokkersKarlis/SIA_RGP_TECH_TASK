<?php

namespace App\Http\Controllers;

use App\Exceptions\OmdbException;
use App\Services\OmdbService;
use Illuminate\Http\JsonResponse;

class MovieDetailsController extends Controller
{
    public function __invoke(string $imdbId, OmdbService $omdb): JsonResponse
    {
        try {
            return response()->json($omdb->findById($imdbId));
        } catch (OmdbException|\Exception $e) {
            return response()->json([
                'Response' => 'False',
                'Error' => $e->getMessage(),
            ], 422);
        }
    }
}
