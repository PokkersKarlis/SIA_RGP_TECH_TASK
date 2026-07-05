<?php

use App\Exceptions\OmdbException;
use App\Services\OmdbService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('returns search results on successful response', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Search' => [
                ['Title' => 'Inception', 'Year' => '2010', 'imdbID' => 'tt1375666', 'Type' => 'movie', 'Poster' => 'N/A'],
            ],
            'Response' => 'True',
        ], 200),
    ]);

    $service = new OmdbService();
    $result = $service->search('Inception');

    expect($result['Response'])->toBe('True')
        ->and($result['Search'])->toHaveCount(1)
        ->and($result['Search'][0]['Title'])->toBe('Inception');
});

it('throws OmdbException when movie is not found', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Response' => 'False',
            'Error' => 'Movie not found!',
        ], 200),
    ]);

    $service = new OmdbService();
    $service->search('asdkjaskdjaskd');
})->throws(OmdbException::class, 'Movie not found!');

it('caches search results between calls', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Search' => [['Title' => 'Inception']],
            'Response' => 'True',
        ], 200),
    ]);

    $service = new OmdbService();
    $service->search('Inception');
    $service->search('Inception');

    Http::assertSentCount(1);
});
