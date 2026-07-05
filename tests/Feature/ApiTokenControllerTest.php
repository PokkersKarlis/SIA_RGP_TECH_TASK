<?php

it('saves the token to session', function () {
    $this->post('/api-token', ['token' => 'my-secret-key']);

    expect(session('omdb_token'))->toBe('my-secret-key');
});

it('clears the token from session', function () {
    session(['omdb_token' => 'my-secret-key']);

    $this->delete('/api-token');

    expect(session('omdb_token'))->toBeNull();
});

it('validates token is required', function () {
    $response = $this->post('/api-token', []);

    $response->assertSessionHasErrors('token');
});
