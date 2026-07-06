<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SearchHistory extends Model
{
    protected $fillable = ['session_id', 'query'];

    public static function recordFor(string $sessionId, string $query): void
    {
        $alreadyExists = static::where('session_id', $sessionId)
            ->whereRaw('LOWER(query) = ?', [mb_strtolower($query)])
            ->exists();

        if ($alreadyExists) {
            return;
        }

        static::create([
            'session_id' => $sessionId,
            'query' => $query,
        ]);

        $idsToKeep = static::where('session_id', $sessionId)
            ->latest()
            ->limit(5)
            ->pluck('id');

        static::where('session_id', $sessionId)
            ->whereNotIn('id', $idsToKeep)
            ->delete();
    }

    /** @return Collection<int, string> */
    public static function forSession(string $sessionId): Collection
    {
        return static::where('session_id', $sessionId)
            ->latest()
            ->limit(5)
            ->pluck('query');
    }
}
