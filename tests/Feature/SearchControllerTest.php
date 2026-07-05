<?php

use App\Models\SearchHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Cache::flush();
});


it('returns search results and records history', function () {
    Http::fake([
        'https://www.omdbapi.com/*' => Http::response([
            'Search' => [['Title' => 'Inception', 'imdbID' => 'tt1375666']],
            'Response' => 'True',
        ], 200),
    ]);

    $response = $this->post('/search', ['query' => 'Inception']);

    $response->assertInertia(
        fn(Assert $page) => $page
            ->component('Index')
            ->where('searchResults.Response', 'True')
            ->where('lastQuery', 'Inception')
    );

    expect(SearchHistory::count())->toBe(1);
});

it('returns an error when movie is not found', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Response' => 'False',
            'Error' => 'Movie not found!',
        ], 200),
    ]);

    $response = $this->post('/search', ['query' => 'asdkjaskdjaskd']);

    $response->assertInertia(
        fn(Assert $page) => $page
            ->where('searchResults.Response', 'False')
            ->where('searchResults.Error', 'Movie not found!')
    );

    expect(SearchHistory::count())->toBe(0);
});

it('requires a query parameter', function () {
    $response = $this->post('/search', []);

    $response->assertSessionHasErrors('query');
});
