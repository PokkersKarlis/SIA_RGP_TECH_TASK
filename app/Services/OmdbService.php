<?php

namespace App\Services;

use App\Exceptions\OmdbException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OmdbService
{
    public function search(string $query): array
    {
        return Cache::remember(
            'omdb:search:' . md5(strtolower($query)),
            now()->addHours(6),
            fn() => $this->fetch(['t' => $query])
        );
    }

    public function findById(string $imdbId): array
    {
        return Cache::remember(
            "omdb:details:{$imdbId}",
            now()->addDay(),
            fn() => $this->fetch(['i' => $imdbId, 'plot' => 'full'])
        );
    }

    private function fetch(array $params): array
    {
        $response = $this->client()->get('', array_merge($params, [
            'apikey' => $this->apiKey(),
        ]));

        $data = $response->json();

        if (($data['Response'] ?? null) === 'False') {
            throw new OmdbException($data['Error'] ?? 'Unknown OMDB error');
        }

        return $data;
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl('https://www.omdbapi.com')
            ->timeout(5)
            ->retry(2, 100, throw: false);
    }

    private function apiKey(): string
    {
        return session('omdb_token') ?? config('services.omdb.key') ?? '';
    }
}
