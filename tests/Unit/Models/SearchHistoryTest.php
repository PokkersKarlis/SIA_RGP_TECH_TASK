<?php

use App\Models\SearchHistory;

it('records a new search query', function () {
    SearchHistory::recordFor('session-1', 'Inception');

    expect(SearchHistory::where('session_id', 'session-1')->count())->toBe(1);
});

it('does not store duplicate queries case-insensitively', function () {
    SearchHistory::recordFor('session-1', 'Inception');
    SearchHistory::recordFor('session-1', 'inception');
    SearchHistory::recordFor('session-1', 'INCEPTION');

    expect(SearchHistory::where('session_id', 'session-1')->count())->toBe(1);
});

it('keeps only the last 5 searches per session', function () {
    foreach (['One', 'Two', 'Three', 'Four', 'Five', 'Six'] as $query) {
        SearchHistory::recordFor('session-1', $query);
    }

    $remaining = SearchHistory::forSession('session-1');

    expect($remaining)->toHaveCount(5)
        ->and($remaining->first())->toBe('Six')
        ->and($remaining)->not->toContain('One');
});

it('isolates history between different sessions', function () {
    SearchHistory::recordFor('session-1', 'Inception');
    SearchHistory::recordFor('session-2', 'Interstellar');

    expect(SearchHistory::forSession('session-1'))->toEqual(collect(['Inception']))
        ->and(SearchHistory::forSession('session-2'))->toEqual(collect(['Interstellar']));
});
